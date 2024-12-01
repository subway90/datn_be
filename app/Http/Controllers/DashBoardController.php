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
        // Lấy tham số từ request, nếu không có thì mặc định là năm hiện tại
        $nam = $request->input('nam', Carbon::now()->year); // Năm (mặc định là năm hiện tại)
    
        // Khởi tạo mảng kết quả
        $doanhThuThang = [];
    
        // Duyệt qua các tháng từ 1 đến 12
        for ($thang = 1; $thang <= 12; $thang++) {
            // Xây dựng query cơ bản
            $query = HoaDon::selectRaw('
                    SUM(tien_thue 
                        + (tien_dien * so_ki_dien) 
                        + (tien_nuoc * so_khoi_nuoc) 
                        + (tien_xe * so_luong_xe) 
                        + (tien_dich_vu * so_luong_nguoi)
                    ) as tong_doanh_thu 
                ')
                ->where('trang_thai', 1) // Chỉ lấy những hóa đơn có trạng thái = 1
                ->whereMonth('created_at', $thang) // Lọc theo tháng
                ->whereYear('created_at', $nam); // Lọc theo năm
    
            // Lấy kết quả
            $doanhThu = $query->first();
    
            // Nếu không có doanh thu thì trả về 0, nếu có thì lấy giá trị
            $doanhThuThang[$thang] = $doanhThu->tong_doanh_thu ?? 0;
        }
    
        // Trả về kết quả
        return response()->json([
            'nam' => $nam,
            'doanh_thu_theo_thang' => $doanhThuThang, // Mảng doanh thu theo từng tháng
        ]);
    }
    
    
}
