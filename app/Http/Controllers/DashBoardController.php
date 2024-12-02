<?php

namespace App\Http\Controllers;
use App\Models\HoaDon;
use App\Models\Phong;
use App\Models\User;
use App\Models\HopDong;
use App\Models\LienHeDatPhong;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DashBoardController extends Controller
{
    public function total()
    {
        $total_contract = HopDong::count();
        $total_user = User::count();
        $total_contact = LienHeDatPhong::count();
        
        return response()->json([
           'total_contract' => $total_contract,
           'total_user' => $total_user,
           'total_contact_room' => $total_contact,
        ], 200);
    }
    public function thongke(Request $request)
    {
        // Lấy tham số từ request, nếu không có thì mặc định là tháng và năm hiện tại
        $thang = $request->input('thang'); // Tháng (tuỳ chọn)
        $nam = $request->input('nam', Carbon::now()->year); // Năm (mặc định là năm hiện tại)
    
        // Xây dựng query cơ bản
        $query = HoaDon::selectRaw('
                SUM(tien_thue 
                    + (tien_dien * so_ki_dien) 
                    + (tien_nuoc * so_khoi_nuoc) 
                    + (tien_xe * so_luong_xe) 
                    + (tien_dich_vu * so_luong_nguoi)
                ) as tong_doanh_thu 
            ')
            ->where('trang_thai', 1); // Chỉ lấy những hóa đơn có trạng thái = 1
        
        // Nếu người dùng chọn tháng
        if ($thang) {
            $query->whereMonth('created_at', $thang); // Lọc theo tháng
        }
    
        // Lọc theo năm
        $query->whereYear('created_at', $nam); // Lọc theo năm
    
        // Lấy kết quả
        $doanhThu = $query->first();
    
        // Trả về kết quả
        return response()->json([
            'thang' => $thang ?? null,  // Nếu không có tháng thì trả về null
            'nam' => $nam,
            'tong_doanh_thu' => $doanhThu ? $doanhThu->tong_doanh_thu : 0, // Trả về tổng doanh thu, nếu không có kết quả thì trả về 0
        ]);
    }
    public function lienhe()
    {
        // Lấy danh sách liên hệ chưa được xử lý (trang_thai = 0), giới hạn 5 bản ghi và sắp xếp theo created_at DESC
        $list = LienHeDatPhong::where('trang_thai', 0) // Lọc theo trạng thái chưa xử lý
            ->orderBy('created_at', 'ASC') // Sắp xếp theo created_at tăng dần, tức là cũ nhất để lên đầu
            ->limit(5) // Giới hạn 5 bản ghi
            ->get(); // Lấy danh sách
    
        if ($list->isEmpty()) {
            return response()->json(['message' => 'Không có liên hệ nào chưa được xử lý.'], 404);
        }
    
        // Tùy chỉnh tên các key
        $data = $list->map(function ($item) {
            // Lấy thông tin phòng và người dùng
            $room = Phong::withTrashed()->where('id', $item->phong_id)->get(['ten_phong', 'hinh_anh'])->first();
            $user = User::withTrashed()->where('id', $item->tai_khoan_id)->get(['name', 'avatar'])->first();
    
            return [
                'id' => $item->id,
                'state' => $item->trang_thai ? 'Đã xử lí' : 'Chưa xử lí',
                'id_room' => $item->phong_id,
                'name_room' => $room->ten_phong,
                'image_room' => Str::before($room->hinh_anh, ';'),
                'id_user' => $item->tai_khoan_id,
                'name_user' => $user->name,
                'avatar_user' => $user->avatar ?? 'avatar/user_default.png',
                'name' => $item->ho_ten,
                'phone' => $item->so_dien_thoai,
                'content' => $item->noi_dung ?? '(trống)',
                'created_at' => $item->created_at->format('d').' Tháng '.$item->created_at->format('m').' lúc '.$item->created_at->format('H').':'.$item->created_at->format('i'),
            ];
        });
    
        // Trả về danh sách liên hệ chưa được xử lý
        return response()->json([
            'list_contact_room' => $data,
        ], 200);
    }
    public function trehan(Request $request){
    
    // Ngày mồng 2 đầu tháng (0h00 ngày 2)
    $ngay2 = now()->startOfMonth()->addDay()->addDay();

    // Query danh sách hóa đơn trễ hạn
    $hoaDonTreHan = HoaDon::where('trang_thai', 0) // Chỉ lấy hóa đơn chưa thanh toán (trang_thai = 0)
        ->whereRaw("UNIX_TIMESTAMP(created_at) + 86400 < UNIX_TIMESTAMP('$ngay2')") // Hóa đơn quá hạn
        ->with(['hopDong.user'])
        ->get();

    // Xử lý dữ liệu trả về
    $data = $hoaDonTreHan->map(function ($hoaDon) {
        return [
            'hop_dong_id' => $hoaDon->hop_dong_id,
            'id_user' =>$hoaDon->hopDong->user->id,
            'email_user' =>$hoaDon->hopDong->user->email,
            'name_user' =>$hoaDon->hopDong->user->name,
            'avatar_user' =>$hoaDon->hopDong->user->avatar ?? 'avatar/user_default.png.png',
            'token' => $hoaDon->token,
            'total' => $hoaDon->tien_thue 
                + ($hoaDon->tien_dien * $hoaDon->so_ki_dien) 
                + ($hoaDon->tien_nuoc * $hoaDon->so_khoi_nuoc) 
                + ($hoaDon->tien_xe * $hoaDon->so_luong_xe) 
                + ($hoaDon->tien_dich_vu * $hoaDon->so_luong_nguoi),
            'created_at' => $hoaDon->created_at->toDateTimeString(),
        ];
    });

    // Trả về kết quả
    return response()->json([
        'message' => 'Danh sách hóa đơn trễ hạn qua ngày mồng 2.',
        'hoa_don_tre_han' => $data,
    ], 200);
    }
}
