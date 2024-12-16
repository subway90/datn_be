<?php
namespace App\Http\Controllers;

use App\Models\ToaNha;
use App\Models\Phong;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\BinhLuanToaNha;
use App\Models\KhuVuc;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ToaNhaController extends Controller
{
    public function detail(Request $request)
    {
        $detail = ToaNha::with('phongTro')
        ->with('khuVuc')
        ->where('slug', $request->slug)->first();

       

        if (!$detail) return response()->json(['message' => 'Tòa nhà không tồn tại'], 404);

         // Kiểm tra trạng thái khu vực 
         $check_building = KhuVuc::withTrashed()->where('id',$detail->khu_vuc_id)->exists();
         if(!$check_building) return response()->json(['message' => 'Khu vực của tòa nhà này đã bị ẩn'], 404);

        // lấy danh sách bình luận
        $result = $detail->map(function ($rows) {
            $list_cmt = BinhLuanToaNha::where('toa_nha_id', $rows->id)->with('user')->get();
            $result_list_cmt = $list_cmt->map(function ($cmt) {
                return [
                    'id_user' => $cmt->user->id,
                    'name' => $cmt->user->name,
                    'avatar' => $cmt->user->avatar ?? 'avatar/user_default.png',
                    'content' => $cmt->noi_dung,
                    'date' => $cmt->created_at->format('d').' Thg '.$cmt->created_at->format('m').' lúc '.$cmt->created_at->format('H').':'.$cmt->created_at->format('i'),
                ];
            });
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
                'list_cmt' => $result_list_cmt,
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

    
    public function option()
    {
        // Truy vấn
        $list = ToaNha::select('toa_nha.id', 'toa_nha.ten', 'khu_vuc.ten as ten_khu_vuc')
        ->join('khu_vuc', 'toa_nha.khu_vuc_id', '=', 'khu_vuc.id')
        ->get();

        // Chuyển đổi dữ liệu để trả JSON
        $result = $list->map(function ($toaNha) {
            return [
                'id' => $toaNha->id,
                'name' => $toaNha->ten.' - '.$toaNha->ten_khu_vuc,
            ];
        });
        
        // Trả JSON
        return response()->json($result,200);
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
        $toaNhas = ToaNha::orderBy('created_at','DESC')->limit(12)
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
        $list = ToaNha::withCount('phongTro as count_room')->with(['khuVuc' => function($query) {
                $query->withTrashed(); // Lấy cả các bản ghi đã bị xóa mềm
            }])
            ->orderBy('id', 'DESC')
            ->get();
    
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
                'description' => $rows->mo_ta,
                'name_area' =>$rows->khuVuc->ten,
                'hot' => $rows->noi_bat,
                'room' => $rows->count_room,
            ];
        });
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($result, 200);
    }

    public function one($id)
    {
        $one = ToaNha::where('id',$id)->with(['khuVuc' => function($query) {
                $query->withTrashed(); // Lấy cả các bản ghi đã bị xóa mềm
            }])->first();
        if (!$one) return response()->json(['message' => 'Tòa nhà không tồn tại'], 404);
        $result = [
                'id' => $one->id,
                'slug' => $one->slug,
                'name' => $one->ten,
                'image' =>$one->image,
                'description' => $one->mo_ta,
                'location' => $one->vi_tri,
                'utilities' => $one->tien_ich,
                'view' => $one->luot_xem,
                'hot' => $one->noi_bat,
                'id_area' => $one->khu_vuc_id,
                'name_area' =>$one->khuVuc->ten,
            ];
        return response()->json($result, 200);
    }

    public function store(Request $request)
    {
        # Kiểm tra validate
        $validator = Validator::make($request->all(),[
            'id_area' => 'required|exists:khu_vuc,id',
            'name' => 'required|unique:toa_nha,ten',
            'images' => 'required|array',
            'images.*' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
            'utilities' => 'required',
            'location' => 'required',
        ],[
            'id_area.required' => 'Chưa nhập khu vực',
            'id_area.exists' => 'Khu vực không tồn tại',
            'name.required' => 'Chưa nhập tên tòa nhà',
            'name.unique' => 'Tên tòa nhà đã tồn tại',
            'images.required' => 'Bạn chưa tải ảnh lên',
            'images.array' => 'Ảnh phải là một mảng ( images[] )',
            'images.*.mimes' => 'Chưa nhập đúng định dạng ảnh',
            'images.*.max' => 'Ảnh phải dưới 2MB',
            'description.required' => 'Vui lòng nhập mô tả',
            'utilities.required' => 'Vui lòng nhập tiện ích',
            'location.required' => 'Vui lòng nhập các vị trí',
        ]); 
        # Trả về message validate 
        if ($validator->fails()) return response()->json(['message' => $validator->errors()->first()], 400);

        // Xử lý upload ảnh
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Mã hóa tên ảnh
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('building', $filename, 'public');
                $imagePaths[] = $imagePath; // Lưu đường dẫn ảnh vào mảng
            }
        }

        // Chuyển đổi mảng đường dẫn thành chuỗi và ngăn cách bằng dấu ';'
        $imagesString = implode(';', $imagePaths);

        // Tạo mới khu vực
        $khuVuc = ToaNha::create([
            'khu_vuc_id' => $request->id_area,
            'ten' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagesString,
            'gia_thue' => $request->price,
            'dien_tich' => $request->size,
            'mo_ta' => $request->description,
            'tien_ich' => $request->utilities,
            'vi_tri' => $request->location,
            'noi_bat' => $request->noi_bat ?? 0,
        ]);

        return response()->json([
            'message' => 'Khu vực đã được thêm thành công',
        ], 201);
    }

    public function edit(Request $request,$id)
    {
        // Tìm tòa nhà theo ID
        $toa_nha = ToaNha::find($id);
        if (!$toa_nha) return response()->json(['message' => 'ID tòa nhà không tồn tại'], 404);
    
        // Kiểm tra validate
        $validator = Validator::make($request->all(), [
            'id_area' => 'required|exists:khu_vuc,id',
            'name' => 'required|unique:toa_nha,ten,' . $id,
            'image' => 'nullable|array',
            'image.*' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'description' => 'required',
            'utilities' => 'required',
            'location' => 'required',
            'image_delete' => 'nullable|string',
        ], [
            'id_area.required' => 'Chưa nhập khu vực',
            'id_area.exists' => 'Khu vực không tồn tại',
            'name.required' => 'Vui lòng nhập tên',
            'name.unique' => 'Tên tòa nhà đã tồn tại',
            'image.array' => 'Ảnh phải là một mảng (image[]).',
            'image.*.mimes' => 'Chưa nhập đúng định dạng ảnh',
            'image.*.max' => 'Ảnh phải dưới 2MB',
            'description.required' => 'Vui lòng nhập mô tả',
            'utilities.required' => 'Vui lòng nhập tiện ích',
            'location.required' => 'Vui lòng nhập các vị trí',
            'image_delete.string' => 'Path ảnh cũ phải là 1 chuỗi',
        ]);
    
        // Trả về message validate
        if ($validator->fails()) return response()->json(['message' => $validator->errors()->all()], 400);
    
        // tạo mảng ảnh hiện tại
        $currentImages = explode(';', $toa_nha->image);
    
        // Xử lý upload ảnh mới
        $newImagePaths = [];
        $newImage = $request->image;
        if($newImage) {
            foreach ($newImage as $image) {
                // đổi tên file ảnh, hàm getClientOriginalExtesion là lấy tên đuôi file (image/png thì lấy png)
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                // lưu vào storage/building
                $imagePath = $image->storeAs('building', $filename, 'public');
                // lưu đường dẫn file
                $newImagePaths[] = $imagePath;
            }
        }
    
        // tạo mảng cho ảnh cần xóa
        $delete_image = explode(';', $request->input('image_delete'));
        $keepImagePaths = [];
        // Giữ lại ảnh cũ nếu có trong danh sách ảnh cũ
        foreach ($currentImages as $image) {
            // Kiểm tra nếu ảnh cũ tồn tại trong ảnh hiện tại
            if (in_array($image, $delete_image)) {
                Storage::disk('public')->delete($image);
            } else {
                // Xóa ảnh không còn sử dụng
                $keepImagePaths[] = $image; // Giữ lại ảnh cũ
            }
        }
    
        // tạo mảng lưu path ảnh để update (lưu path ảnh mới + ảnh cũ giữ lại) và đổi thành chuỗi
        $imagePath = implode(';', array_merge($keepImagePaths, $newImagePaths));
    
        // Cập nhật thông tin tòa nhà
        $toa_nha->update([
            'khu_vuc_id' => $request->id_area,
            'ten' => $request->name,
            'slug' => Str::slug($request->name),
            'image' => $imagePath,
            'mo_ta' => $request->description,
            'tien_ich' => $request->utilities,
            'vi_tri' => $request->location,
        ]);
    
        return response()->json(['message' => 'Tòa nhà đã được cập nhật thành công'], 200);
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
        $khuVuc = ToaNha::onlyTrashed()->find($id);

        if (!$khuVuc) {
            return response()->json(['message' => 'Tòa nhà không tồn tại trong danh sách xóa'], 404);
        }
        $khuVuc->restore();
        return response()->json(['message' => 'Tòa nhà đã được khôi phục'], 200);
    }

    public function list_delete()
    {
        $trash_toaNha = ToaNha::onlyTrashed()->orderBy('deleted_at','DESC')->get();
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
        // Tìm bản ghi theo ID
        $toa_nha = ToaNha::find($id);

        // Kiểm tra xem bản ghi có tồn tại không
        if (!$toa_nha) return response()->json(['message' => 'Tòa nhà này không tồn tại'], 404);

        // Thêm hậu tố copy
        $new_name = $toa_nha->ten . ' copy';

        // Kiểm tra tòa nhà có tồn tại hay chưa
        $check_name = ToaNha::where('ten',$new_name)->exists();
        if($check_name) return response()->json(['message' => 'Tòa nhà này đã được copy rồi !'], 400);

        // Xử lý sao chép ảnh
        $list_image = explode(';', $toa_nha->image);
        $newImagePaths = [];
        foreach ($list_image as $image) {
            // Lấy tên file gốc
            $filename = basename($image);
            // Mã hóa tên file mới
            $newFilename = uniqid() . '.' . pathinfo($filename, PATHINFO_EXTENSION);
            // Sao chép ảnh vào thư mục mới
            Storage::disk('public')->copy($image, 'building/' . $newFilename);
            // Lưu đường dẫn mới vào mảng
            $newImagePaths[] = 'building/' . $newFilename;
        }
    
        // Tạo chuỗi path từ mảng
        $imagesString = implode(';', $newImagePaths);
    
        // Tạo bản sao mới
        $duplicate = ToaNha::create([
            'khu_vuc_id' => $toa_nha->khu_vuc_id,
            'ten' => $new_name,
            'slug' => Str::slug($new_name),
            'image' => $imagesString,
            'mo_ta' => $toa_nha->mo_ta,
            'tien_ich' => $toa_nha->tien_ich,
            'vi_tri' => $toa_nha->vi_tri,
            'noi_bat' => $toa_nha->noi_bat ?? 0,
        ]);
    
        return response()->json(['message' => 'Nhân bản thành công tòa nhà'], 201);
    }

    public function editHot($id) {
        $get = ToaNha::find($id);
        // Check
        if(!$get) return response()->json(['message' => 'Tòa nhà không tồn tại'], 404);
        // Thay đổi trạng thái
        else {
            if($get['noi_bat'] == 0) {
                $get->update([
                    'noi_bat' => 1,
                ]);
            }else {
                {
                    $get->update([
                        'noi_bat' => 0,
                    ]);
                }
            }
        }

        return response()->json(['result' => 'Cập nhật trạng thái hot thành công'], 200);
    }
}
