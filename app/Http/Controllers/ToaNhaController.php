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
                'image' => Str::before('$toaNha->image', ';'),
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
}