<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KhuVuc;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class KhuVucController extends Controller
{
    public function listHot()
    {
        // Lấy tất cả khu vực
        $list = KhuVuc::where('noi_bat', 1)->get();
    
        // Kiểm tra nếu không có dữ liệu
        if ($list->isEmpty()) {
            return response()->json(['message' => 'Danh sách trống'], 404);
        }

        //
        $result = $list->map(function ($rows) {
            return [
                'id' => $rows->id,
                'slug' => $rows->slug,
                'name' => $rows->ten,
                'image' => $rows->image,
                'created_at' => $rows->created_at,
                'updated_at' => $rows->updated_at,
            ];
        });
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($result, 200);
    }

    public function option()
    {
        // Lấy tất cả khu vực
        $list = KhuVuc::all();
    
        // Kiểm tra nếu không có dữ liệu
        if ($list->isEmpty()) {
            return response()->json(['message' => 'Danh sách trống'], 404);
        }

        //
        $result = $list->map(function ($rows) {
            return [
                'id' => $rows->id,
                'slug' => $rows->slug,
                'name' => $rows->ten,
            ];
        });
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($result, 200);
    }

    public function all()
    {
        // Lấy tất cả khu vực
        $list = KhuVuc::all();
    
        // Kiểm tra nếu không có dữ liệu
        if ($list->isEmpty()) {
            return response()->json(['message' => 'Danh sách trống'], 404);
        }

        //
        $result = $list->map(function ($rows) {
            return [
                'id' => $rows->id,
                'slug' => $rows->slug,
                'name' => $rows->ten,
                'image' => $rows->image,
                'created_at' => $rows->created_at,
                'updated_at' => $rows->updated_at,
            ];
        });
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($result, 200);
    }

    public function one($id)
    {
        $one = KhuVuc::find($id);
        if (!$one) return response()->json(['message' => 'Khu vực không tồn tại'], 404);
        $result = [
                'id' => $one->id,
                'slug' => $one->slug,
                'name' => $one->ten,
                'image' => $one->image,
                'created_at' => $one->created_at,
                'updated_at' => $one->updated_at,
            ];
        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'name' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'noi_bat' => 'nullable|boolean',
        ],[
            'name.required' => 'Vui lòng nhập tên',
            'image.mimes' => 'Chưa nhập đúng định dạng ảnh',
            'image.max' => 'Ảnh phải dưới 2MB',
            'noi_bat.boolean' => 'Dữ liệu noi_bat sai. Nhập 0: không nổi bật, 1: nổi bật'
        ]
    );  

        //Kiểm tra tên tồn tại hay chưa
        $checkName = KhuVuc::where('ten',$request->name)->exists();
        if($checkName) return response()->json(['message' => 'Tên này đã tồn tại'],400);

        // Xử lý upload ảnh
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('area', 'public');
        }

        // Tạo mới khu vực
        $khuVuc = KhuVuc::create([
            'ten' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'noi_bat' => $request->noi_bat ?? 0,
        ]);

        return response()->json([
            'message' => 'Khu vực đã được thêm thành công',
            'khu_vuc' => $khuVuc,
        ], 201);
    }

    public function delete($id)
    {
        $khuVuc = KhuVuc::find($id);
        if (!$khuVuc) {
            return response()->json(['message' => 'Khu vực không tồn tại'], 404);
        }
        // Xóa mềm khu vực
        $khuVuc->delete();

        return response()->json(['message' => 'Xóa thành công'], 200);
    }

    public function restore($id)
    {
        $khuVuc = KhuVuc::withTrashed()->find($id);

        if (!$khuVuc) {
            return response()->json(['message' => 'Khu vực không tồn tại'], 404);
        }
        $khuVuc->restore();
        return response()->json(['message' => 'Khu vực đã được khôi phục'], 200);
    }

    public function list_delete()
    {
        // Lấy tất cả khu vực đã bị xóa mềm
        $trashedKhuVuc = KhuVuc::onlyTrashed()->get();

        // Kiểm tra nếu không có dữ liệu
        if ($trashedKhuVuc->isEmpty()) {
            return response()->json(['message' => 'Không có khu vực nào đã bị xóa'], 404);
        }

        // Chuyển đổi kết quả thành mảng
        $result = $trashedKhuVuc->map(function ($khuVuc) {
            return [
                'id' => $khuVuc->id,
                'slug' => $khuVuc->slug,
                'name' => $khuVuc->ten,
                'image' => $khuVuc->image,
                'created_at' => $khuVuc->created_at,
                'updated_at' => $khuVuc->updated_at,
                'deleted_at' => $khuVuc->deleted_at, // Thời gian bị xóa
            ];
        });

        return response()->json($result, 200);
    }

    public function duplicate($id)
    {
        $khuVuc = KhuVuc::find($id);
        if (!$khuVuc) {
            return response()->json(['message' => 'Khu vực không tồn tại.'], 404);
        }
    
        // Tạo 1 tiêu đề mới bằng cách nối chuỗi
        $baseTitle = $khuVuc->ten . '-copy';
        $newName = $baseTitle;

        // Kiểm tra xem tiêu đề đã tồn tại trong cơ sở dữ liệu chưa
        $counter = 1;
        while (khuVuc::where('ten', $newName)->exists()) {
            $newName = $baseTitle . '-' . $counter; // Tạo tên mới với bộ đếm
            $counter++;
        }
        // Tạo 1 slug mới từ tiêu đề mới
        $newSlug = Str::slug($newName);
    
        // Tạo tên file mới cho ảnh
        $oldImagePath = $khuVuc->image; // Đường dẫn ảnh cũ
        $imageExtension = pathinfo($oldImagePath, PATHINFO_EXTENSION);
        $newImageName = pathinfo($oldImagePath, PATHINFO_FILENAME) . '-' . uniqid() . '.' . $imageExtension;
        $newImagePath = 'area/' . $newImageName; // Đường dẫn ảnh mới trong thư mục blog
    
        // Sao chép file ảnh
        if (Storage::disk('public')->exists($oldImagePath)) {
            // Sao chép file từ đường dẫn cũ sang đường dẫn mới
            Storage::disk('public')->copy($oldImagePath, $newImagePath);
        } else {
            return response()->json(['message' => 'File ảnh cũ không tồn tại.'], 404);
        }
    
        // Lưu vào database 
        $newkhuVuc = khuVuc::create([
            'ten' => $newName,
            'slug' => $newSlug,
            'image' => $newImagePath,
        ]);
    
        return response()->json([
            'message' => 'Nhân bản thành công khu vực với ID = '.$id,
        ], 200);
    }
}
