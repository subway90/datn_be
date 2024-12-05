<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class BannerController extends Controller
{
    public function show()
    {
        // Lấy tất cả banner
        $list = Banner::where('status','1')->orderBy('order','ASC')->get();
    
        // Kiểm tra nếu không có dữ liệu
        if ($list->isEmpty()) {
            return response()->json(['message' => 'Danh sách trống'], 404);
        }
    
        // Map dữ liệu trả về
        $result = $list->map(function ($row) {
            return [
                'id' => $row->id,
                'title' => $row->title,
                'content' => $row->content,
                'image' => $row->image,
                'order' => $row->order,
            ];
        });
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($result, 200);
    }
    

    public function one($id)
    {
        // Tìm banner theo ID
        $one = Banner::find($id);

        // Kiểm tra nếu không tồn tại
        if (!$one) {
            return response()->json(['message' => 'Banner không tồn tại'], 404);
        }

        // Chuẩn hóa dữ liệu trả về
        $result = [
            'id' => $one->id,
            'image' => $one->image,
            'title' => $one->title,
            'content' => $one->content,
            'order' => $one->order,
            'created_at' => $one->created_at,
            'updated_at' => $one->updated_at,
        ];

        // Trả về JSON
        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        // Xác thực dữ liệu
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề',
            'image.mimes' => 'Chưa nhập đúng định dạng ảnh',
            'image.max' => 'Ảnh phải dưới 2MB',
            'order.integer' => 'Thứ tự phải là số nguyên',
        ]);

        // Kiểm tra tiêu đề đã tồn tại hay chưa
        $checkTitle = Banner::where('title', $request->title)->exists();
        if ($checkTitle) {
            return response()->json(['message' => 'Tiêu đề này đã tồn tại'], 400);
        }

        // Xử lý upload ảnh
        $imagePath = null;
        if ($request->hasFile('image')) {
            // Lưu file vào thư mục public/storage/banner
            $imagePath = $request->file('image')->store('banner', 'public');
        }

        // Tạo mới banner
        $banner = Banner::create([
            'title' => $request->title,
            'image' => $imagePath,
            'content' => $request->content,
            'order' => $request->order ?? 0,
        ]);

        return response()->json([
            'message' => 'Banner đã được thêm thành công',
            'banner' => $banner,
        ], 201);
    }

    public function delete($id)
    {
        // Tìm banner theo ID
        $banner = Banner::find($id);
    
        // Kiểm tra nếu không tồn tại
        if (!$banner) {
            return response()->json(['message' => 'Banner không tồn tại'], 404);
        }
    
        // Thực hiện xóa mềm
        $banner->delete();
    
        return response()->json(['message' => 'Banner đã được xóa thành công'], 200);
    }
    

    public function restore($id)
    {
        // Tìm banner kể cả khi đã bị xóa mềm
        $banner = Banner::withTrashed()->find($id);
    
        // Kiểm tra nếu không tồn tại
        if (!$banner) {
            return response()->json(['message' => 'Banner không tồn tại'], 404);
        }
    
        // Kiểm tra nếu bản ghi chưa bị xóa mềm
        if ($banner->deleted_at === null) {
            return response()->json(['message' => 'Banner chưa bị xóa, không cần khôi phục'], 400);
        }
    
        // Khôi phục banner đã bị xóa mềm
        $banner->restore();
    
        return response()->json(['message' => 'Banner đã được khôi phục thành công'], 200);
    }
    

    public function list_delete()
    {
        // Lấy tất cả banner đã bị xóa mềm
        $trashedBanners = Banner::onlyTrashed()->get();

        // Kiểm tra nếu không có dữ liệu
        if ($trashedBanners->isEmpty()) {
            return response()->json(['message' => 'Không có banner nào đã bị xóa'], 404);
        }

        // Chuyển đổi kết quả thành mảng
        $result = $trashedBanners->map(function ($banner) {
            return [
                'id' => $banner->id,
                'title' => $banner->title,
                'image' => $banner->image,
                'content' => $banner->content,
                'order' => $banner->order,
                'created_at' => $banner->created_at,
                'updated_at' => $banner->updated_at,
                'deleted_at' => $banner->deleted_at, // Thời gian bị xóa
            ];
        });

        return response()->json($result, 200);
    }


    public function duplicate($id)
    {
        // Tìm banner theo ID
        $banner = Banner::find($id);
        if (!$banner) {
            return response()->json(['message' => 'Banner không tồn tại.'], 404);
        }
    
        // Tạo tiêu đề mới bằng cách nối chuỗi
        $baseTitle = $banner->title . '-copy';
        $newTitle = $baseTitle;
    
        // Kiểm tra xem tiêu đề đã tồn tại trong cơ sở dữ liệu chưa
        $counter = 1;
        while (Banner::where('title', $newTitle)->exists()) {
            $newTitle = $baseTitle . '-' . $counter; // Tạo tiêu đề mới với bộ đếm
            $counter++;
        }
    
        // Tạo file ảnh mới
        $oldImagePath = $banner->image; // Đường dẫn ảnh cũ
        $newImagePath = null;
    
        // Kiểm tra và sao chép file ảnh
        if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
            $imageExtension = pathinfo($oldImagePath, PATHINFO_EXTENSION);
            $newImageName = pathinfo($oldImagePath, PATHINFO_FILENAME) . '-' . uniqid() . '.' . $imageExtension;
            $newImagePath = 'banner/' . $newImageName; // Đường dẫn ảnh mới
    
            // Sao chép file từ đường dẫn cũ sang đường dẫn mới
            Storage::disk('public')->copy($oldImagePath, $newImagePath);
        } elseif ($oldImagePath) {
            return response()->json(['message' => 'File ảnh cũ không tồn tại.'], 404);
        }
    
        // Tạo bản sao trong database
        $newBanner = Banner::create([
            'title' => $newTitle,
            'image' => $newImagePath,
            'content' => $banner->content, // Sao chép nội dung
            'order' => $banner->order, // Sao chép thứ tự
        ]);
    
        return response()->json([
            'message' => 'Nhân bản thành công banner với ID = ' . $id,
            'new_banner' => $newBanner,
        ], 200);
    }
    
        public function update(Request $request, $id)
    {
        // Tìm banner theo ID
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner không tồn tại'], 404);
        }

        // Xác thực dữ liệu
        $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'nullable|string',
            'order' => 'nullable|integer',
        ], [
            'title.required' => 'Vui lòng nhập tiêu đề',
            'image.mimes' => 'Chưa nhập đúng định dạng ảnh',
            'image.max' => 'Ảnh phải dưới 2MB',
            'order.integer' => 'Thứ tự phải là số nguyên',
        ]);

        // Kiểm tra tiêu đề trùng lặp (ngoại trừ bản ghi hiện tại)
        $checkTitle = Banner::where('title', $request->title)->where('id', '!=', $id)->exists();
        if ($checkTitle) {
            return response()->json(['message' => 'Tiêu đề này đã tồn tại'], 400);
        }

        // Xử lý upload ảnh nếu có
        if ($request->hasFile('image')) {
            // Xóa ảnh cũ nếu tồn tại
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            // Lưu ảnh mới vào thư mục public/storage/banner
            $imagePath = $request->file('image')->store('banner', 'public');
            $banner->image = $imagePath;
        }

        // Cập nhật dữ liệu khác
        $banner->title = $request->title;
        $banner->content = $request->content;
        $banner->order = $request->order ?? 0;
        $banner->save();

        return response()->json([
            'message' => 'Banner đã được cập nhật thành công',
            'banner' => $banner,
        ], 200);
    }

}
