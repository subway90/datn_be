<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BinhLuanToaNha;
use App\Models\ToaNha;
use Illuminate\Support\Facades\Validator;
class BinhLuanToaNhaController extends Controller
{
    public function add(Request $request)
    {
        $user = $request->user();
        $validator = Validator::make($request->all(), [
            'slug' => 'required|string|exists:toa_nha,slug',
            'message' => 'required|string',
        ], [
            'slug.required' => 'Chưa nhập slug tòa nhà',
            'slug.string' => 'Slug phải là chuỗi',
            'slug.exists' => 'Slug tòa nhà không tồn tại',
            'message.required' => 'Chưa nhập nội dung bình luận',
            'message.string' => 'Nội dung bình luận phải là chuỗi ký tự hợp lệ',
        ]);

        // Kiểm tra nếu có lỗi xác thực
        if ($validator->fails()) return response()->json(['message' => $validator->errors()->all(),], 400);
        // Lấy dữ liệu đã xác thực
        $validated = $validator->validated();
        $toaNha = ToaNha::where('slug', $validated['slug'])->first();
        $comment = new BinhLuanToaNha();
        $comment->tai_khoan_id = $user->id;  // Lấy user ID từ thông tin đăng nhập
        $comment->toa_nha_id = $toaNha->id;
        $comment->noi_dung = $validated['message'];
        $comment->save();
        return response()->json(['message' => 'Bình luận đã được đăng thành công.'], 201);
    }
    public function getAll()
    {
        try {
            // Lấy danh sách bình luận chỉ với trường 'noi_dung'
            $binhLuans = BinhLuanToaNha::all();
    
            return response()->json([
                'success' => true,
                'data' => $binhLuans,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách bình luận',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    
}
