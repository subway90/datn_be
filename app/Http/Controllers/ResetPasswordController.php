<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ResetPassword;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    public function check(Request $request)
    {   
        // Validation
        $validate = Validator::make($request->all(),
            ['email' => 'required|email|exists:users,email'],
        [
            'email.required' => 'Chưa nhập email',
            'email.email' => 'Email không đúng định dạng',
            'email.exists' => 'Email không tồn tại',  
        ]);
        if ($validate->fails()) return response()->json(['message' => $validate->errors()->all(),], 400);

        // Tạo OTP ngẫu nhiên
        $otp = Str::random(8);
        // Kiểm tra xem OTP đã tồn tại hay chưa
        while (ResetPassword::where('otp', $otp)->exists()) $otp = Str::random(8);
        // Lưu OTP vào cơ sở dữ liệu
        ResetPassword::create([
            'otp' => $otp,
            'email' => $request->email,
        ]);
        // Gửi email chứa OTP
        Mail::raw('OTP của bạn là: ' . $otp, function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('OTP xác nhận việc Quên Mật Khẩu');
        });
        return response()->json(['message' => 'OTP đã được gửi đến mail, vui lòng kiểm tra'], 200);
    }

    public function reset(Request $request)
    {
        // Validation
        $validate = Validator::make($request->all(),
            ['otp' => 'required|size:8|exists:otp_reset_password,otp'],
        [
            'otp.required' => 'Chưa nhập otp',
            'otp.size' => 'Độ dài OTP phải bằng 8 kí tự',
            'otp.exists' => 'OTP không tồn tại',
        ]);
        if ($validate->fails()) return response()->json(['message' => $validate->errors()->all(),], 400);

        // Lấy email từ OTP đó
        $getOTP = ResetPassword::where('otp', $request->otp)->first();
        // Tạo mật khẩu ngẫu nhiên
        $newPassword = Str::random(6);
        // Cập nhật mật khẩu cho người dùng
        $user = User::where('email', $getOTP->email)->first();
        if ($user) {
            $user->password = Hash::make($newPassword);
            $user->save();
            // Gửi email chứa mật khẩu mới
            try{
                Mail::send('emails.new_password', ['newPassword' => $newPassword, 'routeLogin' => 'https://sghouses.vercel.app/login'], function ($message) use ($getOTP) {
                    $message->to($getOTP->email)
                            ->subject('Khôi phục mật khẩu mới');
                });
                return response()->json(['message' => 'Mật khẩu đã được khôi phục, hãy kiểm tra hòm thư của bạn'], 200);
            }catch(\Exception $e)
            {   
                \Log::error('Mail error: ' . $e->getMessage());
                return response()->json(['message' => 'Lỗi hệ thống, vui lòng thử lại sau'], 500);
            }
        }return response()->json(['message' => 'Tài khoản không tìm thấy ! Liên hệ ADMIN để xử lí !'], 404);
    }
}
