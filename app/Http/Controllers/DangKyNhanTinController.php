<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DangKyNhanTin;
use App\Models\GuiMailThongBao;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

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
            'email.unique' => 'Email đã được đăng ký',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        DangKyNhanTin::create(['email' => $request->email]);

        return response()->json(['message' => 'Đăng ký thành công!'], 201);
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
