<?php

namespace App\Http\Controllers;

use App\Models\YeuThich;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class YeuThichController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $userId = Auth::id();

        $favorites = YeuThich::where('tai_khoan_id', $userId)
            ->with('phong')
            ->get();

        return response()->json($favorites);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $userId = Auth::id();
        $roomId = $request->input('phong_id');

        $favorite = YeuThich::where('tai_khoan_id', $userId)
            ->where('phong_id', $roomId)
            ->first();

        if ($favorite) {
            $favorite->delete();
            return response()->json(['message' => 'Đã xóa khỏi danh sách yêu thích.'], 200);
        } else {
            YeuThich::create([
                'tai_khoan_id' => $userId,
                'phong_id' => $roomId,
            ]);
            return response()->json(['message' => 'Đã thêm vào danh sách yêu thích.'], 201);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
