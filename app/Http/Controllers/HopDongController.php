<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HopDongModel;

class HopDongController extends Controller
{
    public function getHopDong($id_user)
    {
        $hopDong = HopDongModel::with('user')
            ->where('id_tai_khoan', $id_user)
            ->get();

        if ($hopDong->isEmpty()) {
            return response()->json([
                'message' => 'Không tìm thấy hợp đồng cho người dùng này.'
            ], 404);
        }

        return response()->json($hopDong, 200);
    }
}
