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
            return [
                'id' => $rows->id,
                'name' => $rows->name
            ];
        });
        return response()->json(['list'=>$result],200);
    }

    public function all_delete() {
        $list = TienIchToaNha::onlyTrashed()->orderBy('deleted_at','DESC')->get();
        $result = $list->map(function($rows) {
            return [
                'id' => $rows->id,
                'name' => $rows->name,
            ];
        });
        return response()->json(['list'=>$result],200);
    }

    public function store(Request $request) {
        $validate = Validator::make($request->all(),[
            'name' => 'required|string|max:255',
        ],
    [
            'name.required' => 'Chưa nhập tên tiện ích',
            'name.string' => 'Tên nhập là chuỗi',
            'name.max' => 'Tên max 255 kí tự',
    ]);
    //Kiểm tra unique name
    if($validate->fails()) return response()->json(['message'=>$validate->errors()->all()],400);
    $check_name = TienIchToaNha::whereNull('deleted_at')->where('name',$request->name)->exists();
    if($check_name) return response()->json(['message' => 'Tên tiện ích này đã tồn tại'], 400);

    TienIchToaNha::create([
        'name' => $request->name
    ]);

        return response()->json(['message' => 'Tiện ích đã được thêm thành công.'], 201);
    }

    public function update(Request $request, $id) {
        $get = TienIchToaNha::find($id);
        if (!$get) {
            return response()->json(['message' => 'Tiện ích không tồn tại.'], 404);
        }
        $validate = Validator::make($request->all(),[
            'name' => 'required|string|max:255|unique:tien_ich_toa_nha,name,'.$id,
            ],
            [
            'name.required' => 'Chưa nhập tên tiện ích',
            'name.string' => 'Tên nhập là chuỗi',
            'name.max' => 'Tên max 255 kí tự',
            'name.unique' => 'Tên tiện ích này đã tồn tại',
        ]);
        if($validate->fails()) return response()->json(['message'=>$validate->errors()->all()],400);

        $get->name = $request->name;
        $get->save();

        return response()->json(['message' => 'Tiện ích đã được cập nhật thành công.'], 200);
    }

    public function destroy($id) {
        $tienIch = TienIchToaNha::find($id);
        if (!$tienIch) {
            return response()->json(['message' => 'Tiện ích không tồn tại.'], 404);
        }

        $tienIch->delete();

        return response()->json(['message' => 'Tiện ích đã được xóa thành công.'], 200);
    }

     public function restore($id) {
        $get = TienIchToaNha::withTrashed()->find($id);
        // Kiểm tra tồn tại ở list_delete
        if (!$get) return response()->json(['message' => 'Tiện ích không tồn tại.'], 404);
        $check_exist = TienIchToaNha::where('name',$get->name)->exists();
        // Kiểm tra tồn tại ở all
        if($check_exist) return response()->json(['message' => 'Tên tiện ích này đã tồn tại rồi, không thể khôi phục thêm'], 400);
        $get->restore();
        return response()->json(['message' => 'Tiện ích đã được khôi phục thành công.'], 200);
    }
}
