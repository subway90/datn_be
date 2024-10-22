<?php

namespace App\Http\Controllers;

use App\Models\TinTuc;
use Illuminate\Http\Request;

class TinTucController extends Controller
{
    public function tinTucgetall(){
        $tintucs = TinTuc::all();
        return response()->json($tintucs);
    }
    public function getOne(Request $request)
    {
        // Lấy slug từ query parameter
        $slug = $request->query('slug');

        // Tìm tin tức dựa trên slug
        $tintuc = TinTuc::where('slug', $slug)->with('BinhLuanTinTuc')->first();
        

        // Kiểm tra nếu không tìm thấy tin tức
        if (!$tintuc) {
            return response()->json(['error' => 'Tin tức không tồn tại'], 404);
        }

        // Trả về JSON với tin tức và các bình luận
        return response()->json($tintuc);
    }


}
