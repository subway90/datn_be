<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HopDong;
use Illuminate\Support\Facades\Auth;

class HopDongController extends Controller
{
    public function show()
    {
        // Lấy ID của người dùng đã đăng nhập
        $userId = Auth::id();
        
        // Lấy tất cả hợp đồng của người dùng
        $hopDongs = HopDong::where('tai_khoan_id', $userId)->get();

        // Kiểm tra xem người dùng có hợp đồng hay không
        if ($hopDongs->isEmpty()) {
            return response()->json(['message' => 'Bạn chưa có hợp đồng nào '], 404);
        }

        // Trả về danh sách hợp đồng
        return response()->json($hopDongs);
    }
}
