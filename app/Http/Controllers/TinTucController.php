<?php

namespace App\Http\Controllers;

use App\Models\BinhLuanTinTuc;
use App\Models\TinTuc;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TinTucController extends Controller
{
    public function getAll()
    {
        // Lấy tất cả các tòa nhà cùng với số lượng phòng
        $list = TinTuc::where('trang_thai',1)
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

    public function getAllListNew()
    {
        // Lấy tất cả các tòa nhà cùng với số lượng phòng
        $list = TinTuc::where('trang_thai',1)
            ->with('danhMuc')
            ->orderBy('created_at','DESC')
            ->limit(4)
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
                'date' => $rows->created_at->format('d').' Tháng '.$rows->created_at->format('m').' lúc '.$rows->created_at->format('H').':'.$rows->created_at->format('i'), // Định dạng ngà
            ];
        });
    
        return response()->json($result);
    }

    public function getOneByID(Request $request,$id)
    {
        // Lấy slug từ query parameter
        // Thông tin tin tức
        $tintuc = TinTuc::find($id)->first();

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
    ]);
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
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:tin_tuc,tieu_de',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'trang_thai' => 'boolean',
            'cate_id' => 'required|integer|exists:danh_muc_tin_tuc,id',
        ],
        [
            'title.required' => 'Chưa nhập tên',
            'title.unique' => 'Tiêu đề này đã tồn tại',
            'image.required' => 'Bạn chưa nhập ảnh',
            'image.mimes' => 'Chưa nhập đúng định dạng ảnh',
            'image.max' => 'Ảnh phải dưới 2MB',
            'content.required' => 'Chưa nhập nội dung',
            'status.boolean' => 'Trạng thái phải là 0 hoặc 1',
            'cate_id.required' => 'Chưa nhập danh mục',
            'cate_id.exists' => 'Danh mục không tồn tại',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        }
    
        // Xử lý ảnh nếu có
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blog', 'public');
        }
        $status = $request->input('trang_thai', 1);
        // Tạo mới bản ghi TinTuc với `id_tai_khoan` từ tài khoản đã đăng nhập
        TinTuc::create([
            'tai_khoan_id' => $request->user()->id, // ID tài khoản hiện tại
            'danh_muc_id' => $request->cate_id,
            'tieu_de' => $request->title,
            'slug' => Str::slug($request->title),
            'image' => $imagePath,
            'noi_dung' => $request->content,
            'trang_thai' => $status,
        ]);
    
        return response()->json([
            'message' => 'Tạo mới tin tức thành công',
        ], 201);
    }
    public function destroy($id)
    {
        // Tìm tin tức theo ID
        $tinTuc = TinTuc::find($id);

        // Kiểm tra xem tin tức có tồn tại không
        if (!$tinTuc) {
            return response()->json(['message' => 'Tin tức không tồn tại.'], 404);
        }
        // Xóa mềm tất cả bình luận liên quan
        $tinTuc->BinhLuanTinTuc()->delete(); 
        // Xóa Tin Tức
        $tinTuc->delete();

        return response()->json(['message' => 'Tin tức đã được xóa thành công.'], 200);
    }
    public function restore($id)
    {
        // Tìm tin tức đã bị xóa
        $tinTuc = TinTuc::withTrashed()->find($id);

        // Kiểm tra xem tin tức có tồn tại không
        if (!$tinTuc) {
            return response()->json(['message' => 'Tin tức không tồn tại hoặc chưa bị xóa.'], 404);
        }

        // Khôi phục tin tức
        $tinTuc->restore();

        return response()->json(['message' => 'Tin tức đã được khôi phục thành công.'], 200);
    }
    public function duplicate($id){
        $tinTuc = TinTuc::find($id);
        if (!$tinTuc) {
            return response()->json(['message' => 'Tin tức không tồn tại.'], 404);
        }
        // Tạo 1 tiêu đề mới bằng cách nối chuỗi
        $newtieu_de = $tinTuc->tieu_de . '-copy';

        // Tạo 1 slug mới bằng cách str tiêu đề mới
        $newslug = Str::slug($newtieu_de);
       
        // Lưu vào database 
        $newTinTuc = TinTuc::create([
        'tai_khoan_id' => $tinTuc->tai_khoan_id,
        'danh_muc_id' => $tinTuc->danh_muc_id,
        'tieu_de' => $newtieu_de,
        'slug' => $newslug,
        'image' => $tinTuc->image,
        'noi_dung' => $tinTuc->noi_dung,
        'trang_thai' => $tinTuc->trang_thai,
        ]);
        
        return response()->json([
            'message' => 'Tin tức đã được sao chép và lưu thành công.',
        ], 200);

    }
}
