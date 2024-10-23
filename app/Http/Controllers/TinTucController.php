<?php

namespace App\Http\Controllers;

use App\Models\BinhLuanTinTuc;
use App\Models\TinTuc;
use Illuminate\Http\Request;

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

        // Tìm tin tức dựa trên slug
        $tintuc = TinTuc::where('slug', $slug)->with('BinhLuanTinTuc')->first();
        

        // Kiểm tra nếu không tìm thấy tin tức
        if (!$tintuc) {
            return response()->json(['error' => 'Tin tức không tồn tại'], 404);
        }

        // Trả về JSON với tin tức và các bình luận
        return response()->json($tintuc);
    }
    public function postComment(Request $request)
    {
        // Validate dữ liệu nhận vào
        $validated = $request->validate([
            'slug' => 'required|string',
            'tai_khoan_id' => 'required|integer',
            'noi_dung' => 'required|string',
        ]);

        // Tìm bài viết theo slug
        $tinTuc = TinTuc::where('slug', $validated['slug'])->first();

        // Kiểm tra nếu không tìm thấy bài viết
        if (!$tinTuc) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bài viết không tồn tại.',
            ], 404);
        }

        // Tạo bình luận mới
        $comment = new BinhLuanTinTuc();
        $comment->tai_khoan_id = $validated['tai_khoan_id'];
        $comment->tin_tuc_id = $tinTuc->id;  
        $comment->noi_dung = $validated['noi_dung'];

        // Lưu bình luận vào DB
        $comment->save();

        // Trả về phản hồi JSON thành công
        return response()->json([
            'status' => 'success',
            'message' => 'Bình luận đã được đăng thành công.',
            'data' => $comment
        ], 201);
    }
    public function updateComment(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validated = $request->validate([
            'id' => 'required|integer',  // kiểm tra ID bình luận có tồn tại
            'trang_thai' => 'required|boolean',
            'noi_dung' => 'required|string',
        ]);

        // Tìm bình luận theo ID
        $comment = BinhLuanTinTuc::find($validated['id']);

        if (!$comment) {
            return response()->json([
                'status' => 'error',
                'message' => 'Bình luận không tồn tại.'
            ], 404);
        }

        // Cập nhật các trường cho phép
        $comment->noi_dung = $validated['noi_dung'];
        $comment->trang_thai = $validated['trang_thai'];
        $comment->updated_at = now();  // sử dụng thời gian hiện tại

        // Lưu bình luận đã chỉnh sửa
        $comment->save();

        // Trả về phản hồi JSON thành công
        return response()->json([
            'status' => 'success',
            'message' => 'Bình luận đã được cập nhật thành công.',
            'data' => $comment
        ], 200);
    }

}
