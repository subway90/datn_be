<?php

namespace App\Http\Controllers;

use App\Models\Phong;
use App\Models\ToaNha;
use App\Models\KhuVuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PhongController extends Controller
{
    public function index($id)
    {
        // Lấy danh sách phòng theo id_toa_nha
        $room = Phong::find($id);

        if (!$room) {
            return response()->json(['message' => 'Không tìm thấy phòng'], 404);
        }
        $toa_nha = ToaNha::where('id',$room->toa_nha_id)->first(['slug','ten','khu_vuc_id']);
        $khu_vuc = khuVuc::where('id',$toa_nha->khu_vuc_id)->first(['slug','ten']);
        $result = [
            'id' => $room->id,
            'ten_phong' => $room->ten_phong,
            'ten_toa_nha' => $toa_nha->ten,
            'slug_toa_nha' => $toa_nha->slug,
            'ten_khu_vuc' => $khu_vuc->ten,
            'slug_khu_vuc' => $khu_vuc->slug,
            'hinh_anh' => $room->hinh_anh,
            'dien_tich' => $room->dien_tich,
            'gac_lung' => $room->gac_lung ? 'Có' : ' Không',
            'gia_thue' => $room->gia_thue,
            'don_gia_dien' => $room->don_gia_dien,
            'don_gia_nuoc' => $room->don_gia_nuoc,
            'tien_xe_may' => $room->tien_xe_may,
            'phi_dich_vu' => $room->phi_dich_vu,
            'tien_ich' => $room->tien_ich,
            'noi_that' => $room->noi_that,
        ];

        // Trả về phản hồi JSON
        return response()->json($result);
    }

    public function getAll()
    {
        // Lấy tất cả danh sách phòng
        $list_room = Phong::orderBy('created_at','DESC')->get();

        if($list_room->isEmpty()) return response()->json(['message' => 'Danh sách phòng trống'], 404);

        //Chuyển đổi kết quả
        $result = $list_room->map(function ($room) {
            $toa_nha = ToaNha::where('id',$room->toa_nha_id)->first(['slug','ten','khu_vuc_id']);
            $khu_vuc = khuVuc::where('id',$toa_nha->khu_vuc_id)->first(['slug','ten']);
            return [
                'id' => $room->id,
                'ten_phong' => $room->ten_phong,
                'ten_toa_nha' => $toa_nha->ten,
                'slug_toa_nha' => $toa_nha->slug,
                'ten_khu_vuc' => $khu_vuc->ten,
                'slug_khu_vuc' => $khu_vuc->slug,
                'hinh_anh' => Str::before($room->hinh_anh,';'),
                'dien_tich' => $room->dien_tich,
                'gac_lung' => $room->gac_lung ? 'Có' : ' Không',
                'gia_thue' => $room->gia_thue,
                'don_gia_dien' => $room->don_gia_dien,
                'don_gia_nuoc' => $room->don_gia_nuoc,
                'tien_xe_may' => $room->tien_xe_may,
                'phi_dich_vu' => $room->phi_dich_vu,
                'tien_ich' => $room->tien_ich,
                'noi_that' => $room->noi_that,
            ];
        });
    
        return response()->json(['list_room' => $result],200);
    }

    public function filter(Request $request)
    {
        $query = Phong::query();
        
        // Lọc theo gác lửng
        if ($request->has('mezzanine') && !empty($request->input(key: 'mezzanine'))) {
            if($request->mezzanine === 'true') $query->where('gac_lung', true);
            else $query->where('gac_lung', false);
        }


        // Lọc theo keyword
        if ($request->has('keyword') && !empty($request->input(key: 'keyword'))) {
            $keyword = str_replace('+',' ',$request->input('keyword'));
            $query->where('tien_ich', 'LIKE', "%$keyword%")
                  ->orWhere('noi_that', 'LIKE', "%$keyword%")
                  ->orWhereHas('toaNha', function($subQuery) use ($keyword) {
                    $subQuery->where('ten', 'LIKE', "%$keyword%")->orWhere('mo_ta', 'LIKE', "%$keyword%")->orWhere('vi_tri', 'LIKE', "%$keyword%");
                  });
        }    

        // Lọc theo area
        if ($request->has('area') && !empty($request->input('area'))) {
            $slug = $request->input('area');
            $query->whereHas('toaNha.khuVuc', function($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }
    
        // Lọc theo building
        if ($request->has('building') && !empty($request->input('building'))) {
            $slug = $request->input('building');
            $query->whereHas('toaNha', function($q) use ($slug) {
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
        $list_room = $query->where('trang_thai',1)->get();
    
        // Kiểm tra nếu không có dữ liệu
        if ($list_room->isEmpty()) {
            return response()->json(['message' => 'Không tìm thấy dữ liệu.'], 404);
        }
    
        //Chuyển đổi kết quả
        $result = $list_room->map(function ($room) {
            $toa_nha = ToaNha::where('id',$room->toa_nha_id)->first(['slug','ten','khu_vuc_id']);
            $khu_vuc = khuVuc::where('id',$toa_nha->khu_vuc_id)->first(['slug','ten']);
            return [
                'id' => $room->id,
                'ten_phong' => $room->ten_phong,
                'ten_toa_nha' => $toa_nha->ten,
                'slug_toa_nha' => $toa_nha->slug,
                'ten_khu_vuc' => $khu_vuc->ten,
                'slug_khu_vuc' => $khu_vuc->slug,
                'hinh_anh' => $room->hinh_anh,
                'dien_tich' => $room->dien_tich,
                'gac_lung' => $room->gac_lung ? 'Có' : ' Không',
                'gia_thue' => $room->gia_thue,
                'don_gia_dien' => $room->don_gia_dien,
                'don_gia_nuoc' => $room->don_gia_nuoc,
                'tien_xe_may' => $room->tien_xe_may,
                'phi_dich_vu' => $room->phi_dich_vu,
                'tien_ich' => $room->tien_ich,
                'noi_that' => $room->noi_that,
            ];
        });
    
        return response()->json(['list_room' => $result],200);
    }

    public function delete($id)
    {
        $get = Phong::find($id);
        if (!$get) {
            return response()->json(['message' => 'Phòng không tồn tại'], 404);
        }
        $get->delete();

        return response()->json(['message' => 'Xóa thành công'], 200);
    }

    public function list_delete()
    {
        // Lấy tất cả danh sách phòng
        $list_room = Phong::onlyTrashed()->get();

        if($list_room->isEmpty()) return response()->json(['message' => 'Danh sách phòng trống'], 404);
        //Chuyển đổi kết quả
        $result = $list_room->map(function ($room) {
            $toa_nha = ToaNha::where('id',$room->toa_nha_id)->first(['slug','ten','khu_vuc_id']);
            $khu_vuc = khuVuc::where('id',$toa_nha->khu_vuc_id)->first(['slug','ten']);
            return [
                'id' => $room->id,
                'ten_phong' => $room->ten_phong,
                'ten_toa_nha' => $toa_nha->ten,
                'slug_toa_nha' => $toa_nha->slug,
                'ten_khu_vuc' => $khu_vuc->ten,
                'slug_khu_vuc' => $khu_vuc->slug,
                'hinh_anh' => Str::before($room->hinh_anh,';'),
                'dien_tich' => $room->dien_tich,
                'gac_lung' => $room->gac_lung ? 'Có' : ' Không',
                'gia_thue' => $room->gia_thue,
                'don_gia_dien' => $room->don_gia_dien,
                'don_gia_nuoc' => $room->don_gia_nuoc,
                'tien_xe_may' => $room->tien_xe_may,
                'phi_dich_vu' => $room->phi_dich_vu,
                'tien_ich' => $room->tien_ich,
                'noi_that' => $room->noi_that,
            ];
        });
    
        return response()->json(['list_room' => $result],200);
    }

    public function restore($id)
    {
        $get = Phong::onlyTrashed()->find($id);

        if (!$get) return response()->json(['message' => 'Phòng không tồn tại trong danh sách xóa'], 404);
        
        //Kiểm tra xem tên đã tồn tại chưa
        $check_name = Phong::where('name',$get->name)->exists();
        if($check_name) return response()->json(['message' => 'Tên phòng "'.$get->name.'" đã tồn tại, không thể khôi phục thêm'], 400);

        // Khôi phục
        $get->restore();
        return response()->json(['message' => 'Phòng đã được khôi phục'], 200);
    }

    public function store(Request $request)
    {
        # Kiểm tra validate
        $validator = Validator::make($request->all(),[
            'id_building' => 'required|exists:toa_nha,id',
            'name' => 'required|unique:phong,ten_phong',
            'images' => 'required|array',
            'images.*' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'dien_tich' => 'required|integer',
            'gac_lung' => 'required|boolean',
            'tien_thue' => 'nullable|integer',
            'tien_dien' => 'nullable|integer',
            'tien_nuoc' => 'nullable|integer',
            'tien_xe' => 'nullable|integer',
            'tien_dich_vu' => 'nullable|integer',
            'noi_that' => 'nullable',
            'tien_ich' => 'nullable',

        ],[
            'id_building.required' => 'Chưa nhập ID tòa nhà',
            'id_building.exists' => 'ID tòa nhà không tồn tại',
            'name.required' => 'Vui lòng nhập tên phòng',
            'name.unique' => 'Tên phòng đã tồn tại',
            'images.required' => 'Bạn chưa tải ảnh lên',
            'images.array' => 'Ảnh phải là một mảng ( images[] )',
            'images.*.mimes' => 'Chưa nhập đúng định dạng ảnh',
            'images.*.max' => 'Ảnh phải dưới 2MB',
            'dien_tich.required' => 'Vui lòng nhập diện tích',
            'dien_tich.integer' => 'Diện tích phải là một số nguyên',
            'gac_lung.required' => 'Vui lòng nhập gác lửng',
            'gac_lung.boolean' => 'Gác lửng là 1 giá trị boolean (0 : không có, 1: có gác lửng)',
            'tien_thue.integer' => 'Giá thuê phải là một số nguyên',
            'tien_dien.integer' => 'Giá tiền điện phải là một số nguyên',
            'tien_nuoc.integer' => 'Giá tiền nước phải là một số nguyên',
            'tien_xe.integer' => 'Giá tiền xe phải là một số nguyên',
            'tien_dich_vu.integer' => 'Giá tiền dịch vụ phải là một số nguyên',
        ]); 
        # Trả về message validate 
        if ($validator->fails()) return response()->json(['message' => $validator->errors()->all()], 400);

        // Xử lý upload ảnh
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                // Mã hóa tên ảnh
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                $imagePath = $image->storeAs('room', $filename, 'public');
                $imagePaths[] = $imagePath; // Lưu đường dẫn ảnh vào mảng
            }
        }

        // Chuyển đổi mảng đường dẫn thành chuỗi và ngăn cách bằng dấu ';'
        $imagesString = implode(';', $imagePaths);

        // Tạo mới khu vực
        $khuVuc = Phong::create([
            'toa_nha_id' => $request->id_building,
            'ten_phong' => $request->name,
            'slug' => Str::slug($request->name),
            'hinh_anh' => $imagesString,
            'dien_tich' => $request->dien_tich,
            'gac_lung' => $request->gac_lung,
            'gia_thue' => $request->tien_thue,
            'don_gia_dien' => $request->tien_dien ?? 0,
            'don_gia_nuoc' => $request->tien_nuoc ?? 0,
            'tien_xe_may' => $request->tien_xe ?? 0,
            'phi_dich_vu' => $request->tien_dich_vu ?? 0,
            'tien_ich' => trim($request->tien_ich,';'),
            'noi_that' => trim($request->noi_that,';'),
        ]);

        return response()->json([
            'message' => 'Phòng đã được thêm thành công',
        ], 201);
    }

    public function edit(Request $request,$id)
    {
        // Tìm tòa nhà theo ID
        $phong = Phong::find($id);
        if (!$phong) return response()->json(['message' => 'ID tòa nhà không tồn tại'], 400);
    
        // Kiểm tra validate
        $validator = Validator::make($request->all(),[
            'id_building' => 'required|exists:toa_nha,id',
            'name' => 'required|unique:phong,ten_phong,'.$id,
            'images' => 'nullable|array',
            'images.*' => 'mimes:jpeg,png,jpg,gif|max:2048',
            'image_delte' => 'nullable',
            'dien_tich' => 'required|integer',
            'gac_lung' => 'required|boolean',
            'tien_thue' => 'nullable|integer',
            'tien_dien' => 'nullable|integer',
            'tien_nuoc' => 'nullable|integer',
            'tien_xe' => 'nullable|integer',
            'tien_dich_vu' => 'nullable|integer',
            'noi_that' => 'nullable',
            'tien_ich' => 'nullable',
        ],[
            'id_building.required' => 'Chưa nhập ID tòa nhà',
            'id_building.exists' => 'ID tòa nhà không tồn tại',
            'name.required' => 'Vui lòng nhập tên phòng',
            'name.unique' => 'Tên phòng đã tồn tại',
            'images.array' => 'Ảnh phải là một mảng ( images[] )',
            'images.*.mimes' => 'Chưa nhập đúng định dạng ảnh',
            'images.*.max' => 'Ảnh phải dưới 2MB',
            'dien_tich.required' => 'Vui lòng nhập diện tích',
            'dien_tich.integer' => 'Diện tích phải là một số nguyên',
            'gac_lung.required' => 'Vui lòng nhập gác lửng',
            'gac_lung.boolean' => 'Gác lửng là 1 giá trị boolean (0 : không có, 1: có gác lửng)',
            'tien_thue.integer' => 'Giá thuê phải là một số nguyên',
            'tien_dien.integer' => 'Giá tiền điện phải là một số nguyên',
            'tien_nuoc.integer' => 'Giá tiền nước phải là một số nguyên',
            'tien_xe.integer' => 'Giá tiền xe phải là một số nguyên',
            'tien_dich_vu.integer' => 'Giá tiền dịch vụ phải là một số nguyên',
        ]); 
    
        // Trả về message validate
        if ($validator->fails()) return response()->json(['message' => $validator->errors()->all()], 400);
    
        // tạo mảng ảnh hiện tại
        $currentImages = explode(';', $phong->image);
    
        // Xử lý upload ảnh mới
        $newImagePaths = [];
        $newImage = $request->image;
        if($newImage) {
            foreach ($newImage as $image) {
                // đổi tên file ảnh, hàm getClientOriginalExtesion là lấy tên đuôi file (image/png thì lấy png)
                $filename = uniqid() . '.' . $image->getClientOriginalExtension();
                // lưu vào storage
                $imagePath = $image->storeAs('room', $filename, 'public');
                // lưu đường dẫn file
                $newImagePaths[] = $imagePath;
            }
        }
    
        // tạo mảng cho ảnh cần xóa
        $delete_image = explode(';', trim($request->input('image_delete'),';'));
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
        $phong->update([
            'toa_nha_id' => $request->id_building,
            'ten_phong' => $request->name,
            'slug' => Str::slug($request->name),
            'hinh_anh' => $imagePath,
            'dien_tich' => $request->dien_tich,
            'gac_lung' => $request->gac_lung,
            'gia_thue' => $request->tien_thue,
            'don_gia_dien' => $request->tien_dien ?? 0,
            'don_gia_nuoc' => $request->tien_nuoc ?? 0,
            'tien_xe_may' => $request->tien_xe ?? 0,
            'phi_dich_vu' => $request->tien_dich_vu ?? 0,
            'tien_ich' => trim($request->tien_ich,';'),
            'noi_that' => trim($request->noi_that,';'),
        ]);

        return response()->json(['message' => 'Tòa nhà đã được cập nhật thành công','result' => $phong], 200);
    }

}