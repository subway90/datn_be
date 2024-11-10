<?php
namespace App\Http\Controllers;

use App\Models\ToaNha;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ToaNhaController extends Controller
{
    public function detail(Request $request)
    {
        $detail = ToaNha::with('phongTro')
        ->with('khuVuc')
        ->where('slug', $request->slug)->get();

        if (!$detail) {
            return response()->json(['message' => 'Tòa nhà không tồn tại'], 404);
        }
        $result = $detail->map(function ($rows) {
            return [
                'id' => $rows->id,
                'khu_vuc_id' => $rows->khu_vuc_id,
                'ten_khu_vuc' => $rows->khuVuc->ten,
                'ten' => $rows->ten,
                'image' => $rows->image,
                'mo_ta' => $rows->mo_ta,
                'tien_ich' => $rows->tien_ich,
                'vi_tri' => $rows->vi_tri,
                'luot_xem' => $rows->luot_xem,
                'noi_bat' => $rows->noi_bat,
                'phong_tro' => $rows->phongTro,
            ];
        });
        return response()->json($result->first(),200);
    }

    public function listName()
    {
        // Lấy tất cả các tòa nhà cùng với số lượng phòng
        $list = ToaNha::select('id', 'ten', 'slug')
            ->withCount('phongTro as so_luong_phong')
            ->get();
    
        // Kiểm tra xem có dữ liệu hay không
        if ($list->isEmpty()) {
            return response()->json(['message' => 'Không có dữ liệu'], 404);
        }
    
        $result = $list->map(function ($rows) {
            return [
                'id' => $rows->id,
                'slug' => $rows->slug,
                'name' => $rows->ten,
                'count_rooms' => $rows->so_luong_phong,
            ];
        });
    
        return response()->json($result);
    }

    public function listHot()
    {
        // Truy vấn
        $toaNhas = ToaNha::where('noi_bat', 1)
            ->withCount(['phongTro as so_luong_phong' => function ($query) {
                $query->where('trang_thai', 1); // Đếm số lượng phòng có trạng thái = 1
            }])
            ->with('khuVuc')
            ->get();

        // Kiểm tra nếu không có dữ liệu
        if ($toaNhas->isEmpty()) {
            return response()->json([
                'message' => 'Danh sách trống'
            ], 404);
        }

        // Chuyển đổi dữ liệu để trả JSON
        $result = $toaNhas->map(function ($toaNha) {
            return [
                'id' => $toaNha->id,
                'slug' => $toaNha->slug,
                'name' => $toaNha->ten,
                'image' => Str::before($toaNha->image, ';'),
                'gia_thue' => $toaNha->gia_thue,
                'count_rooms' => $toaNha->so_luong_phong,
                'name_area' =>$toaNha->khuVuc->ten,
            ];
        });
        
        // Trả JSON
        return response()->json([
            'data' => $result,
        ]);
    }

    public function listView()
    {
        // Truy vấn
        $toaNhas = ToaNha::orderBy('luot_xem','DESC')->limit(12)
            ->withCount(['phongTro as so_luong_phong' => function ($query) {
                $query->where('trang_thai', 1); // Đếm số lượng phòng có trạng thái = 1
            }])
            ->with('khuVuc')
            ->get();

        // Kiểm tra nếu không có dữ liệu
        if ($toaNhas->isEmpty()) {
            return response()->json([
                'message' => 'Danh sách trống'
            ], 404);
        }

        // Chuyển đổi dữ liệu để trả JSON
        $result = $toaNhas->map(function ($toaNha) {
            return [
                'id' => $toaNha->id,
                'slug' => $toaNha->slug,
                'name' => $toaNha->ten,
                'image' => Str::before($toaNha->image, ';'),
                'luot_xem' => $toaNha->luot_xem,
                'gia_thue' => $toaNha->gia_thue,
                'count_rooms' => $toaNha->so_luong_phong,
                'name_area' =>$toaNha->khuVuc->ten,
            ];
        });
        
        // Trả JSON
        return response()->json([
            'data' => $result,
        ]);
    }

    public function listCheap()
    {
        // Truy vấn
        $toaNhas = ToaNha::orderBy('gia_thue','ASC')->limit(12)
            ->withCount(['phongTro as so_luong_phong' => function ($query) {
                $query->where('trang_thai', 1); // Đếm số lượng phòng có trạng thái = 1
            }])
            ->with('khuVuc')
            ->get();

        // Kiểm tra nếu không có dữ liệu
        if ($toaNhas->isEmpty()) {
            return response()->json([
                'message' => 'Danh sách trống'
            ], 404);
        }

        // Chuyển đổi dữ liệu để trả JSON
        $result = $toaNhas->map(function ($toaNha) {
            return [
                'id' => $toaNha->id,
                'slug' => $toaNha->slug,
                'name' => $toaNha->ten,
                'image' => Str::before($toaNha->image, ';'),
                'gia_thue' => $toaNha->gia_thue,
                'count_rooms' => $toaNha->so_luong_phong,
                'name_area' =>$toaNha->khuVuc->ten,
            ];
        });
        
        // Trả JSON
        return response()->json([
            'data' => $result,
        ]);
    }

    public function filter(Request $request)
    {
        $query = ToaNha::query();
    
        // Lọc theo keyword
        if ($request->has('keyword') && !empty($request->input(key: 'keyword'))) {
            $keyword = str_replace('+',' ',$request->input('keyword'));
            $query->where('mo_ta', 'LIKE', "%$keyword%")
                  ->orWhere('vi_tri', 'LIKE', "%$keyword%")
                  ->orWhere('tien_ich', 'LIKE', "%$keyword%");
        }
    
        // Lọc theo area
        if ($request->has('area') && !empty($request->input('area'))) {
            $slug = $request->input('area');
            $query->whereHas('khuVuc', function($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }
    
        // Lọc theo price
        if ($request->has('price') && !empty($request->input('price'))) {
            $priceInput = $request->input('price');
            
            // Kiểm tra định dạng {int}to{int}
            if (!preg_match('/^\d+to\d+$/', $priceInput)) {
                return response()->json(['message' => 'Định dạng giá không hợp lệ. Vui lòng sử dụng {int}to{int}.'], 400);
            }
    
            $array_price = explode('to', $priceInput);
            $query->where('gia_thue', '>=', (int)$array_price[0])
                  ->where('gia_thue', '<=', (int)$array_price[1]);
        }
    
        // Lọc theo size
        if ($request->has('size') && !empty($request->input(key: 'size'))) {
            $sizeInput = $request->input('size');
            // Kiểm tra định dạng {int}to{int}
            if (!preg_match('/^\d+to\d+$/', $sizeInput)) {
                return response()->json(['message' => 'Định dạng diện tích không hợp lệ. Vui lòng sử dụng {int}to{int}.'], 400);
            }

            $array_size = explode('to', $request->input('size'));
            $query->where('dien_tich', '>=', $array_size[0])
                  ->where('dien_tich', '<=', $array_size[1]);
        }
    
        // Lấy kết quả
        $toaNhas = $query->withCount('phongTro as so_luong_phong')->with('khuVuc')->get();
    
        // Kiểm tra nếu không có dữ liệu
        if ($toaNhas->isEmpty()) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu.'], 404);
        }
    
        // Chuyển đổi kết quả
        $result = $toaNhas->map(function ($toaNha) {
            // Chuyển đổi "tien_ich" thành mảng
            $array_tien_ich = explode(';', $toaNha->tien_ich);
            $result_tien_ich = [];
            foreach ($array_tien_ich as $key => $value) {
                $result_tien_ich["tien_ich_" . ($key + 1)] = trim($value);
            }
    
            // Chuyển đổi "vi_tri" thành mảng
            $array_vi_tri = explode(';', $toaNha->vi_tri);
            $result_vi_tri = [];
            foreach ($array_vi_tri as $key => $value) {
                $result_vi_tri["vi_tri_" . ($key + 1)] = trim($value);
            }
    
            return [
                'id' => $toaNha->id,
                'name_area' => $toaNha->khuVuc->ten,
                'slug_area' => $toaNha->khuVuc->slug,
                'size' => $toaNha->dien_tich,
                'name' => $toaNha->ten,
                'slug' => $toaNha->slug,
                'image' => Str::before($toaNha->image, ';'),
                'luot_xem' => $toaNha->luot_xem,
                'gia_thue' => $toaNha->gia_thue,
                'mo_ta' => $toaNha->mo_ta,
                'tien_ich' => $result_tien_ich,
                'vi_tri' => $result_vi_tri,
                'count_rooms' => $toaNha->so_luong_phong,
            ];
        });
    
        return response()->json($result);
    }

    public function all()
    {
        // Lấy tất cả khu vực
        $list = ToaNha::get();
    
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
                'image' => Str::before($rows->image, ';'),
                'view' => $rows->luot_xem,
                'price' => $rows->gia_thue,
                'name_area' =>$rows->khuVuc->ten,
            ];
        });
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($result, 200);
    }

    public function one($id)
    {
        $one = ToaNha::find($id);
        if (!$one) return response()->json(['message' => 'Tòa nhà không tồn tại'], 404);
        $result = [
                'id' => $one->id,
                'slug' => $one->slug,
                'name' => $one->ten,
                'image' => Str::before($one->image, ';'),
                'view' => $one->luot_xem,
                'price' => $one->gia_thue,
                'name_area' =>$one->khuVuc->ten,
            ];
        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
    //     $request->validate([
    //         'id_area' => 'unique:khu_vuc,id',
    //         'name' => 'required|max:255',
    //         'image' => 'nullable|mimes:jpeg,png,jpg,gif|max:2048',
    //         'price' => 'required',
    //         'size' => 'required',
    //         'description' => 'required',
    //         'utilities' => 'required',
    //         'location' => 'required',
    //     ],[
    //         'id_area.unique' => 'ID không tồn tại',
    //         'name.required' => 'Vui lòng nhập tên',
    //         'image.mimes' => 'Chưa nhập đúng định dạng ảnh',
    //         'image.max' => 'Ảnh phải dưới 2MB',
    //         'price.required' => 'Vui lòng nhập giá thuê từ...',
    //         'size.required' => 'Vui lòng nhập diện tích',
    //         'description.required' => 'Vui lòng nhập mô tả',
    //         'utilites.required' => 'Vui lòng nhập tiện ích',
    //         'location.required' => 'Vui lòng nhập các vị trí',
    //     ]
    // );  

        //Kiểm tra tên tồn tại hay chưa
        $checkName = ToaNha::where('ten',$request->name)->exists();
        if($checkName) return response()->json(['message' => 'Tên này đã tồn tại'],400);

        // Xử lý upload ảnh
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('area', 'public');
        }

        // Tạo mới khu vực
        $khuVuc = ToaNha::create([
            'khu_vuc_id' => $request->id_area,
            'ten' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'gia_thue' => $request->price,
            'dien_tich' => $request->size,
            'mo_ta' => $request->description,
            'tien_ich' => $request->ultilites,
            'vi_tri' => $request->location,
            'noi_bat' => $request->noi_bat ?? 0,
        ]);

        return response()->json([
            'message' => 'Khu vực đã được thêm thành công',
        ], 201);
    }

    public function edit(Request $request, $id)
    {
        // Xác thực dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'id_area' => 'required|exists:khu_vuc,id',
            'name' => 'required|exists:toa_nha,ten',
            'size' => 'required',
            'location' => 'required',
            'description' => 'required',
            'ultilities' => 'required',
            'price' => 'required',
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
        $tinTuc = ToaNha::first($id);

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

    public function delete($id)
    {
        $khuVuc = ToaNha::find($id);
        if (!$khuVuc) {
            return response()->json(['message' => 'Tòa nhà không tồn tại'], 404);
        }
        $khuVuc->delete();

        return response()->json(['message' => 'Xóa thành công'], 200);
    }

    public function restore($id)
    {
        $khuVuc = ToaNha::withTrashed()->find($id);

        if (!$khuVuc) {
            return response()->json(['message' => 'Tòa nhà không tồn tại'], 404);
        }
        $khuVuc->restore();
        return response()->json(['message' => 'Tòa nhà đã được khôi phục'], 200);
    }

    public function list_delete()
    {
        $trash_toaNha = ToaNha::onlyTrashed()->get();
        if ($trash_toaNha->isEmpty()) {
            return response()->json(['message' => 'Không có tòa nhà nào đã bị xóa'], 404);
        }
        $result = $trash_toaNha->map(function ($rows) {
            return [
                'id' => $rows->id,
                'slug' => $rows->slug,
                'name' => $rows->ten,
                'image' => Str::before($rows->image, ';'),
                'view' => $rows->luot_xem,
                'price' => $rows->gia_thue,
                'name_area' =>$rows->khuVuc->ten,
            ];
        });

        return response()->json($result, 200);
    }

    public function duplicate($id)
    {
        $toaNha = ToaNha::find($id);
        if (!$toaNha) {
            return response()->json(['message' => 'Tòa nhà không tồn tại.'], 404);
        }
    
        // Tạo 1 tiêu đề mới bằng cách nối chuỗi
        $baseTitle = $toaNha->ten . '-copy';
        $newName = $baseTitle;

        // Kiểm tra xem tiêu đề đã tồn tại trong cơ sở dữ liệu chưa
        $counter = 1;
        while (ToaNha::where('  ', $newName)->exists()) {
            $newName = $baseTitle . '-' . $counter; // Tạo tên mới với bộ đếm
            $counter++;
        }
        // Tạo 1 slug mới từ tiêu đề mới
        $newSlug = Str::slug($newName);
    
        // Tạo tên file mới cho ảnh
        $oldImagePath = $toaNha->image; // Đường dẫn ảnh cũ
        $imageExtension = pathinfo($oldImagePath, PATHINFO_EXTENSION);
        $newImageName = pathinfo($oldImagePath, PATHINFO_FILENAME) . '-' . uniqid() . '.' . $imageExtension;
        $newImagePath = 'building/' . $newImageName; // Đường dẫn ảnh mới trong thư mục blog
    
        // Sao chép file ảnh
        if (Storage::disk('public')->exists($oldImagePath)) {
            // Sao chép file từ đường dẫn cũ sang đường dẫn mới
            Storage::disk('public')->copy($oldImagePath, $newImagePath);
        } else {
            return response()->json(['message' => 'File ảnh cũ không tồn tại.'], 404);
        }
    
        // Lưu vào database 
        $newtoaNha = ToaNha::create([
            'ten' => $newName,
            'slug' => $newSlug,
            'image' => $newImagePath,
        ]);
    
        return response()->json([
            'message' => 'Nhân bản thành công khu vực với ID = '.$id,
        ], 200);
    }
}
