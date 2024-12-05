<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GuiMailThongBao;

class GuiMailThongBaoController extends Controller
{
    public function all() {
        $list = GuiMailThongBao::orderBy('created_at','DESC')->get();
        $result = $list->map(function($row){
            return [
                'id' => $row->id,
                'title' => $row->title,
                'content' => $row->content,
                'date' => $row->created_at->format('d').' Tháng '.$row->created_at->format('m').' lúc '.$row->created_at->format('H').':'.$row->created_at->format('i'),
            ];
        });
        return response()->json(['list'=>$result],200);
    }
}
