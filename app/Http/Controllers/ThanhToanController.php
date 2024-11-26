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

        // cấu hình
        $orderId = 'HD-'.uniqid();
        $vnpUrl = ENV('VNPAY_URL'); // URL sandbox


        // Tham số cho VNPAY
        $vnpData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" =>  ENV('VNPAY_TMN_CODE'),
            "vnp_Amount" => 450000 * 100, // Chuyển đổi sang VND
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => "Thanh toán cho hóa đơn " . $orderId,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => ENV('VNPAY_RETURN_URL'), // URL trả về sau khi thanh toán
            "vnp_TxnRef" => $orderId,
            "vnp_ExpireDate" => date('YmdHis',strtotime('+15 minutes',strtotime(date("YmdHis")))),
        ];

        // code xử lí của vnpay
        ksort($vnpData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($vnpData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnpUrl = $vnpUrl . "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, ENV('VNPAY_HASH_SECRET'));//  
        $vnpUrl .= 'vnp_SecureHash=' . $vnpSecureHash;

        // Chuyển hướng đến VNPAY
        return redirect($vnpUrl);
    }
    
}
