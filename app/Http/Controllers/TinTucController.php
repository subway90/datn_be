<?php

namespace App\Http\Controllers;

use App\Models\BinhLuanTinTuc;
use App\Models\TinTuc;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class TinTucController extends Controller
{
    public function getAll()
    {
        // Lấy tất cả các tòa nhà cùng với số lượng phòng
        $list = TinTuc::orderBy('created_at','DESC')
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
                'description' => $rows->mo_ta,
                'content' => $rows->noi_dung,
                'date' => $rows->created_at->format('d').' Tháng '.$rows->created_at->format('m').' lúc '.$rows->created_at->format('H').':'.$rows->created_at->format('i'),
            ];
        });
    
        return response()->json($result);
    }

    public function getAllListNew()
    {
        // Lấy tất cả các tòa nhà cùng với số lượng phòng
        $list = TinTuc::with('danhMuc')
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
                'description' => $rows->mo_ta,
                'content' => $rows->noi_dung,
                'date' => $rows->created_at->format('d').' Tháng '.$rows->created_at->format('m').' lúc '.$rows->created_at->format('H').':'.$rows->created_at->format('i'),
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
            'description' => $tintuc->mo_ta,
            'content' => $tintuc->noi_dung,
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
                'date' => $cmt->created_at->format('d').' Thg '.$cmt->created_at->format('m').' lúc '.$cmt->created_at->format('H').':'.$cmt->created_at->format('i'),
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
            'description' => $tintuc->mo_ta,
            'body' => $tintuc->noi_dung,
            'date' => $tintuc->created_at->format('d').' Tháng '.$tintuc->created_at->format('m').' lúc '.$tintuc->created_at->format('H').':'.$tintuc->created_at->format('i'),
            'list_cmt' => $result_list_cmt,
    ]);
    }
    public function add(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:tin_tuc,tieu_de',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'content' => 'required|string',
            'cate_id' => 'required|integer|exists:danh_muc_tin_tuc,id',
            'description' => 'required',
        ],
        [
            'title.required' => 'Chưa nhập tên',
            'title.unique' => 'Tiêu đề này đã tồn tại',
            'image.required' => 'Bạn chưa nhập ảnh',
            'image.mimes' => 'Chưa nhập đúng định dạng ảnh',
            'image.max' => 'Ảnh phải dưới 2MB',
            'content.required' => 'Chưa nhập nội dung',
            'cate_id.required' => 'Chưa nhập danh mục',
            'description.required' => 'Chưa nhập mô tả',
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
        // Tạo mới bản ghi TinTuc với `id_tai_khoan` từ tài khoản đã đăng nhập
        TinTuc::create([
            'tai_khoan_id' => $request->user()->id, // ID tài khoản hiện tại
            'danh_muc_id' => $request->cate_id,
            'tieu_de' => $request->title,
            'mo_ta' => $request->description,
            'slug' => Str::slug($request->title),
            'image' => $imagePath,
            'noi_dung' => $request->content,
        ]);
    
        return response()->json([
            'message' => 'Tạo mới tin tức thành công',
        ], 201);
    }
    public function edit(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|unique:tin_tuc,tieu_de,'.$id,
            'image' => 'nullable|string',
            'content' => 'required|string',
        ], [
            'title.required' => 'Chưa nhập tiêu đề',
            'title.unique' => 'Tiêu đề này đã tồn tại',
            'content.required' => 'Chưa nhập nội dung',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->all()], 400);
        }

        // Tìm tin tức theo ID
        $tinTuc = TinTuc::find($id);
        if (!$tinTuc) {
            return response()->json(['message' => 'Tin tức không tồn tại'], 404);
        }

        // Xử lý ảnh nếu có
        if ($request->has('image')) {
            // Xóa file ảnh cũ nếu có
            if ($tinTuc->image) {
                Storage::disk('public')->delete($tinTuc->image);
            }

            // Lấy dữ liệu base64 từ request
            $base64Image = $request->input('image');

            // Tách phần header của base64
            if (preg_match('/^data:image\/(\w+);base64,/', $base64Image, $type)) {
                $base64Image = substr($base64Image, strpos($base64Image, ',') + 1);
                $type = strtolower($type[1]); // Lấy loại ảnh (jpeg, png, ...)

                // Kiểm tra loại ảnh
                if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                    return response()->json(['message' => 'Định dạng ảnh không hợp lệ'], 400);
                }

                // Giải mã base64
                $image = base64_decode($base64Image);
                if ($image === false) {
                    return response()->json(['message' => 'Giải mã base64 không thành công'], 400);
                }

                // Tạo tên file ảnh duy nhất
                $fileName = uniqid('img_', true) . '.' . $type;

                // Lưu ảnh vào thư mục
                $path = 'blog/' . $fileName;
                Storage::disk('public')->put($path, $image);

                // Cập nhật đường dẫn ảnh trong bản ghi
                $tinTuc->image = $path;
            }
        }

        // Cập nhật các trường khác
        $tinTuc->tieu_de = $request->input('title');
        $tinTuc->noi_dung = $request->input('content');

        // Lưu bản ghi
        $tinTuc->save();

        return response()->json(['message' => 'Cập nhật tin tức thành công'], 200);
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
    public function duplicate($id)
    {
        $tinTuc = TinTuc::find($id);
        if (!$tinTuc) {
            return response()->json(['message' => 'Tin tức không tồn tại.'], 404);
        }
    
        // Tạo 1 tiêu đề mới bằng cách nối chuỗi
        $baseTitle = $tinTuc->tieu_de . '-copy';
        $newtieu_de = $baseTitle;

        // Kiểm tra xem tiêu đề đã tồn tại trong cơ sở dữ liệu chưa
        $counter = 1;
        while (TinTuc::where('tieu_de', $newtieu_de)->exists()) {
            $newtieu_de = $baseTitle . '-' . $counter; // Tạo tên mới với bộ đếm
            $counter++;
        }
        // Tạo 1 slug mới từ tiêu đề mới
        $newslug = Str::slug($newtieu_de);
    
        // Tạo tên file mới cho ảnh
        $oldImagePath = $tinTuc->image; // Đường dẫn ảnh cũ
        $imageExtension = pathinfo($oldImagePath, PATHINFO_EXTENSION);
        $newImageName = pathinfo($oldImagePath, PATHINFO_FILENAME) . '-' . uniqid() . '.' . $imageExtension;
        $newImagePath = 'blog/' . $newImageName; // Đường dẫn ảnh mới trong thư mục blog
    
        // Sao chép file ảnh
        if (Storage::disk('public')->exists($oldImagePath)) {
            // Sao chép file từ đường dẫn cũ sang đường dẫn mới
            Storage::disk('public')->copy($oldImagePath, $newImagePath);
        } else {
            return response()->json(['message' => 'File ảnh cũ không tồn tại.'], 404);
        }
    
        // Lưu vào database 
        $newTinTuc = TinTuc::create([
            'tai_khoan_id' => $tinTuc->tai_khoan_id,
            'danh_muc_id' => $tinTuc->danh_muc_id,
            'tieu_de' => $newtieu_de,
            'slug' => $newslug,
            'image' => $newImagePath, // Cập nhật với đường dẫn ảnh mới
            'noi_dung' => $tinTuc->noi_dung,
            'mo_ta' => $tinTuc->mo_ta,
        ]);
    
        return response()->json([
            'message' => 'Tin tức đã được sao chép và lưu thành công.',
        ], 200);
    }
}
