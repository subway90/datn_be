<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\HopDong;
use App\Models\Phong;
use App\Models\User;
use Illuminate\Support\Str;
class HopDongController extends Controller
{
    public function index()
    {
        $list = HopDong::orderBy('id','DESC')->get();
        $result = $list->map(function ($row) {
            $room = Phong::where('id',$row->phong_id)->get(['ten_phong','hinh_anh'])->first();
            $user = User::where('id',$row->tai_khoan_id)->get(['name','avatar'])->first();
            
            return [
                'id' => $row->id,
                'id_room' => $row->phong_id,
                'name_room' => $room->ten_phong,
                'image_room' => Str::before($room->hinh_anh, ';'),
                'id_user' => $row->tai_khoan_id,
                'name_user' => $user->name,
                'avatar_user' => $user->avatar ?? 'avatar/user_default.png',
                'date_start' => $row->ngay_bat_dau,
                'date_end' => $row->ngay_ket_thuc,
                'status' => $row->ngay_ket_thuc < $this->date_now ? 'Hết hạn' : 'Đang sử dụng',
            ];
        });
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
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
        ], [
            'id_room.required' => 'Chưa nhập ID Phòng',
            'id_room.exists' => 'ID Phòng không tồn tại',
            'id_user.required' => 'Chưa nhập ID User',
            'id_user.exists' => 'ID User không tồn tại',
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

        $hopDong = new HopDong();

        $hopDong->phong_id = $request->id_room;
        $hopDong->tai_khoan_id = $request->id_user;
        $hopDong->ngay_bat_dau = $request->date_start;
        $hopDong->ngay_ket_thuc = $request->date_end;

        $hopDong->save();

        return response()->json([
            'message' => 'Hợp đồng đã được tạo thành công!',
        ], 201);
    }
    
    public function edit(Request $request, $id)
    {
        // Kiểm tra và xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'id_room' => 'required|exists:phong,id',
            'id_user' => 'required|exists:users,id',
            'date_start' => 'required|date',
            'date_end' => 'required|date|after:date_start',
        ], [
            'id_room.required' => 'Chưa nhập ID Phòng',
            'id_room.exists' => 'ID Phòng không tồn tại',
            'id_user.required' => 'Chưa nhập ID User',
            'id_user.exists' => 'ID User không tồn tại',
            'date_start.required' => 'Chưa nhập ngày bắt đầu.',
            'date_start.date' => 'Chưa nhập đúng định dạng YYYY-MM-DD',
            'date_end.required' => 'Chưa nhập ngày kết thúc.',
            'date_end.date' => 'Chưa nhập đúng định dạng YYYY-MM-DD',
            'date_end.after' => 'Ngày kết thúc phải sau ngày bắt đầu.',
        ]);

        if ($validator->fails()) return response()->json(['message' => $validator->errors()->all()], 400);

        // Tìm hợp đồng cần cập nhật
        $hopDong = HopDong::findOrFail($id);

        // Cập nhật các thông tin của hợp đồng
        $hopDong->phong_id = $request->id_room;
        $hopDong->tai_khoan_id = $request->id_user;
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
        $hopDong = HopDong::with('thanhToan') // Tải danh sách thanh toán liên quan
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
            'file' => null,
            'list_pay' => $hopDong->thanhToan->map(function ($row) {
                return [
                    'id' => $row->id,
                    'pay_id' => $row->ma_giao_dich,
                    'voucher_code' => $row->code_uu_dai,
                    'pay_type' => $row->hinh_thuc,
                    'amount' => $row->so_tien,
                    'content' => $row->noi_dung,
                    'pay_date' => $row->ngay_giao_dich,
                    'status' => $row->trang_thai,
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

        # Xóa danh sách thanh toán của hợp đồng đó
        $hopDong->thanhToan()->delete();
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
