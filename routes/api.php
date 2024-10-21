<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhongController;
use App\Http\Controllers\ToaNhaController;
use App\Http\Controllers\KhuVucController;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);

Route::get('/phong/{id_toa_nha}', [PhongController::class, 'index']);
Route::get('/phong', [PhongController::class, 'getAll']);

Route::get('/toa-nha', [ToaNhaController::class, 'showByID']);
Route::get('/toa-nha/all', [ToaNhaController::class, 'all']);
Route::get('/toa-nha/{slug}', [ToaNhaController::class, 'detail']);

Route::get('khu_vuc/getAll', [KhuVucController::class, 'getAll']);