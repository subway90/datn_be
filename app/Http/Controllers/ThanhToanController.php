<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThanhToanModel;

class ThanhToanController extends Controller
{
    public function getThanhToan($id_hop_dong)
    {
        $thanhToan = ThanhToanModel::where('id_hop_dong', $id_hop_dong)->get();

        if ($thanhToan->isEmpty()) {
            return response()->json([
                'message' => 'Không tìm thấy thanh toán cho hợp đồng này.'
            ], 404);
        }

        return response()->json($thanhToan, 200);
    }
}
