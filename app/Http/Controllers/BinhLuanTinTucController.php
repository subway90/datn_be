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
            'message' => 'Bình luận đã được đăng thành công.'], 201);
    }
    
    public function updateComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id_cmt' => 'required|integer|exists:binh_luan_tin_tuc,id',
            'message' => 'required|string',
            'slug' => 'required|string|exists:tin_tuc,slug',
        ], [
            'id_cmt.required' => 'Chưa nhập ID bình luận',
            'id_cmt.integer' => 'ID bình luận phải là một số nguyên',
            'message.required' => 'Chưa nhập nội dung bình luận',
            'message.string' => 'Nội dung bình luận phải là một chuỗi',
            'slug.required' => 'Chưa nhập slug tin tức',
            'slug.exists' => 'Slug bài viết này không tồn tại',
            'id_cmt.exists' => 'ID bình luận này không tồn tại',
        ]);
        // Bắt validate
        if ($validator->fails()) return response()->json(['message' => $validator->errors()->all(),], 400);
        // Kiểm tra id_user của cmt này có phải của user đang sửa hay không
        $user_id = $request->user()->id;
        $comment = BinhLuanTinTuc::find($request->id_cmt);
        if ($comment->tai_khoan_id !== $user_id) return response()->json(['message' => 'ID bình luận không phải của bạn.'], 401);
        // Cập nhật nội dung của bình luận
        $comment->noi_dung = $request->message;
        $comment->updated_at = now();
        $comment->save();
        return response()->json(['message' => 'Bình luận đã được cập nhật thành công.',], 200);
    }

}
