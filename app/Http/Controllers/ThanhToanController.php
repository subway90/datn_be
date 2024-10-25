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

        $thanhToans = ThanhToan::with('hopDong')
            ->where('hop_dong_id', $id_hop_dong)
            ->get();

        if ($thanhToans->isEmpty()) {
            return response()->json([
                'message' => 'Không có thanh toán nào tồn tại cho hợp đồng này.'
            ], 404);
        }

        $hopDong = $thanhToans->first()->hopDong;

        if ($hopDong->tai_khoan_id !== $user->id) {
            return response()->json([
                'message' => 'Bạn không có quyền xem thông tin thanh toán này.'
            ], 403);
        }

        return response()->json($thanhToans);
    }
}
