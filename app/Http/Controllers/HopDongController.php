<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HopDong;
use App\Models\ThanhToan;
use Illuminate\Support\Facades\Auth;

class HopDongController extends Controller
{
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
            'phong_id' => $hopDong->phong_id,
            'date_start' => $hopDong->ngay_bat_dau,
            'date_end' => $hopDong->ngay_ket_thuc,
            'price'=> $hopDong->gia_thue,
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
}
