<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\HopDong;
use App\Models\Phong;

class HopDongController extends Controller
{
    public function index()
    {
        $list = HopDong::all();
        $result = $list->map(function ($row) {
            return [
                'id' => $row->id,
                'id_room' => $row->phong_id,
                'id_user' => $row->tai_khoan_id,
                'date_start' => $row->ngay_bat_dau,
                'date_end' => $row->ngay_ket_thuc,
                'status' => $row->ngay_ket_thuc < now() ? 'Hết hạn' : 'Đang sử dụng',
                'price' => $row->gia_thue,
            ];
        });
        return response()->json($result, 200);
    }
    public function create(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'phong_id' => 'required|exists:phong,id',
            'tai_khoan_id' => 'required|exists:users,id',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
        ], [
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        $phong = Phong::findOrFail($validatedData['phong_id']);

        $hopDong = new HopDong();
        $hopDong->phong_id = $validatedData['phong_id'];
        $hopDong->tai_khoan_id = $validatedData['tai_khoan_id'];
        $hopDong->ngay_bat_dau = $validatedData['ngay_bat_dau'];
        $hopDong->ngay_ket_thuc = $validatedData['ngay_ket_thuc'];
        $hopDong->gia_thue = $phong->gia_thue;
        $hopDong->trang_thai = 1;

        $hopDong->save();

        return response()->json([
            'message' => 'Hợp đồng đã được tạo thành công!',
            'hop_dong' => $hopDong
        ], 201);
    }
    public function edit(Request $request, $id)
    {
        // Kiểm tra và xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'phong_id' => 'required|exists:phong,id',
            'tai_khoan_id' => 'required|exists:users,id',
            'ngay_bat_dau' => 'required|date',
            'ngay_ket_thuc' => 'required|date|after:ngay_bat_dau',
        ], [
            'phong_id.required' => 'Phòng là trường bắt buộc.',
            'phong_id.exists' => 'Phòng không tồn tại.',
            'tai_khoan_id.required' => 'Tài khoản là trường bắt buộc.',
            'tai_khoan_id.exists' => 'Tài khoản không tồn tại.',
            'ngay_bat_dau.required' => 'Ngày bắt đầu là trường bắt buộc.',
            'ngay_bat_dau.date' => 'Ngày bắt đầu phải là định dạng ngày hợp lệ.',
            'ngay_ket_thuc.required' => 'Ngày kết thúc là trường bắt buộc.',
            'ngay_ket_thuc.date' => 'Ngày kết thúc phải là định dạng ngày hợp lệ.',
            'ngay_ket_thuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu.'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validatedData = $validator->validated();

        // Tìm hợp đồng cần cập nhật
        $hopDong = HopDong::findOrFail($id);

        // Cập nhật các thông tin của hợp đồng
        $hopDong->phong_id = $validatedData['phong_id'];
        $hopDong->tai_khoan_id = $validatedData['tai_khoan_id'];
        $hopDong->ngay_bat_dau = $validatedData['ngay_bat_dau'];
        $hopDong->ngay_ket_thuc = $validatedData['ngay_ket_thuc'];

        // Lấy giá thuê từ phòng nếu cần
        $phong = Phong::findOrFail($validatedData['phong_id']);
        $hopDong->gia_thue = $phong->gia_thue;

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
        $hopDong = HopDong::findOrFail($id);
        $hopDong->thanhToan()->delete();
        $hopDong->delete();


        return response()->json(['message' => 'Xóa hợp đồng thành công!'], 200);
    }
    public function restore($id)
    {
        $hopDong = HopDong::withTrashed()->findOrFail($id);
        $hopDong->restore();

        return response()->json(['message' => 'Khôi phục hợp đồng thành công!'], 200);
    }
}
