<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThanhToan;
use Illuminate\Support\Facades\Auth;
use App\Models\HoaDon;


class ThanhToanController extends Controller
{

    public function pay($token)
    {   
        // Lấy id user
        $id_user = Auth::id();
        // Lấy thông tin hóa đơn
        $get_order = HoaDon::with(['hopDong.user:id,name','hopDong:id',])->where('token',$token)->first();
        
        if(!$get_order || $id_user !== $get_order->hopDong->user->id) return response()->json(['message' => 'Hóa đơn không tồn tại hoặc không phải của bạn'], 404);

        $total = $get_order->tien_thue;
        $total += $get_order->tien_dien * $get_order->so_ki_dien;
        $total += $get_order->tien_nuoc * $get_order->so_khoi_nuoc;
        $total += $get_order->tien_xe * $get_order->so_luong_xe;
        $total += $get_order->tien_dich_vu * $get_order->so_luong_nguoi;
        
        # ID hóa đơn (test)
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
            "vnp_OrderInfo" => $get_order->noi_dung,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => ENV('VNPAY_RETURN_URL'), // URL trả về sau khi thanh toán
            "vnp_TxnRef" => $get_order->token,
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

    public function handleCallback(Request $request) {
        // Lấy key secret
        $vnp_HashSecret = env('VNPAY_HASH_SECRET');
        //Lấy mã secure từ Request trả về
        $vnp_SecureHash = $request->input('vnp_SecureHash');
        // Lấy thôn tin hóa đơn
        $token = $request->input('vnp_TxnRef');
        $get_order = HoaDon::where('token',$token)->first();
        if(!$get_order) return response()->json(['message' => 'Hoa don khong ton tai'], 400);

        // Lấy tất cả Request ngoại trừ 2 cái SecureHash và SecureHashType
        $requestData = $request->except(['vnp_SecureHash', 'vnp_SecureHashType']);
        
        // Tạo mã Secure từ các Request
        ksort($requestData);
        $queryString = http_build_query($requestData);
        $secureHash = hash_hmac('sha512', $queryString, $vnp_HashSecret);
        
        // So sánh mã Secure, true là các Request trả về là đúng
        if ($secureHash === $vnp_SecureHash) {
            // Cập nhật trạng thái và ngày giao dịch
            $get_order->update([
                'hinh_thuc' => 1,
                'updated_at' => now(),
                'noi_dung' => $request->input('vnp_OrderInfo'),
                'trang_thai' => ($request->input('vnp_ResponseCode') === '00') ? 1 : 0,
            ]);
            // return response()->json(['message' => 'Thanh toán thành công'], 200);
            $data = [
                'ma_giao_dich' => $get_order->token,
                'so_tien' => $request->input('vnp_Amount')/100,
                'ngay_giao_dich' => $get_order->updated_at,
                'noi_dung' => $get_order->noi_dung,
            ];
            return view('pay.result',$data);
        } else {
            return response()->json(['message' => 'Hoa don khong ton tai'], 400);
        }
    }
    
}
