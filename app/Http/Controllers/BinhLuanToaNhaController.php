<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BinhLuanToaNha;
use App\Models\ToaNha;
use App\Models\User;
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
            $binhLuans = BinhLuanToaNha::orderBy('created_at','DESC')->get();
            $result = $binhLuans->map(function($cmt){
                $user = User::withTrashed()->where('id',$cmt->tai_khoan_id)->get(['name','avatar'])->first();
                $building = ToaNha::withTrashed()->where('id',$cmt->toa_nha_id)->get(['ten'])->first();
                return [
                    'id' => $cmt->id,
                    'name_user' => $user->name,
                    'avatar_user' => $user->avatar ?? 'avatar/user_default.png',
                    'name_building' => $building->ten,
                    'message' => $cmt->noi_dung,
                    'date' => $cmt->created_at->format('d').' tháng '.$cmt->created_at->format('m').' năm '.$cmt->created_at->format('Y').' lúc '.$cmt->created_at->format('H').':'.$cmt->created_at->format('i'),
                ];
            });
            return response()->json([
                'list' => $result,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách bình luận',
                'error' => $e->getMessage(),
            ], 200);
        }
    }
    
    public function getid($id)
    {
        try {
            // Tìm bình luận theo ID
            $binhLuan = BinhLuanToaNha::findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $binhLuan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Không tìm thấy bình luận với ID: ' . $id,
                'error' => $e->getMessage(),
            ], 200);
        }
    }
    public function edit(Request $request, $id)
    {
        // Xác định người dùng đã đăng nhập
        $user = $request->user();

        // Xác định các quy tắc xác thực
        $validator = Validator::make($request->all(), [
            'noi_dung' => 'required|string|max:255',
        ], [
            'noi_dung.required' => 'Nội dung bình luận không được để trống.',
            'noi_dung.string' => 'Nội dung bình luận phải là chuỗi ký tự hợp lệ.',
            'noi_dung.max' => 'Nội dung bình luận không được vượt quá 255 ký tự.',
        ]);
    
        // Kiểm tra nếu có lỗi xác thực
         if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ.',
                'errors' => $validator->errors() // Trả về toàn bộ danh sách lỗi dưới dạng key-value
            ], 422); // Sử dụng HTTP 422 (Unprocessable Entity) cho lỗi validation
        }

    
        // Lấy dữ liệu đã xác thực
        $validated = $validator->validated();
    
        try {
            // Tìm bình luận theo ID
            $binhLuan = BinhLuanToaNha::findOrFail($id);
    
            // Cập nhật nội dung bình luận
            $binhLuan->noi_dung = $validated['noi_dung'];
            $binhLuan->save();
    
            // Trả về phản hồi JSON thành công
            return response()->json([
                'message' => 'Cập nhật nội dung bình luận thành công.',
                'data' => $binhLuan,
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            // Lỗi không tìm thấy bình luận theo ID
            return response()->json([
                'message' => 'Không tìm thấy bình luận với ID: ' . $id,
            ], 404); // HTTP 404 Not Found
        } catch (\Exception $e) {
            // Lỗi khác
            return response()->json([
                'message' => 'Lỗi khi cập nhật bình luận.',
                'error' => $e->getMessage(),
            ], 500); // HTTP 500 Internal Server Error
        }
    }    
    
    public function delete($id)
    {
        try {
            // Tìm bình luận và thực hiện xóa mềm
            $binhLuan = BinhLuanToaNha::findOrFail($id);
            $binhLuan->delete();

            return response()->json([
                'success' => true,
                'message' => 'Xóa bình luận thành công',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi xóa bình luận',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function getdelete()
    {
        try {
            // Lấy danh sách các bình luận đã bị xóa mềm
            $binhLuans = BinhLuanToaNha::onlyTrashed()->get();

            return response()->json([
                'success' => true,
                'data' => $binhLuans,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi lấy danh sách đã xóa',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
    public function restore($id)
    {
        try {
            // Tìm và khôi phục bình luận đã bị xóa mềm
            $binhLuan = BinhLuanToaNha::onlyTrashed()->findOrFail($id);
            $binhLuan->restore();

            return response()->json([
                'success' => true,
                'message' => 'Khôi phục bình luận thành công',
                'data' => $binhLuan,
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Lỗi khi khôi phục bình luận',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


}
