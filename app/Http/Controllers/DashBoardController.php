<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\HopDong;
use App\Models\LienHeDatPhong;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function total()
    {
        $total_contract = HopDong::sum('luot_xem');
        $total_user = User::count();
        $total_contact = LienHeDatPhong::count();
        
        return response()->json([
           'total_contract' => $total_contract,
           'total_user' => $total_user,
           'total_contact_room' => $total_contact,
        ], 200);
    }
}
