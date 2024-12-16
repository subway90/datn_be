<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\HopDong;
use App\Models\Phong;
use App\Models\ToaNha;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class HopDongController extends Controller
{
    public function all()
    {
        $list = HopDong::orderBy('created_at', 'DESC')->get();
        $result = $list->map(function ($row) {
            $room = Phong::withTrashed()->with('toaNha')->where('id', $row->phong_id)->get(['toa_nha_id', 'ten_phong', 'hinh_anh'])->first();
            $user = User::withTrashed()->where('id', $row->tai_khoan_id)->get(['name', 'avatar'])->first();
            $building = ToaNha::withTrashed()->where('id', $room->toa_nha_id)->get(['ten'])->first();
            return [
                'id' => $row->id,
                'status' => $row->ngay_ket_thuc > $this->date_now ? 'Đang hoạt động' : 'Hết hạn',
                'id_room' => $row->phong_id,
                'name_room' => $room->ten_phong,
                'name_building' => $building->ten,
                'image_room' => Str::before($room->hinh_anh, ';'),
                'id_user' => $row->tai_khoan_id,
                'name_user' => $user->name,
                'avatar_user' => $user->avatar ?? 'avatar/user_default.png',
                'so_luong_xe' => $row->so_luong_xe,
                'so_luong_nguoi' => $row->so_luong_nguoi,
                'file_hop_dong' => $row->file_hop_dong,
                'date_start' => $row->ngay_bat_dau,
                'date_end' => $row->ngay_ket_thuc,
            ];
        });
    
        return response()->json($result, 200);
    }

    public function index()
    {
        $list = HopDong::where('ngay_ket_thuc', '>=', now())->orderBy('id', 'DESC')->get();
        $result = $list->map(function ($row) {
            $room = Phong::withTrashed()->with('toaNha')->where('id', $row->phong_id)->get(['toa_nha_id', 'ten_phong', 'hinh_anh'])->first();
            $user = User::withTrashed()->where('id', $row->tai_khoan_id)->get(['name', 'avatar'])->first();
            $building = ToaNha::withTrashed()->where('id', $room->toa_nha_id)->get(['ten'])->first();
            return [
                'id' => $row->id,
                'id_room' => $row->phong_id,
                'name_room' => $room->ten_phong,
                'name_building' => $building->ten,
                'image_room' => Str::before($room->hinh_anh, ';'),
                'id_user' => $row->tai_khoan_id,
                'name_user' => $user->name,
                'avatar_user' => $user->avatar ?? 'avatar/user_default.png',
                'so_luong_xe' => $row->so_luong_xe,
                'so_luong_nguoi' => $row->so_luong_nguoi,
                'file_hop_dong' => $row->file_hop_dong,
                'date_start' => $row->ngay_bat_dau,
                'date_end' => $row->ngay_ket_thuc,
                'status' => 'Đang sử dụng',
            ];
        });
    
        return response()->json($result, 200);
    }
    public function het_han(){
        
    $list = HopDong::where('ngay_ket_thuc', '<', now())
        ->orderBy('id', 'DESC')
        ->get();

    $result = $list->map(function ($row) {
        $room = Phong::withTrashed()->with('toaNha')->where('id', $row->phong_id)->get(['toa_nha_id', 'ten_phong', 'hinh_anh'])->first();
        $user = User::withTrashed()->where('id', $row->tai_khoan_id)->get(['name', 'avatar'])->first();
        $building = ToaNha::withTrashed()->where('id', $room->toa_nha_id)->get(['ten'])->first();

        return [
            'id' => $row->id,
            'id_room' => $row->phong_id,
            'name_room' => $room->ten_phong,
            'name_building' => $building->ten,
            'image_room' => Str::before($room->hinh_anh, ';'),
            'id_user' => $row->tai_khoan_id,
            'name_user' => $user->name,
            'avatar_user' => $user->avatar ?? 'avatar/user_default.png',
            'so_luong_xe' => $row->so_luong_xe,
            'so_luong_nguoi' => $row->so_luong_nguoi,
            'file_hop_dong' => $row->file_hop_dong,
            'date_start' => $row->ngay_bat_dau,
            'date_end' => $row->ngay_ket_thuc,
            'status' => 'Hết hạn',
        ];
    });

    return response()->json($result, 200);
}
    public function sap_het_han(){
        $today = now();
        $saphethan = $today->copy()->addDays(10);
    
        $list = HopDong::where('ngay_ket_thuc', '>=', $today)
            ->where('ngay_ket_thuc', '<=', $saphethan)
            ->orderBy('id', 'DESC')
            ->get();
    
        $result = $list->map(function ($row) {
            $room = Phong::withTrashed()->with('toaNha')->where('id', $row->phong_id)->get(['toa_nha_id', 'ten_phong', 'hinh_anh'])->first();
            $user = User::withTrashed()->where('id', $row->tai_khoan_id)->get(['name', 'avatar'])->first();
            $building = ToaNha::withTrashed()->where('id', $room->toa_nha_id)->get(['ten'])->first();
    
            return [
                'id' => $row->id,
                'id_room' => $row->phong_id,
                'name_room' => $room->ten_phong,
                'name_building' => $building->ten,
                'image_room' => Str::before($room->hinh_anh, ';'),
                'id_user' => $row->tai_khoan_id,
                'name_user' => $user->name,
                'avatar_user' => $user->avatar ?? 'avatar/user_default.png',
                'so_luong_xe' => $row->so_luong_xe,
                'so_luong_nguoi' => $row->so_luong_nguoi,
                'file_hop_dong' => $row->file_hop_dong,
                'date_start' => $row->ngay_bat_dau,
                'date_end' => $row->ngay_ket_thuc,
                'status' => 'Gần hết hạn',
            ];
        });
    
        return response()->json($result, 200);
    }
   
    public function detail($id)
    {
        $row = HopDong::find($id);
        if(!$row) return response()->json(['message'=>'Không tìm thấy hợp đồng'], 404);
        $room = Phong::withTrashed()->with('toaNha')->where('id',$row->phong_id)->get(['toa_nha_id','ten_phong','hinh_anh'])->first();
        $room = Phong::withTrashed()->with('toaNha')->where('id',$row->phong_id)->get(['toa_nha_id','ten_phong','hinh_anh','gia_thue','don_gia_dien','don_gia_nuoc','tien_xe_may','phi_dich_vu'])->first();
        $user = User::withTrashed()->where('id',$row->tai_khoan_id)->get(['name','avatar'])->first();
        $building = ToaNha::withTrashed()->where('id',$room->toa_nha_id)->get(['ten'])->first();
        $result = [
            'id' => $row->id,
            'id_room' => $row->phong_id,
            'name_room' => $room->ten_phong,
            'name_building' =>$building->ten,
            'image_room' => Str::before($room->hinh_anh, ';'),
            'tien_thue' => $room->gia_thue,
            'tien_dien' => $room->don_gia_dien,
            'tien_nuoc' => $room->don_gia_nuoc,
            'tien_xe' => $room->tien_xe_may,
            'tien_dich_vu' => $room->phi_dich_vu,
            'id_user' => $row->tai_khoan_id,
            'name_user' => $user->name,
            'avatar_user' => $user->avatar ?? 'avatar/user_default.png',
            'so_luong_xe' => $row->so_luong_xe,
            'so_luong_nguoi' => $row->so_luong_nguoi,
            'file_hop_dong' => $row->file_hop_dong,
            'date_start' => $row->ngay_bat_dau,
            'date_end' => $row->ngay_ket_thuc,
            'status' => $row->ngay_ket_thuc < $this->date_now ? 'Hết hạn' : 'Đang sử dụng',
        ];
        return response()->json($result, 200);
    }

    public function list_delete()
    {
        $list = HopDong::onlyTrashed()->orderBy('deleted_at','DESC')->get();
        if($list->isEmpty()) return response()->json(['message' => 'Danh sách trống'], 404);

        $result = $list->map(function ($row) {
            return [
                'id' => $row->id,
                'id_room' => $row->phong_id,
                'id_user' => $row->tai_khoan_id,
                'date_start' => $row->ngay_bat_dau,
                'date_end' => $row->ngay_ket_thuc,
                'status' => $row->ngay_ket_thuc < $this->date_now ? 'Hết hạn' : 'Đang sử dụng',
            ];
        });
        return response()->json($result, 200);
    }
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_room' => 'required|exists:phong,id',
            'id_user' => 'required|exists:users,id',
            'file_hop_dong' => 'nullable|mimes:pdf|max:4096',
            'so_luong_xe' => 'required',
            'so_luong_nguoi' => 'required|integer|min:1',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
        ], [
            'id_room.required' => 'Chưa nhập ID Phòng',
            'id_room.exists' => 'ID Phòng không tồn tại',
            'id_user.required' => 'Chưa nhập ID User',
            'id_user.exists' => 'ID User không tồn tại',
            'file_hop_dong.mimes' => 'File hợp đồng phải là file PDF',
            'file_hop_dong.max' => 'Kích thước file hợp đồng không vượt quá 4MB',
            'so_luong_xe.required' => 'Chưa nhập số lượng xe',
            'so_luong_nguoi.required' => 'Chưa nhập số lượng người',
            'so_luong_nguoi.min' => 'Số lượng người ít nhất phải bằng 1',
            'date_start.required' => 'Chưa nhập ngày bắt đầu.',
            'date_end.required' => 'Chưa nhập ngày kết thúc.',
            'date_end.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        if ($validator->fails()) return response()->json(['message' => $validator->errors()->all()], 400);
        # Lấy thông tin của phòng đó
        $list_hop_dong = HopDong::where('phong_id',$request->id_room)->get();

        # Kiểm tra xem hợp đồng có còn sử dụng hay không
        if($list_hop_dong) {
            foreach ($list_hop_dong as $key => $hop_dong) {
                if($hop_dong->ngay_ket_thuc > $this->date_now) {
                    return response()->json(['message'=> 'Phòng này đang có hợp đồng sử dụng'], 400);
                }
            };
        }

        $path_file = '';
        if ($request->hasFile('file_hop_dong')) {
            $file_hop_dong = $request->file('file_hop_dong');
                $path_file = $file_hop_dong->store('contract',  'public');
        }

        $result = HopDong::create([
            'phong_id' => $request->id_room,
            'tai_khoan_id' => $request->id_user,
            'file_hop_dong' => $path_file,
            'so_luong_xe' => $request->so_luong_xe,
            'so_luong_nguoi' => $request->so_luong_nguoi,
            'ngay_bat_dau' => $request->date_start,
            'ngay_ket_thuc' => $request->date_end,
        ]);

        return response()->json(['message' => 'Hợp đồng đã được tạo thành công!'], 201);
    }
    
    public function edit(Request $request, $id)
    {
        // Tìm hợp đồng cần cập nhật
        $hopDong = HopDong::find($id);
        if(!$hopDong) return response()->json(['message' => 'Hợp đồng không tồn tại'], 404);

        // Kiểm tra và xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'id_room' => 'required|exists:phong,id',
            'id_user' => 'required|exists:users,id',
            'file_hop_dong' => 'nullable|mimes:pdf|max:4096',
            'so_luong_xe' => 'required',
            'so_luong_nguoi' => 'required|integer|min:1',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
        ], [
            'id_room.required' => 'Chưa nhập ID Phòng',
            'id_room.exists' => 'ID Phòng không tồn tại',
            'id_user.required' => 'Chưa nhập ID User',
            'id_user.exists' => 'ID User không tồn tại',
            'file_hop_dong.mimes' => 'File hợp đồng phải là file PDF',
            'file_hop_dong.max' => 'Kích thước file hợp đồng không vượt quá 4MB',
            'so_luong_xe.required' => 'Chưa nhập số lượng xe',
            'so_luong_nguoi.required' => 'Chưa nhập số lượng người',
            'so_luong_nguoi.min' => 'Số lượng người ít nhất phải bằng 1',
            'date_start.required' => 'Chưa nhập ngày bắt đầu.',
            'date_start.date' => 'Chưa nhập đúng định dạng YYYY-MM-DD',
            'date_end.required' => 'Chưa nhập ngày kết thúc.',
            'date_end.date' => 'Chưa nhập đúng định dạng YYYY-MM-DD',
            'date_end.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        if ($validator->fails()) return response()->json(['message' => $validator->errors()->all()], 400);

        //
        $old_file_hop_dong = $hopDong->file_hop_dong;

        // xử lí thay đổi file nếu có
        if ($request->hasFile('file_hop_dong')) {
            $file_hop_dong = $request->file('file_hop_dong');
            // Xóa file cũ nếu có
            if($old_file_hop_dong) Storage::disk('public')->delete($hopDong->file_hop_dong);
            // Mã hóa và thêm file mới vào storage
            $filename = uniqid() . '.' . $file_hop_dong->getClientOriginalExtension();
            $path_file = $file_hop_dong->storeAs('contract', $filename, 'public');
        }else $path_file = $old_file_hop_dong;
        
        // Cập nhật các thông tin của hợp đồng
        $hopDong->phong_id = $request->id_room;
        $hopDong->tai_khoan_id = $request->id_user;
        $hopDong->file_hop_dong = $path_file;
        $hopDong->so_luong_xe = $request->so_luong_xe;
        $hopDong->so_luong_nguoi = $request->so_luong_nguoi;
        $hopDong->ngay_bat_dau = $request->date_start;
        $hopDong->ngay_ket_thuc = $request->date_end;

        // Lưu lại các thay đổi
        $hopDong->save();

        return response()->json([
            'message' => 'Hợp đồng đã được cập nhật thành công!',
            'hop_dong' => $hopDong
        ], 200);
    }

    public function show()
    {
        // Lấy ID của người dùng đã đăng nhập
        $userId = Auth::id();

        // Lấy hợp đồng của người dùng (mỗi tài khoản chỉ có một hợp đồng không bắt buộc)
        $hopDong = HopDong::with('hoaDon') // Tải danh sách thanh toán liên quan
            ->where('tai_khoan_id', $userId)
            ->first(); // Sử dụng first() để lấy một đối tượng duy nhất

        // Kiểm tra xem hợp đồng có tồn tại hay không
        if (!$hopDong) {
            return response()->json(['message' => 'Bạn chưa có hợp đồng nào.'], 404);
        }
        // Tạo mảng dữ liệu để trả về
        $data = [
            'id' => $hopDong->id,
            'room_id' => $hopDong->phong_id,
            'date_start' => $hopDong->ngay_bat_dau,
            'date_end' => $hopDong->ngay_ket_thuc,
            'price' => $hopDong->gia_thue,
            'file_hop_dong' => $hopDong->file_hop_dong,
            'list_pay' => $hopDong->hoaDon->map(function ($order) {
                $total = $order->tien_thue;
                $total += $order->tien_dien * $order->so_ki_dien;
                $total += $order->tien_nuoc * $order->so_khoi_nuoc;
                $total += $order->tien_xe * $order->so_luong_xe;
                $total += $order->tien_dich_vu * $order->so_luong_nguoi;
                return [
                    'token' => $order->token,
                    'tong_tien' => $total,
                    'ngay_tao' => $order->created_at->format('d').' tháng '.$order->created_at->format('m').' năm '.$order->created_at->format('Y').' lúc '.$order->created_at->format('H').':'.$order->created_at->format('i'),
                    'ngay_cap_nhat' => $order->updated_at->format('d').' tháng '.$order->updated_at->format('m').' năm '.$order->updated_at->format('Y').' lúc '.$order->updated_at->format('H').':'.$order->updated_at->format('i'),
                    'trang_thai' => $order->trang_thai ? 'Đã thanh toán' : 'Chưa thanh toán',
                    'hinh_thuc' => $order->hinh_thuc ? 'Thanh toán online' : 'Thanh toán tiền mặt',
                    'tien_thue' => $order->tien_thue,
                    'tien_dien' => $order->tien_dien,
                    'so_ki_dien' => $order->so_ki_dien,
                    'tien_nuoc' => $order->tien_nuoc,
                    'so_khoi_nuoc' => $order->so_khoi_nuoc,
                    'tien_xe' => $order->tien_xe,
                    'so_luong_xe' => $order->so_luong_xe,
                    'tien_dich_vu' => $order->tien_dich_vu,
                    'so_luong_nguoi' => $order->so_luong_nguoi,
                ];
            }),
        ];
        unset($hopDong->thanhToan);
        // Trả về thông tin hợp đồng cùng với danh sách thanh toán
        return response()->json($data);
    }
    public function delete($id)
    {
        # Tìm hợp đồng
        $hopDong = HopDong::find($id);
        if(!$hopDong) return response()->json(['message' => 'Hợp đồng này không tồn tại'], 404);
        # Kiểm tra tình trạng hợp đồng
        if($hopDong->ngay_ket_thuc > Carbon::now()) return response()->json(['message' => 'Hợp đồng đang hoạt động, không thể xoá'], 404);
        $hopDong->delete();

        # Trả kết quả res
        return response()->json(['message' => 'Xóa hợp đồng thành công'], 200);
    }
    public function restore($id)
    {
        $hopDong = HopDong::onlyTrashed()->find($id);
        if(!$hopDong) return response()->json(['message' => 'Hợp đồng này không tồn tại'], 404);
        $hopDong->restore();

        return response()->json(['message' => 'Khôi phục hợp đồng thành công'], 200);
    }
}
