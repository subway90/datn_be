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
        // Lấy thông tin hóa đơn
        $get_order = HoaDon::with(['hopDong.user:id,name','hopDong:id',])->where('id',$id_order)->first();
        // test :mã hóa đơn random
        $get_order->id = 'HD_'.rand(0,9999);
        
        if(!$get_order || $id_user !== $get_order->hopDong->user->id) return response()->json(['message' => 'Hóa đơn không tồn tại hoặc không phải của bạn'], 404);

        $total = $get_order->tien_thue;
        $total += $get_order->tien_dien * $get_order->so_ki_dien;
        $total += $get_order->tien_nuoc * $get_order->so_khoi_nuoc;
        $total += $get_order->tien_xe * $get_order->so_luong_xe;
        $total += $get_order->tien_dich_vu * $get_order->so_luong_nguoi;
        
        // return response()->json(['so_tien' => $total,'order' => $get_order],200);

        // cấu hình thanh toán vnpay
        $vnpUrl = ENV('VNPAY_URL'); // URL sandbox
        // Tham số cho VNPAY
        $vnpData = [
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" =>  ENV('VNPAY_TMN_CODE'),
            "vnp_Amount" =>$total * 100, // Chuyển đổi sang VND
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
            "vnp_Locale" => "vn",
            "vnp_OrderInfo" => $get_order->id,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => ENV('VNPAY_RETURN_URL'), // URL trả về sau khi thanh toán
            "vnp_TxnRef" => $get_order->id,
            "vnp_ExpireDate" => date('YmdHis',strtotime('+15 minutes',strtotime(date("YmdHis")))),
        ];

        // code xử lí tạo url vnpay
        ksort($vnpData);
        $queryString = http_build_query($vnpData);
        $vnp_SecureHash = hash_hmac('sha512', $queryString, ENV('VNPAY_HASH_SECRET'));
        $vnpUrl .= "?" . $queryString . '&vnp_SecureHash=' . $vnp_SecureHash;

        // Chuyển hướng đến VNPAY
        // return redirect($vnpUrl);
        return response()->json(['url'=>$vnpUrl],200);
    }
    
}
