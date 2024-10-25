<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhongController;
use App\Http\Controllers\ToaNhaController;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\TinTucController;

# Đăng kí
Route::post('register', [AuthController::class, 'register']);
# Đăng nhập
Route::post('login', [AuthController::class, 'login']);

# Những API cần đăng nhập
Route::middleware(['CusTom'])->group(function () {
    # Đăng xuất
    Route::post('logout', [AuthController::class, 'logout']);
    # Lấy thông tin người dùng
    Route::get('profile', [AuthController::class, 'profile']);
    # Chỉnh sửa thông tin người dùng
    Route::put('updateProfile', [AuthController::class, 'updateProfile']);
    # Hiển thị thông tin hợp đồng của người dùng
    Route::get('/hop-dong', [HopDongController::class, 'show']);
    # Bình luận tin tức 
    Route::post('blog/comment', [TinTucController::class, 'postComment']);
    # Cập nhật bình luận
    Route::put('blog/update_comment', [TinTucController::class, 'updateComment']);
    #
    Route::get('thanh-toan/{id_hop_dong}', [ThanhToanController::class, 'getThanhToan']);

});

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

# Chức năng lọc
Route::get('/filter', [ToaNhaController::class, 'filter']);

# Danh sách khu vực (option của Area để Filter)
Route::get('khu_vuc/all', [KhuVucController::class, 'all']);
# Danh sách khu vực nổi bật (Section Area Hot để Filter)
Route::get('khu_vuc/listHot', [KhuVucController::class, 'listHot']);

# Danh sách tin tức
Route::get('blog/all', [TinTucController::class, 'getAll']);
# Chi tiết tin tức & bình luận
Route::get('blog', [TinTucController::class, 'getOne']);
# Danh sách tin tức mới nhất (Section Blog Newest)
Route::get('blog/listNew', [TinTucController::class, 'getAllListNew']);


