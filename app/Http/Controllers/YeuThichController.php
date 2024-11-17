<?php

namespace App\Http\Controllers;

use App\Models\YeuThich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class YeuThichController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Lấy ID User
        $userId = Auth::id();

        // Lấy danh sách ID phòng yêu thích
        $list_room = YeuThich::where('tai_khoan_id', $userId)->pluck('phong_id');

        // Validate
        if ($list_room->isEmpty()) return response()->json(['message' => 'Chưa có yêu thích phòng nào'], 404);
        
        // Chuyển đổi danh sách ID thành chuỗ
        $resultString = $list_room->implode(';');
        
        //
        return response()->json(['list_id' => $resultString], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'id_room' => 'required|exists:phong,id',
        ],[
            'id_room.required' => 'Chưa nhập ID phòng',
            'id_room.exists' => 'ID Phòng không tồn tại',
        ]);

        if($validate->fails()) return response()->json(['message' => $validate->errors()->all()],400);

        $id_user = Auth::id();

        $favorite = YeuThich::where('tai_khoan_id', $id_user)
            ->where('phong_id', $request->id_room)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Đã xóa khỏi danh sách yêu thích.'], 200);
        } else {
            YeuThich::create([
                'tai_khoan_id' => $id_user,
                'phong_id' => $request->id_room,
            ]);
            return response()->json(['message' => 'Đã thêm vào danh sách yêu thích.'], 201);
        }
    }
}