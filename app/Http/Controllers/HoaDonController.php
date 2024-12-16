<?php

namespace App\Http\Controllers;

use App\Models\HopDong;
use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\Phong;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Uuid;

class HoaDonController extends Controller
{
    public function store(Request $request) {
        // Xác thực dữ liệu đầu vào
        $validate = Validator::make($request->all(),[
            'id_hop_dong' => 'required|exists:hop_dong,id', // Kiểm tra hợp đồng tồn tại
            'so_ki_dien' => 'required|numeric',
            'so_khoi_nuoc' => 'required|numeric',
            'noi_dung' => 'nullable|string',
        ],[
            'id_hop_dong.required' => 'Chưa nhập ID Hợp đồng',
            'id_hop_dong.exists' => 'ID hợp đồng này không tồn tại',
            'so_ki_dien.required' => 'Chưa nhập Số kí điện',
            'so_ki_dien.numeric' => 'Số kí điện phải là số',
            'so_khoi_nuoc.required' => 'Chưa nhập Số khối nước',
            'so_khoi_nuoc.numeric' => 'Số khối nước phải là số',
            'noi_dung.string' => 'Nội dung phải là chuỗi',
        ]);
        if($validate->fails()) return response()->json(['message'=>$validate->errors()->all()],400);

        // Kiểm tra đã có hóa đơn trong vòng 30 ngày này chưa
        $get_orders = HoaDon::where('hop_dong_id',$request->id_hop_dong)->orderBy('created_at','DESC')->first();
        // if(!$get_orders) {
            // $get_contract = HopDong::find($request->id_hop_dong);
            // if($this->date_now->diffInDays($get_contract->ngay_bat_dau) > 30)
        // }

        // Lấy thông tin phòng từ hợp đồng
        $get_contract = HopDong::select('phong_id','so_luong_xe','so_luong_nguoi')->where('id',$request->id_hop_dong)->first();
        $get_room = Phong::find($get_contract->phong_id);

        // Tạo hóa đơn mới
        $hoaDon = HoaDon::create([
            'token' => Uuid::uuid4()->toString(),
            'hop_dong_id' => $request->id_hop_dong,
            'tien_thue' => $get_room->gia_thue,
            'tien_dien' => $get_room->don_gia_dien,
            'tien_nuoc' => $get_room->don_gia_nuoc,
            'tien_xe' => $get_room->tien_xe_may,
            'tien_dich_vu' => $get_room->phi_dich_vu,
            'so_luong_xe' => $get_contract->so_luong_xe,
            'so_luong_nguoi' => $get_contract->so_luong_nguoi,
            'so_ki_dien' => $request->so_ki_dien,
            'so_khoi_nuoc' => $request->so_khoi_nuoc,
            'noi_dung' => $request->noi_dung,
        ]);

        return response()->json(['message' => 'Hóa đơn đã được tạo thành công.', 'data' => $hoaDon], 201);
    }

    public function all()
    {
        // Lấy tất cả danh sách phòng
        $list_order = HoaDon::orderBy('created_at','DESC')->get();

        if($list_order->isEmpty()) return response()->json(['message' => 'Danh sách hóa đơn trống'], 404);

        //Chuyển đổi kết quả
        $result = $list_order->map(function ($order) {
            $total = $order->tien_thue;
            $total += $order->tien_dien * $order->so_ki_dien;
            $total += $order->tien_nuoc * $order->so_khoi_nuoc;
            $total += $order->tien_xe * $order->so_luong_xe;
            $total += $order->tien_dich_vu * $order->so_luong_nguoi;
            return [
                'token' => $order->token,
                'hop_dong_id' => $order->hop_dong_id,
                'tong_tien' => $total,
                'trang_thai' => $order->trang_thai ? 'Đã thanh toán' : 'Chưa thanh toán',
                'hinh_thuc' => $order->hinh_thuc ? 'Thanh toán online' : 'Thanh toán tiền mặt',
                'tien_thue' => $order->tien_thue,
                'tien_dien' => $order->tien_dien,
                'so_ki_dien' => $order->so_ki_dien,
                'tien_nuoc' => $order->tien_nuoc,
                'so_khoi_nuoc' => $order->so_khoi_nuoc,
                'tien_xe' => $order->tien_xe,
                'so_luong_xe' => $order->so_luong_xe,
                'tien_dich_vu' => $order->tien_dich_vu,
                'so_luong_nguoi' => $order->so_luong_nguoi,
                'ngay_tao' => $order->created_at->format('d').' tháng '.$order->created_at->format('m').' năm '.$order->created_at->format('Y').' lúc '.$order->created_at->format('H').':'.$order->created_at->format('i'),
                'ngay_cap_nhat' => $order->updated_at->format('d').' tháng '.$order->updated_at->format('m').' năm '.$order->updated_at->format('Y').' lúc '.$order->updated_at->format('H').':'.$order->updated_at->format('i'),
            ];
        });
    
        return response()->json(['list' => $result],200);
    }

    public function detail($token)
    {
        // Lấy tất cả danh sách phòng
        $order = HoaDon::where('token',$token)->first();

        if(!$order) return response()->json(['message' => 'Hóa đơn này không tồn tại'], 404);

        // Tính tổng tiền hóa đơn
        $total = 0;
        $total = $order->tien_thue;
        $total += $order->tien_dien * $order->so_ki_dien;
        $total += $order->tien_nuoc * $order->so_khoi_nuoc;
        $total += $order->tien_xe * $order->so_luong_xe;
        $total += $order->tien_dich_vu * $order->so_luong_nguoi;
        //Chuyển đổi kết quả
        $result = [
                'token' => $order->token,
                'hop_dong_id' => $order->hop_dong_id,
                'tong_tien' => $total,
                'trang_thai' => $order->trang_thai ? 'Đã thanh toán' : 'Chưa thanh toán',
                'hinh_thuc' => $order->hinh_thuc ? 'Thanh toán online' : 'Thanh toán tiền mặt',
                'tien_thue' => $order->tien_thue,
                'tien_dien' => $order->tien_dien,
                'so_ki_dien' => $order->so_ki_dien,
                'tien_nuoc' => $order->tien_nuoc,
                'so_khoi_nuoc' => $order->so_khoi_nuoc,
                'tien_xe' => $order->tien_xe,
                'so_luong_xe' => $order->so_luong_xe,
                'tien_dich_vu' => $order->tien_dich_vu,
                'so_luong_nguoi' => $order->so_luong_nguoi,
                'ngay_tao' => $order->created_at->format('d').' tháng '.$order->created_at->format('m').' năm '.$order->created_at->format('Y').' lúc '.$order->created_at->format('H').':'.$order->created_at->format('i'),
                'ngay_cap_nhat' => $order->updated_at->format('d').' tháng '.$order->updated_at->format('m').' năm '.$order->updated_at->format('Y').' lúc '.$order->updated_at->format('H').':'.$order->updated_at->format('i'),
            ];
        return response()->json($result,200);
    }
}
