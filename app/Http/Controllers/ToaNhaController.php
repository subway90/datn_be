<?php
namespace App\Http\Controllers;

use App\Models\ToaNha;
use App\Models\Phong;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Str;

class ToaNhaController extends Controller
{
    public function detail(Request $request)
    {
        $result = ToaNha::with('phongTro')->where('slug', $request->slug)->first();

        if (!$result) {
            return response()->json(['message' => 'Tòa nhà không tồn tại'], 404);
        }

        return response()->json($result);
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
        if ($request->has('keyword')) {
            $keyword = $request->input('keyword');
            $query->where('mo_ta', 'LIKE', "%$keyword%")
                  ->orWhere('vi_tri', 'LIKE', "%$keyword%")
                  ->orWhere('tien_ich', 'LIKE', "%$keyword%");
        }
    
        // Lọc theo area
        if ($request->has('area')) {
            $slug = $request->input('area');
            $query->whereHas('khuVuc', function($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }
    
        // Lọc theo price
        if ($request->has('price')) {
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
        if ($request->has('size')) {
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
}
