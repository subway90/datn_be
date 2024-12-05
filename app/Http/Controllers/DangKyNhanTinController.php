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

        

        return response()->json(['message' => 'Đăng ký thành công, vui lòng kiểm tra email để xác nhận !'], 201);
    }

    public function verify($token) {

        # Trả 400
        if(!$token) return response()->json(['message'=>'Bad request'],400);

        # Kiểm tra token
        $check = DangKyNhanTin::where('token_verify',$token)->where('trang_thai','0')->first();

        # Trả về 404
        if(!$check) return view('404');

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
        $list = DangKyNhanTin::all();
        // Trả 404 nếu trống
        if($list->isEmpty()) return response()->json(['message'=>'Danh sách trống'],404);

        // custom json retunr (subway90 update)
        $result = $list->map(function($row) {
            return [
                'id' => $row->id,
                'email' => $row->email,
                'status' => $row->trang_thai ? 'Đã xác nhận' : 'Chưa xác nhận',
                'date' => $row->created_at->format('d').' Tháng '.$row->created_at->format('m').' lúc '.$row->created_at->format('H').':'.$row->created_at->format('i'),
            ];
        });
        return response()->json(['list'=>$result],200);
    }

    public function list_delete()
    {
        $list = DangKyNhanTin::onlyTrashed()->get();
        // Trả 404 nếu trống
        if($list->isEmpty()) return response()->json(['message'=>'Danh sách trống'],404);

        // custom json retunr (subway90 update)
        $result = $list->map(function($row) {
            return [
                'id' => $row->id,
                'email' => $row->email,
                'status' => $row->trang_thai ? 'Đã xác nhận' : 'Chưa xác nhận',
                'date_delete' => $row->deleted_at->format('d').' Tháng '.$row->deleted_at->format('m').' lúc '.$row->deleted_at->format('H').':'.$row->deleted_at->format('i'),
            ];
        });
        return response()->json(['list'=>$result],200);
    }

    public function destroy($id)
    {
        $record = DangKyNhanTin::find($id);
        // Kiểm tra nếu không tồn tại
        if(!$record) return response()->json(['message' => 'Không tìm thấy ID này'],404);
        // Tiến hành xóa
        $record->delete();
        return response()->json(['message' => 'Xóa thành công!'],200);
    }

    public function restore($id)
    {
        
        $record = DangKyNhanTin::onlyTrashed()->find($id);
        // Kiểm tra nếu không tồn tại
        if(!$record) return response()->json(['message' => 'Không tìm thấy ID này'],404);
        // Tiến hành khôi phục
        $record->restore();
        return response()->json(['message' => 'Khôi phục thành công!'],200);
    }
    //! Gửi mail
    public function sendMail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ], [
            'title.required' => 'Bạn chưa nhập tiêu đề thư',
            'content.required' => 'Bạn chưa nhập nội dung thư',
            'all_mail.required' => 'Trường all_mail là bắt buộc',
            'all_mail.in' => 'Trường all_mail phải là 0 hoặc 1',
        ]);

        // Báo lỗi validate
        if ($validator->fails()) return response()->json(['message' => $validator->errors()->all()],400);

        // Lấy tất cả email đã xác nhận
        $emails = DangKyNhanTin::where('trang_thai',1)->pluck('email')->toArray();

        // Kiểm tra nếu danh sách email trống
        if (empty($emails)) return response()->json(['message' => 'Danh sách email trống'], 404);

        // Gửi mail theo BCC
        Mail::raw($request->content, function ($message) use ($request,$emails) {
            $message->bcc($emails)
                    ->subject($request->title);
        });

        // Lưu thông tin vào bảng gui_mail_thong_bao
        GuiMailThongBao::create([
            'title' => $request->title,
            'content' => $request->content,
        ]);

        return response()->json(['message' => 'Gửi mail thành công!']);
    }
}
