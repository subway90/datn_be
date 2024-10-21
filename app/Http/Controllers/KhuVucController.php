<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KhuVuc;

class KhuVucController extends Controller
{
    public function getAll()
    {
        // Lấy tất cả khu vực
        $getAll = KhuVuc::orderBy('thu_tu')->get();

        // Trả về dữ liệu dưới dạng JSON
        return response()->json($getAll);
    }
}
