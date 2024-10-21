<?php
namespace App\Http\Controllers;

use App\Models\ToaNha;
use App\Models\Phong;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class ToaNhaController extends Controller
{
    public function showByID(Request $request)
    {
        $result = ToaNha::with('phongTro')->find($request->id);

        if (!$result) {
            return response()->json(['message' => 'content not found'], 404);
        }

        return response()->json($result);
    }

    public function detail($slug)
    {
        $result = ToaNha::with('phongTro')->where('slug', $slug)->first();

        if (!$result) {
            return response()->json(['message' => 'content not found'], 404);
        }

        return response()->json($result);
    }

    public function listName()
    {
        // Lấy tất cả các tòa nhà cùng với số lượng phòng
        $result = ToaNha::select('id', 'ten', 'slug')
            ->withCount('phongTro')
            ->get();
    
        // Kiểm tra xem có dữ liệu hay không
        if ($result->isEmpty()) {
            return response()->json(['message' => 'Không có dữ l'], 404);
        }
    
        // Đổi tên trường `phong_tro_count` thành `quantity_room`
        $result->transform(function ($item) {
            $item->quantity_room = $item->phong_tro_count;
            unset($item->phong_tro_count); // Xóa trường `phong_tro_count` gốc
            return $item;
        });
    
        return response()->json($result);
    }
}