<?php

namespace App\Http\Controllers;
use App\Models\HoaDon;
use App\Models\User;
use App\Models\HopDong;
use App\Models\LienHeDatPhong;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;

class DashBoardController extends Controller
{
    public function total()
    {
        $total_contract = HopDong::count();
        $total_user = User::count();
        $total_contact = LienHeDatPhong::count();
        
        return response()->json([
           'total_contract' => $total_contract,
           'total_user' => $total_user,
           'total_contact_room' => $total_contact,
        ], 200);
    }
    public function thongke(Request $request)
    {
        // Lấy tham số từ request, nếu không có thì mặc định là tháng và năm hiện tại
        $thang = $request->input('thang'); // Tháng (tuỳ chọn)
        $nam = $request->input('nam', Carbon::now()->year); // Năm (mặc định là năm hiện tại)
    
        // Xây dựng query cơ bản
        $query = HoaDon::selectRaw('
                SUM(tien_thue 
                    + (tien_dien * so_ki_dien) 
                    + (tien_nuoc * so_khoi_nuoc) 
                    + (tien_xe * so_luong_xe) 
                    + (tien_dich_vu * so_luong_nguoi)
                ) as tong_doanh_thu 
            ')
            ->where('trang_thai', 1); // Chỉ lấy những hóa đơn có trạng thái = 1
        
        // Nếu người dùng chọn tháng
        if ($thang) {
            $query->whereMonth('created_at', $thang); // Lọc theo tháng
        }
    
        // Lọc theo năm
        $query->whereYear('created_at', $nam); // Lọc theo năm
    
        // Lấy kết quả
        $doanhThu = $query->first();
    
        // Trả về kết quả
        return response()->json([
            'thang' => $thang ?? null,  // Nếu không có tháng thì trả về null
            'nam' => $nam,
            'tong_doanh_thu' => $doanhThu ? $doanhThu->tong_doanh_thu : 0, // Trả về tổng doanh thu, nếu không có kết quả thì trả về 0
        ]);
    }
    
}
