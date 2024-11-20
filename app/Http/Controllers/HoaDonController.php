<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HoaDon;
use App\Models\HopDong;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class HoaDonController extends Controller
{
    public function store(Request $request) {
        // Xác thực dữ liệu đầu vào
        $validate = Validator::make($request->all(),[
            'id_hop_dong' => 'required|exists:hop_dong,id', // Kiểm tra hợp đồng tồn tại
            'tien_thue' => 'required|numeric',
            'tien_dien' => 'required|numeric',
            'tien_nuoc' => 'required|numeric',
            'tien_xe' => 'required|numeric',
            'tien_dich_vu' => 'required|numeric',
            'noi_dung' => 'nullable|string',
        ],[
            'id_hop_dong.required' => 'Chưa nhập ID Hợp đồng',
            'id_hop_dong.exists' => 'ID hợp đồng này không tồn tại',
            'tien_thue.required' => 'Chưa nhập tiền thuê',
            'tien_thue.numeric' => 'Tiền thuê phải là số',
            'tien_dien.required' => 'Chưa nhập tiền điện',
            'tien_dien.numeric' => 'Tiền điện phải là số',
            'tien_nuoc.required' => 'Chưa nhập tiền nước',
            'tien_nuoc.numeric' => 'Tiền nước phải là số',
            'tien_xe.required' => 'Chưa nhập tiền xe',
            'tien_xe.numeric' => 'Tiền xe phải là số',
            'tien_dich_vu.required' => 'Chưa nhập tiền dịch vụ',
            'tien_dich_vu.numeric' => 'Tiền dịch vụ phải là số',
            'noi_dung.string' => 'Nội dung phải là chuỗi',
        ]);
        if($validate->fails()) return response()->json(['message'=>$validate->errors()->all()],400);

        // Kiểm tra đã có hóa đơn trong vòng 30 ngày này chưa
        $get_orders = HoaDon::where('hop_dong_id',$request->id_hop_dong)->orderBy('created_at','DESC')->first();
        // if(!$get_orders) {
            $get_contract = HopDong::find($request->id_hop_dong);
            if($this->date_now->diffInDays($get_contract->ngay_bat_dau) > 30)
        // }


        // Tạo hóa đơn mới
        $hoaDon = HoaDon::create([
            'hop_dong_id' => $request->id_hop_dong,
            'hinh_thuc' => $request->hinh_thuc,
            'tien_thue' => $request->tien_thue,
            'tien_dien' => $request->tien_dien,
            'tien_nuoc' => $request->tien_nuoc,
            'tien_xe' => $request->tien_xe,
            'tien_dich_vu' => $request->tien_dich_vu,
            'noi_dung' => $request->noi_dung,
        ]);

        return response()->json(['message' => 'Hóa đơn đã được tạo thành công.', 'data' => $hoaDon], 201);
    }
}
