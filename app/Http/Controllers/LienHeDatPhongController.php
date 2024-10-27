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

    public function all() {

        $list = LienHeDatPhong::all();;
        if (!$list) {
            return response()->json(['message' => 'Danh mục không tồn tại.'], 404);
        }
        // Tùy chỉnh tên các key
        $data = $list->map(function ($item) {
            return [
                'id' => $item->id,
                'state' => $item->trang_thai,
                'id_room' => $item->phong_id,
                'id_user' => $item->tai_khoan_id,
                'name' => $item->ho_ten,
                'phone' => $item->so_dien_thoai,
                'content' => $item->noi_dung,
                'created_at' => $item->created_at,
                'updated_at' => $item->updated_at,
                'deleted_at' => $item->deleted_at,
            ];
        });
        return response()->json([
            'list_contact_room' => $data,
        ], 200);
    }

    public function one($id)
    {
        // Tìm danh mục theo ID
        $get = LienHeDatPhong::find($id);

        // Kiểm tra xem danh mục có tồn tại không
        if (!$get) {
            return response()->json(['message' => 'Không tìm thấy.'], 404);
        }
        // Tùy chỉnh tên các key
        $data = [
                'id' => $get->id,
                'state' => $get->trang_thai,
                'id_room' => $get->phong_id,
                'id_user' => $get->tai_khoan_id,
                'name' => $get->ho_ten,
                'phone' => $get->so_dien_thoai,
                'content' => $get->noi_dung,
                'created_at' => $get->created_at,
                'updated_at' => $get->updated_at,
                'deleted_at' => $get->deleted_at,
            ];
        return response()->json($data, 200);
    }

    public function destroy($id)
    {
        $one = LienHeDatPhong::find($id);
        if (!$one) return response()->json(['message' => 'Liên hệ không tồn tại'], 404);
        $one->delete();
        return response()->json(['message' => 'Xóa thành công'], 200);
    }

    public function restore($id)
    {
        $one = LienHeDatPhong::withTrashed()->find($id);
        if (!$one) return response()->json(['message' => 'Liên hệ không tồn tại'], 404);
        $one->restore();
        return response()->json(['message' => 'Khôi phục thành công.'], 200);
    }


}
