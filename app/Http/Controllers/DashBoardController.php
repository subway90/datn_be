<?php

namespace App\Http\Controllers;
use App\Models\HoaDon;
use App\Models\KhuVuc;
use App\Models\Phong;
use App\Models\ToaNha;
use App\Models\User;
use App\Models\HopDong;
use App\Models\LienHeDatPhong;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        // Lấy tham số từ request, nếu không có thì mặc định là năm hiện tại
        $nam = $request->input('nam', Carbon::now()->year); // Năm (mặc định là năm hiện tại)
    
        // Khởi tạo mảng kết quả
        $doanhThuThang = [];
    
        // Duyệt qua các tháng từ 1 đến 12
        for ($thang = 1; $thang <= 12; $thang++) {
            // Xây dựng query cơ bản
            $query = HoaDon::selectRaw('
                    SUM(tien_thue 
                        + (tien_dien * so_ki_dien) 
                        + (tien_nuoc * so_khoi_nuoc) 
                        + (tien_xe * so_luong_xe) 
                        + (tien_dich_vu * so_luong_nguoi)
                    ) as tong_doanh_thu 
                ')
                ->where('trang_thai', 1) // Chỉ lấy những hóa đơn có trạng thái = 1
                ->whereMonth('created_at', $thang) // Lọc theo tháng
                ->whereYear('created_at', $nam); // Lọc theo năm
    
            // Lấy kết quả
            $doanhThu = $query->first();
    
            // Nếu không có doanh thu thì trả về 0, nếu có thì lấy giá trị
            // Đã sửa key JSON trả về API (subway90 update)
            $doanhThuThang[$thang-1]["name"] = "Tháng ".$thang;
            $doanhThuThang[$thang-1]["doanh thu"] = $doanhThu->tong_doanh_thu ?? '0';
        }
    
        // Trả về kết quả
        return response()->json([
            'year' => $nam,
            'data' => $doanhThuThang, // Mảng doanh thu theo từng tháng
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
            'token' => $hoaDon->token,
            'hop_dong_id' => $hoaDon->hop_dong_id,
            'email_user' =>$hoaDon->hopDong->user->email,
            'name_user' =>$hoaDon->hopDong->user->name,
            'avatar_user' =>$hoaDon->hopDong->user->avatar ?? 'avatar/user_default.png',
            'total' => $hoaDon->tien_thue 
                + ($hoaDon->tien_dien * $hoaDon->so_ki_dien) 
                + ($hoaDon->tien_nuoc * $hoaDon->so_khoi_nuoc) 
                + ($hoaDon->tien_xe * $hoaDon->so_luong_xe) 
                + ($hoaDon->tien_dich_vu * $hoaDon->so_luong_nguoi),
            // custom formate date (subway90 update)
            'date' => $hoaDon->created_at->format('d').' Tháng '.$hoaDon->created_at->format('m').' lúc '.$hoaDon->created_at->format('H').':'.$hoaDon->created_at->format('i'),
        ];
    });

    // Trả về kết quả
    return response()->json([
        'hoa_don_tre_han' => $data,
    ], 200);
    }
    public function hop_dong()
{
    $today = now();
    $saphethan = $today->copy()->addDays(10);

    // Đếm số hợp đồng đang thuê
    $dang_thue = HopDong::where('ngay_ket_thuc', '>=', $today)->count();

    // Đếm số hợp đồng hết hạn
    $het_han = HopDong::where('ngay_ket_thuc', '<', $today)->count();

    // Đếm số hợp đồng sắp hết hạn (trong vòng 10 ngày)
    $sap_het_han = HopDong::where('ngay_ket_thuc', '>=', $today)
        ->where('ngay_ket_thuc', '<=', $saphethan)
        ->count();
    $tong = $het_han + $dang_thue + $sap_het_han;
    // Trả về kết quả JSON
    return response()->json([
        'tong_hop_dong' => $tong,
        'dang_thue' => $dang_thue,
        'het_han' => $het_han,
        'sap_het_han' => $sap_het_han
    ], 200);
    }

    public function total_contact() {
        $da_xu_ly = LienHeDatPhong::where('trang_thai',1)->count();
        $chua_xu_ly = LienHeDatPhong::where('trang_thai',0)->count();
        return response()->json([
            'da_xu_ly' => $da_xu_ly,
            'chua_xu_ly' => $chua_xu_ly,
        ], 200);
    }

    public function distric(){
        // Lấy tất cả quận từ bảng khu_vuc
        $districts = KhuVuc::all();

         // Duyệt từng quận
     $result = $districts->map(function ($district) {
        // Lấy tất cả tòa nhà thuộc quận hiện tại
        $buildings = ToaNha::where('khu_vuc_id', $district->id)->get();

        // Duyệt từng tòa nhà
        $buildingData = $buildings->map(function ($building) {
            // Đếm số phòng theo trạng thái (0: trống, 1: cho thuê)
            $trong = Phong::where('toa_nha_id', $building->id)
                ->where('trang_thai', 0) // Phòng trống
                ->count();

            $cho_thue = Phong::where('toa_nha_id', $building->id)
                ->where('trang_thai', 1) // Phòng cho thuê
                ->count();
            
            return [
                'name' => $building->ten,  // Tên tòa nhà
                'trong' => $trong,         // Số phòng trống
                'cho_thue' => $cho_thue,   // Số phòng cho thuê
            ];
        });

        return [
            'District' => [
                'name' => $district->ten,   // Tên quận
                'buildings' => $buildingData, // Danh sách tòa nhà trong quận
            ],
        ];
    });

    return response()->json($result, 200);
    }
    public function thongkehoadon($year){
        // Lọc dữ liệu hóa đơn theo năm và nhóm theo tháng
        $hoaDonByMonth = HoaDon::selectRaw('MONTH(created_at) as month, COUNT(*) as tong_hoa_don')
        ->whereYear('created_at', $year)  // Lọc theo năm
        ->groupByRaw('MONTH(created_at)')  // Nhóm theo tháng
        ->orderByRaw('MONTH(created_at)')
        ->pluck('tong_hoa_don', 'month');

        // Tạo mảng kết quả
        $result = [];
        for ($month = 1; $month <= 12; $month++) {
        $result[] = [
            'month' => $month,
            'tong_hoa_don' => $hoaDonByMonth[$month] ?? 0, // Nếu không có hóa đơn cho tháng, gán 0
        ];
        }

        // Trả về kết quả JSON theo cấu trúc yêu cầu
        return response()->json([
        'year' => $year,
        'data' => $result
        ], 200);}
}
