<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\ThanhToanController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

//! API GET: hop-dong/{id_user}
Route::get('hop-dong/{id_user}', [HopDongController::class, 'getHopDong']);

//! API GET: thanh-toan/{id_hop_dong}
Route::get('thanh-toan/{id_hop_dong}', [ThanhToanController::class, 'getThanhToan']);
