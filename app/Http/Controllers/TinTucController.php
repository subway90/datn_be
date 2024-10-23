<?php

namespace App\Http\Controllers;

use App\Models\BinhLuanTinTuc;
use App\Models\TinTuc;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TinTucController extends Controller
{
    public function getAll()
    {
        // Lấy tất cả các tòa nhà cùng với số lượng phòng
        $list = TinTuc::where('trang_thai',1)
            ->with('danhMuc')
            ->get();
    
        // Kiểm tra xem có dữ liệu hay không
        if ($list->isEmpty()) {
            return response()->json(['message' => 'Không có dữ liệu'], 404);
        }
    
        $result = $list->map(function (TinTuc $rows) {
            return [
                'id' => $rows->id,
                'slug' => $rows->slug,
                'image' => $rows->image,
                'name_cate' => $rows->danhMuc->ten_danh_muc,
                'title' => $rows->tieu_de,
                'body' => $rows->noi_dung,
                'created_at' => $rows->created_at,
                'updated_at' => $rows->updated_at,
            ];
        });
    
        return response()->json($result);
    }

    public function getOne(Request $request)
    {
        // Lấy slug từ query parameter
        $slug = $request->query('slug');

        // Thông tin tin tức
        $tintuc = TinTuc::where('slug', $slug)
            ->with('danhMuc',)
            ->first();

        // Danh sách bình luận
        $list_cmt = BinhLuanTinTuc::where('tin_tuc_id', $tintuc->id)
            ->with('user')
            ->get();

        // Chuyển đổi danh sách bình luận thành mảng
        $result_list_cmt = $list_cmt->map(function ($cmt) {
            return [
                'id_user' => $cmt->user->id,
                'name' => $cmt->user->name,
                'avatar' => $cmt->user->avatar,
                'content' => $cmt->noi_dung,
                'created_at' => $cmt->created_at,
            ];
        });

        // Kiểm tra nếu không tìm thấy tin tức
        if (!$tintuc) {
            return response()->json(['message' => 'Tin tức không tồn tại'], 404);
        }
        
        // Trả về JSON với tin tức và các bình luận
        return response()->json([
            'id' => $tintuc->id,
            'slug' => $tintuc->slug,
            'image' => $tintuc->image,
            'name_category' => $tintuc->danhMuc->ten_danh_muc,
            'title' => $tintuc->tieu_de,
            'body' => $tintuc->noi_dung,
            'created_at' => $tintuc->created_at,
            'updated_at' => $tintuc->updated_at,
            'list_cmt' => $result_list_cmt,
    ]);
    }

    public function postComment(Request $request)
    {
        // Xác định các quy tắc xác thực
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string',
            'user_id' => 'required|integer',
            'message' => 'required|string',
        ], [
            'slug.required' => 'Slug của bài viết là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi ký tự hợp lệ.',
            'user_id.required' => 'ID người dùng là bắt buộc.',
            'user_id.integer' => 'ID người dùng phải là một số nguyên hợp lệ.',
            'message.required' => 'Nội dung bình luận không được để trống.',
            'message.string' => 'Nội dung bình luận phải là chuỗi ký tự hợp lệ.',
        ]);
    
        // Kiểm tra nếu có lỗi xác thực
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
            ], 400); // Trả về mã 422 nếu có lỗi
        }
    
        // Lấy dữ liệu đã xác thực
        $validated = $validator->validated();
    
        // Tìm bài viết theo slug
        $tinTuc = TinTuc::where('slug', $validated['slug'])->get();
        
        // Kiểm tra nếu không tìm thấy bài viết
        if (!$tinTuc) {
            return response()->json([
                'message' => 'Bài viết không tồn tại.',
            ], 404);
        }
        
        // Tìm user theo user_id
        $checkUser =TinTuc::where('tai_khoan_id', $validated['user_id'])->get();
    
        // Kiểm tra nếu không tìm thấy user_id
        if (!$checkUser) {
            return response()->json([
                'message' => 'User không tồn tại.',
            ], 404);
        }
        
        // Tạo bình luận mới
        $comment = new BinhLuanTinTuc();
        $comment->tai_khoan_id = $validated['user_id'];
        $comment->tin_tuc_id = $tinTuc->id;  
        $comment->noi_dung = $validated['message'];
    
        // Lưu bình luận vào DB
        $comment->save();
    
        // Trả về phản hồi JSON thành công
        return response()->json([
            'message' => 'Bình luận đã được đăng thành công.',
            'data' => $comment
        ], 201);
    }   
     public function updateComment(Request $request)
    {
        // Xác định các quy tắc xác thực
        $validator = Validator::make($request->all(), [
            'id' => 'required|integer',  // kiểm tra ID bình luận có tồn tại
            'status' => 'required|boolean',
            'message' => 'required|string',
        ], [
            'id.required' => 'ID bình luận là bắt buộc.',
            'id.integer' => 'ID bình luận phải là một số nguyên.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.boolean' => 'Trạng thái phải là 1',
            'message.required' => 'Nội dung bình luận là bắt buộc.',
            'message.string' => 'Nội dung bình luận phải là một chuỗi.',
        ]);

        // Kiểm tra nếu có lỗi xác thực
        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422); // Trả về mã 422 nếu có lỗi
        }

        // Tìm bình luận theo ID
        $comment = BinhLuanTinTuc::find($validator->validated()['id']);

        if (!$comment) {
            return response()->json([
                'message' => 'Bình luận không tồn tại.'
            ], 404);
        }

        // Cập nhật các trường cho phép
        $comment->noi_dung = $validator->validated()['message'];
        $comment->trang_thai = $validator->validated()['status'];
        $comment->updated_at = now();  // sử dụng thời gian hiện tại

        // Lưu bình luận đã chỉnh sửa
        $comment->save();

        // Trả về phản hồi JSON thành công
        return response()->json([
            'message' => 'Bình luận đã được cập nhật thành công.',
            'data' => $comment
        ], 200);
    }
}
