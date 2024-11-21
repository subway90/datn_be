<?php

namespace App\Http\Controllers;

use App\Models\Phong;
use App\Models\ToaNha;
use App\Models\KhuVuc;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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
        $list_room = Phong::all();
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

}