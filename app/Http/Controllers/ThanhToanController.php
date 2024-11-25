<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThanhToan;
use Illuminate\Support\Facades\Auth;
use App\Models\HoaDon;


class ThanhToanController extends Controller
{
    public function getThanhToan($id_hop_dong)
    {
        $user = Auth::user();

        $thanhToans = ThanhToan::with('hopDong')
            ->where('hop_dong_id', $id_hop_dong)
            ->get();

        if ($thanhToans->isEmpty()) {
            return response()->json([
                'message' => 'Không có thanh toán nào tồn tại cho hợp đồng này.'
            ], 404);
        }

        $hopDong = $thanhToans->first()->hopDong;

        if ($hopDong->tai_khoan_id !== $user->id) {
            return response()->json([
                'message' => 'Bạn không có quyền xem thông tin thanh toán này.'
            ], 403);
        }

        return response()->json($thanhToans);
    }

    public function pay($id_order)
    {   
        // Lấy id user
        $id_user = Auth::id();
        
        $get_order = HoaDon::with(['hopDong.user:id,name','hopDong:id',])->where('id',$id_order)->first();
        if($id_user !== $get_order->hopDong->user->id) return response()->json(['message' => 'Hóa đơn không tồn tại hoặc không phải của bạn'], 404);
        
        response()->json(['result' => $get_order,200]);
    }

    public function testpay() {
        // Lấy thông tin cần thiết từ request
        $orderId = 'testvnpay001';
        $vnpUrl = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // URL sandbox
    
        // Tham số VNPAY
        $vnpData = [
            "vnp_Version" => "2.0.0",
            "vnp_Command" => "pay",
            "vnp_TmnCode" => "934AOBY9",
            "vnp_Amount" => 450000 * 100,
            "vnp_CurrCode" => "VND",
            "vnp_TxnRef" => $orderId,
            "vnp_OrderInfo" => "Payment for order " . $orderId,
            "vnp_Locale" => "vn",
            "vnp_ReturnUrl" => 'http://127.0.0.1:5500/vnpay.html', // URL trả về sau khi thanh toán
            "vnp_IpAddr" => request()->ip(),
            "vnp_CreateDate" => date('YmdHis'),
        ];
    
        // Tạo chữ ký
        $vnpData['vnp_SecureHash'] = $this->generateSecureHash($vnpData);
    
        // Chuyển hướng đến VNPAY
        return redirect($vnpUrl . '?' . http_build_query($vnpData));
    }
    
    private function generateSecureHash($data) {
        // Tạo chữ ký cho dữ liệu
        ksort($data);
        $queryString = http_build_query($data);
        $secureHash = hash_hmac('sha256', $queryString, '8VSJ0CGY5Z8IF0RZQWBXTRE7DR4DCBDH');
        return $secureHash;
    }

}
