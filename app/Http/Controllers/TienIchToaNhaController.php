<?php

namespace App\Http\Controllers;

use App\Models\TienIchToaNha;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TienIchToaNhaController extends Controller
{
    public function all() {
        $list = TienIchToaNha::orderBy('created_at','DESC')->get();
        $result = $list->map(function($rows) {
            return ['name' => $rows->name];
        });
        return response()->json(['list'=>$result],200);
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(),[
            'name' => 'required|string|max:255|unique:tien_ich_toa_nha,name',
        ],
    [
            'name.required' => 'Chưa nhập tên tiện ích',
            'name.string' => 'Tên nhập là chuỗi',
            'name.max' => 'Tên max 255 kí tự',
            'name.unique' => 'Tên tiện ích đã tồn tại',
    ]);
    if($validate->fails()) return response()->json(['message'=>$validate->errors()->all()],400);

    TienIchToaNha::create([
        'name' => $request->name
    ]);

        return response()->json(['message' => 'Tiện ích đã được thêm thành công.'], 201);
    }

    public function update(Request $request, $id) {
        $tienIch = TienIchToaNha::find($id);
        if (!$tienIch) {
            return response()->json(['message' => 'Tiện ích không tồn tại.'], 404);
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:tien_ich_toa_nha,name,' . $id,
        ]);

        $tienIch->name = $request->name;
        $tienIch->save();

        return response()->json(['message' => 'Tiện ích đã được cập nhật thành công.', 'data' => $tienIch], 200);
    }

    public function destroy($id) {
        $tienIch = TienIchToaNha::find($id);
        if (!$tienIch) {
            return response()->json(['message' => 'Tiện ích không tồn tại.'], 404);
        }

        $tienIch->delete();

        return response()->json(['message' => 'Tiện ích đã được xóa thành công.'], 200);
    }
}
