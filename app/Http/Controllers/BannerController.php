<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
class BannerController extends Controller
{
    public function all()
    {
        // Lấy tất cả banner
        $list = Banner::all();
    
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
                'created_at' => $row->created_at,
                'updated_at' => $row->updated_at,
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
    
}
