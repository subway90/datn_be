<?php
namespace App\Http\Controllers;

use App\Models\ToaNha;
use App\Models\Phong;
use Illuminate\Http\Request;
use function PHPUnit\Framework\isEmpty;

class ToaNhaController extends Controller
{
    public function showByID(Request $request)
    {
        $result = ToaNha::with('phongTro')->find($request->id);

        if (!$result) {
            return response()->json(['message' => 'content not found'], 404);
        }

        return response()->json($result);
    }

    public function detail($slug)
    {
        $result = ToaNha::with('phongTro')->where('slug', $slug)->first();

        if (!$result) {
            return response()->json(['message' => 'content not found'], 404);
        }

        return response()->json($result);
    }

    public function all()
    {
        $result = ToaNha::with('phongTro')->get();

        if (!$result) {
            return response()->json(['message' => 'content not found'], 404);
        }

        return response()->json($result);
    }
}