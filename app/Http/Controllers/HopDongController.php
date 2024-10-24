<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HopDong;
use Illuminate\Support\Facades\Auth;

class HopDongController extends Controller
{
    public function getHopDong($id_user)
    {
        if (!Auth::check()) {
            return response()->json([
                'message' => 'Bạn cần đăng nhập để xem hợp đồng.'
            ], 401);
        }

        $hopDong = HopDong::with('user')
            ->where('tai_khoan_id', $id_user)
            ->get();

        if ($hopDong->isEmpty()) {
            return response()->json([
                'message' => 'Không tìm thấy hợp đồng cho người dùng này.'
            ], 404);
        }

        return response()->json($hopDong, 200);
    }
}
