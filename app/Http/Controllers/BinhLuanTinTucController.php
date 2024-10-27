<?php

namespace App\Http\Controllers;

use App\Models\BinhLuanTinTuc;
use App\Models\TinTuc;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class BinhLuanTinTucController extends Controller
{
    public function postComment(Request $request)
    {
        // Xác định người dùng đã đăng nhập qua request
        $user = $request->user();

        // Nếu người dùng chưa đăng nhập, trả về lỗi
        if (!$user) {
            return response()->json([
                'message' => 'Bạn cần đăng nhập để thực hiện bình luận.'
            ], status: 400); // Trả về mã 400 nếu chưa đăng nhập
        }

        // Xác định các quy tắc xác thực
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string',
            'message' => 'required|string',
        ], [
            'slug.required' => 'Slug của bài viết là bắt buộc.',
            'slug.string' => 'Slug phải là chuỗi ký tự hợp lệ.',
            'message.required' => 'Nội dung bình luận không được để trống.',
            'message.string' => 'Nội dung bình luận phải là chuỗi ký tự hợp lệ.',
        ]);

        // Kiểm tra nếu có lỗi xác thực
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
            ], 400); // Mã 400 nếu có lỗi
        }

        // Lấy dữ liệu đã xác thực
        $validated = $validator->validated();

        // Tìm bài viết theo slug
        $tinTuc = TinTuc::where('slug', $validated['slug'])->first();

        // Kiểm tra nếu không tìm thấy bài viết
        if (!$tinTuc) {
            return response()->json([
                'message' => 'Bài viết không tồn tại.',
            ], 404);
        }

        // Tạo bình luận mới
        $comment = new BinhLuanTinTuc();
        $comment->tai_khoan_id = $user->id;  // Lấy user ID từ thông tin đăng nhập
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
                'message' => $validator->errors()->all(),
            ], 400);
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
        ], 200);
    }
}
