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
        $user = Auth::user();

        $thanhToan = ThanhToan::with('hopDong', 'maUuDai')
            ->where('id', $id_hop_dong)
            ->first();

        if (!$thanhToan) {
            return response()->json([
                'message' => 'Thanh toán không tồn tại.'
            ], 404);
        }

        if ($thanhToan->hopDong->tai_khoan_id !== $user->id) {
            return response()->json([
                'message' => 'Bạn không có quyền xem thông tin thanh toán này.'
            ], 403);
        }

        return response()->json($thanhToan);
    }
}
