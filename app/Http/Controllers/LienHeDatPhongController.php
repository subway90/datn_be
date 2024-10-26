<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\LienHeDatPhong;
use App\Models\Phong;
use Illuminate\Http\Request;

class LienHeDatPhongController extends Controller
{
    public function add(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'id_room' => 'required',
            'id_user' => 'nullable',
            'name' => 'required|string',
            'phone' => 'required|string|size:10',
            'content' => 'nullable|string',
        ], [
            'room_id.required' => 'Chưa nhập ID phòng',
            'name.required' => 'Vui lòng nhập họ và tên',
            'phone.required' => 'Vui lòng nhập SĐT',
            'phone.size' => 'Độ dài SĐT không hợp lệ (độ dài = 10 kí tự)',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors()->all(),
            ], 400); 
        }

        $checkRoom = Phong::find($request->id_room);

        if (!$checkRoom) {
            return response()->json([
                'message' => 'Phòng không tồn tại hoặc không hoạt động',
            ], 404);
        }

        LienHeDatPhong::create([
            'phong_id' => $request->id_room,
            'tai_khoan_id' => $request->id_user,
            'ho_ten' => $request->name,
            'so_dien_thoai' => $request->phone,
            'noi_dung' => $request->content,
        ]);


        // Trả về phản hồi JSON thành công
        return response()->json([
            'message' => 'Tạo liên hệ thành công'
        ], 201);
    }


}
