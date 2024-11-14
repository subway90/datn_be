<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DanhMucTinTuc;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class DanhMucTinTucController extends Controller
{
    public function all()
    {
        // Tìm danh mục theo ID
        $list = DanhMucTinTuc::all();

        // Kiểm tra xem danh mục có tồn tại không
        if (!$list) {
            return response()->json(['message' => 'Danh mục không tồn tại.'], 404);
        }
        // Tùy chỉnh tên các key
        $data = $list->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->ten_danh_muc,
                'slug' => $item->slug,
                'status' => $item->trang_thai,
                'order' => $item->thu_tu,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'deleted_at' => $item->deleted_at,
            ];
        });
        return response()->json([
            'list_cate_blog' => $data,
        ], 200);
    }

    public function list_delete()
    {
        // Tìm danh mục theo ID
        $list = DanhMucTinTuc::onlyTrashed()->get();

        // Kiểm tra xem danh mục có tồn tại không
        if ($list->isEmpty()) return response()->json(['message' => 'Danh sách trống'], 404);
        // Tùy chỉnh tên các key
        $data = $list->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->ten_danh_muc,
                'slug' => $item->slug,
                'status' => $item->trang_thai,
                'order' => $item->thu_tu,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'deleted_at' => $item->deleted_at,
            ];
        });
        return response()->json([
            'list_cate_blog' => $data,
        ], 200);
    }
    public function one($id)
    {
        // Tìm danh mục theo ID
        $get = DanhMucTinTuc::find($id);

        // Kiểm tra xem danh mục có tồn tại không
        if (!$get) {
            return response()->json(['message' => 'Danh mục không tồn tại.'], 404);
        }
        // Tùy chỉnh tên các key
        $data = [
                'id' => $get->id,
                'name' => $get->ten_danh_muc,
                'slug' => $get->slug,
                'status' => $get->trang_thai,
                'order' => $get->thu_tu,
                'created_at' => $get->created_at,
                'updated_at' => $get->updated_at,
                'deleted_at' => $get->deleted_at,
            ];
        return response()->json($data, 200);
    }

    public function edit(Request $request,$id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ],
        [
            'name.required' => 'Chưa nhập tên',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        }

        // Tìm danh mục theo ID
        $danhMuc = DanhMucTinTuc::find(id: $id);

        // Kiểm tra xem danh mục có tồn tại không
        if (!$danhMuc) {
            return response()->json(['message' => 'ID danh mục không tồn tại.'], 404);
        }

        // Cập nhật thông tin danh mục
        $danhMuc->ten_danh_muc = $request->name;
        $danhMuc->slug = Str::slug($request->name);
        $danhMuc->save();

        return response()->json([
            'message' => 'Danh mục đã được cập nhật thành công.',
            // 'danh_muc' => $danhMuc,
        ], 200);
    }

    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ],
        [
            'name.required' => 'Chưa nhập tên',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        };

        DanhMucTinTuc::create([
            'ten_danh_muc' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return response()->json([
            'message' => 'Tạo mới danh mục thành công',
        ], 201);
    }
    public function destroy($id)
    {
        // Tìm danh mục theo ID
        $danhMuc = DanhMucTinTuc::find($id);

        // Kiểm tra xem danh mục có tồn tại không
        if (!$danhMuc) {
            return response()->json(['message' => 'Danh mục không tồn tại.'], 404);
        }
        // Xóa mềm tất cả tin tức liên quan
        $danhMuc->tinTuc()->delete(); // Giả sử bạn đã định nghĩa mối quan hệ trong model DanhMucTinTuc
        // Xóa danh mục
        $danhMuc->delete();

        return response()->json(['message' => 'Danh mục đã được xóa thành công.'], 200);
    }

    // Khôi phục danh mục
    public function restore($id)
    {
        // Tìm danh mục đã bị xóa
        $danhMuc = DanhMucTinTuc::withTrashed()->find($id);

        // Kiểm tra xem danh mục có tồn tại không
        if (!$danhMuc) {
            return response()->json(['message' => 'Danh mục không tồn tại hoặc chưa bị xóa.'], 404);
        }

        // Khôi phục danh mục
        $danhMuc->restore();

        return response()->json(['message' => 'Danh mục đã được khôi phục thành công.'], 200);
    }
}
