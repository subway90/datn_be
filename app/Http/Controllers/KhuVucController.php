<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KhuVuc;

class KhuVucController extends Controller
{
    public function listHot()
    {
        // Lấy tất cả khu vực
        $list = KhuVuc::where('noi_bat', 1)
            ->orderBy('thu_tu', 'ASC')
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
                'image' => $rows->image,
                'created_at' => $rows->created_at,
                'updated_at' => $rows->updated_at,
            ];
        });
    
        // Trả về dữ liệu dưới dạng JSON
        return response()->json($result, 200);
    }
}
