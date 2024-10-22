<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhongController;
use App\Http\Controllers\ToaNhaController;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\ThanhToanController;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

# Đăng kí
Route::post('register', [AuthController::class, 'register']);
# Đăng nhập
Route::post('login', [AuthController::class, 'login']);
# Đăng xuất
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);
# Profile
Route::middleware('auth:sanctum')->get('profile', [AuthController::class, 'profile']);

#
Route::get('phong/{id_toa_nha}', [PhongController::class, 'index']);
#
Route::get('phong', [PhongController::class, 'getAll']);

# Chi tiết 1 tòa nhà bởi slug (Trang chi tiết)
Route::get('toa-nha', [ToaNhaController::class, 'detail']);
# Danh sách tòa nhà (List cho option của filter)
Route::get('toa-nha/all', [ToaNhaController::class, 'listName']);
# Danh sách tòa nhà theo section (Section Hot)
Route::get('toa-nha/listHot',[ToaNhaController::class,'listHot']);
# Danh sách tòa nhà theo lượt xem (Section View)
Route::get('toa-nha/listView',[ToaNhaController::class,'listView']);
# Danh sách tòa nhà theo giá phòng thấp nhất (Section View)
Route::get('toa-nha/listCheap',[ToaNhaController::class,'listCheap']);

# Danh sách khu vực (option của Area để Filter)
Route::get('khu_vuc/all', [KhuVucController::class, 'all']);
# Danh sách khu vực nổi bật (Section Area Hot để Filter)
Route::get('khu_vuc/listHot', [KhuVucController::class, 'listHot']);

#
Route::get('hop-dong/{id_user}', [HopDongController::class, 'getHopDong']);

#
Route::get('thanh-toan/{id_hop_dong}', [ThanhToanController::class, 'getThanhToan']);

