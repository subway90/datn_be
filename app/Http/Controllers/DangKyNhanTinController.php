<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DangKyNhanTin;
use App\Models\GuiMailThongBao;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class DangKyNhanTinController extends Controller
{
    //! User đăng ký
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:dang_ky_nhan_tin,email',
        ], [
            'email.required' => 'Bạn chưa nhập email',
            'email.email' => 'Email chưa đúng định dạng',
            'email.unique' => 'Email này đã đăng kí nhận tin rồi',
        ]);
        
        
        if ($validator->fails()) return response()->json(['message' => $validator->errors()->first()],400);
        
        # Tạo token để xác thực (subway90 update)
        $token_verify = Uuid::uuid4()->toString();

        # Gửi email xác thực (subway90 update)
        try{
            Mail::send('emails.verify_email_register', ['routeVerify' => ENV('DOMAIN').'/api/verify-email-register/'.$token_verify], function ($message) use ($request) {
                $message->to($request->email)
                        ->subject('Đăng kí xác thực nhận tin từ SGHOUSES');
            });
        }catch(\Exception $e)
        {   
            return response()->json(['message' => 'Lỗi hệ thống gửi Mail, vui lòng thử lại sau'], 500);
        }

        # Lưu vào database
        DangKyNhanTin::create([
            'email' => $request->email,
            'token_verify'=> $token_verify,
        ]);

        

        return response()->json(['message' => 'Đăng ký thành công, vui lòng kiểm tra email để xác nhận !','debug'=>ENV('DOMAIN').'/api/verify-email-register/'.$token_verify], 201);
    }

    public function verify($token) {

        # Trả 400
        if(!$token) return response()->json(['message'=>'Bad request'],400);

        # Kiểm tra token
        $check = DangKyNhanTin::where('token_verify',$token)->where('trang_thai','0')->first();

        if(!$check) return response()->json(['message'=>'Token không tồn tại'],404);

        # Thay đổi trạng thái
        $check->update([
                'trang_thai' => 1
            ]);

        # Gửi mail thông báo
        try{
            Mail::send('emails.success_email_register', [], function ($message) use ($check) {
                $message->to($check->email)
                        ->subject('Xác thực nhận tin tại SGHOUSES thành công');
            });
        }catch(\Exception $e)
        {   
            return response()->json(['message' => 'Lỗi hệ thống gửi Mail, vui lòng thử lại sau'], 500);
        }

        # Trả giao diện thông báo
        return view('notify.success_email_register');
    }

    //! Admin quản lí
    public function index()
    {
        $list = DangKyNhanTin::withTrashed()->get();
        return response()->json($list);
    }

    public function destroy($id)
    {
        $record = DangKyNhanTin::findOrFail($id);
        $record->delete();
        return response()->json(['message' => 'Xóa thành công!']);
    }

    public function restore($id)
    {
        $record = DangKyNhanTin::onlyTrashed()->findOrFail($id);
        $record->restore();
        return response()->json(['message' => 'Khôi phục thành công!']);
    }
    //! Gửi mail
    public function sendMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'email' => 'nullable|string',
            'all_mail' => 'required|in:0,1',
        ], [
            'content.required' => 'Bạn chưa nhập nội dung thư',
            'all_mail.required' => 'Trường all_mail là bắt buộc',
            'all_mail.in' => 'Trường all_mail phải là 0 hoặc 1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        $emails = [];

        if ($request->all_mail == 0) {
            // Gửi đến tất cả email
            $emails = DangKyNhanTin::pluck('email')->toArray();
        } else {
            // Gửi đến danh sách email được chỉ định
            $emails = explode(';', $request->email);
        }

        // Lọc email không hợp lệ
        $emails = array_filter($emails, function ($email) {
            return filter_var($email, FILTER_VALIDATE_EMAIL);
        });

        // Kiểm tra nếu danh sách email trống
        if (empty($emails)) {
            return response()->json(['error' => 'Danh sách email trống!'], 400);
        }

        foreach ($emails as $email) {
            // Gửi mail (logic gửi mail mẫu)
            Mail::raw($request->content, function ($message) use ($email) {
                $message->to($email)->subject('Thông báo');
            });
        }

        // Lưu thông tin vào bảng gui_mail_thong_bao
        GuiMailThongBao::create([
            'content' => $request->content,
            'email' => $request->email ?? implode(';', $emails),
            'all_mail' => $request->all_mail,
        ]);

        return response()->json(['message' => 'Gửi mail thành công!']);
    }
}
