<?php

namespace App\Http\Controllers;

use App\Models\Phong;
use Illuminate\Http\Request;

class PhongController extends Controller
{
    public function index($id_toa_nha)
    {
        // Lấy danh sách phòng theo id_toa_nha
        $phongs = Phong::where('id_toa_nha', $id_toa_nha)->get();

        if ($phongs->isEmpty()) {
            return response()->json(['message' => 'Không tìm thấy phòng'], 404);
        }

        // Trả về phản hồi JSON
        return response()->json($phongs);
    }

    public function getAll()
    {
        // Lấy tất cả danh sách phòng
        $phongs = Phong::all();

        // Trả về phản hồi JSON
        return response()->json($phongs);
    }
}