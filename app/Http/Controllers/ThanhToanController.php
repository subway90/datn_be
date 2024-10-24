<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThanhToan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class ThanhToanController extends Controller
{
    public function getThanhToan($id_hop_dong)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Bạn cần đăng nhập để xem thanh toán'
            ], 401);
        }

        $thanhToan = ThanhToan::where('hop_dong_id', $id_hop_dong)->get();

        if ($thanhToan->isEmpty()) {
            return response()->json([
                'message' => 'Không tìm thấy thanh toán cho hợp đồng này.'
            ], 404);
        }

        return response()->json($thanhToan, 200);
    }
}
