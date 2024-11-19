<?php

use App\Http\Controllers\BinhLuanToaNhaController;
use App\Http\Controllers\BinhLuanTinTucController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\TienIchToaNhaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhongController;
use App\Http\Controllers\ToaNhaController;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\TinTucController;
use App\Http\Controllers\DanhMucTinTucController;
use App\Http\Controllers\LienHeDatPhongController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\YeuThichController;

#
Route::get('phong', [PhongController::class, 'getAll']);

# Chi tiết 1 tòa nhà bởi slug (Trang chi tiết)
Route::get('chi-tiet', [ToaNhaController::class, 'detail']);

# Danh sách tòa nhà theo section (Section Hot)
Route::get('toa-nha/listHot', [ToaNhaController::class, 'listHot']);

# Danh sách tòa nhà theo lượt xem (Section View)
Route::get('toa-nha/listView', [ToaNhaController::class, 'listView']);

# Danh sách tòa nhà theo giá phòng thấp nhất (Section View)
Route::get('toa-nha/listCheap', [ToaNhaController::class, 'listCheap']);

# Danh sách tin tức
Route::get('blog/all', [TinTucController::class, 'getAll']);

# Chi tiết tin tức & bình luận
Route::get('blog', [TinTucController::class, 'getOne']);

# Danh sách tin tức mới nhất (Section Blog Newest)
Route::get('blog/listNew', [TinTucController::class, 'getAllListNew']);

# Đăng kí
Route::post('register', [AuthController::class, 'register']);

# Đăng nhập
Route::post('login', [AuthController::class, 'login']);

# Quên mật khẩu : check
Route::post('forgot/check', [ResetPasswordController::class, 'check']);
# Quên mật khẩu : reset
Route::post('forgot/reset', [ResetPasswordController::class, 'reset']);

# Những API cần đăng nhập
Route::middleware(['CusTom'])->group(function () {

    # Danh sách liên hệ thông qua token của người đó
    Route::get('contact_room/list', [LienHeDatPhongController::class, 'contactList']);

    # Tạo liên hệ đặt phòng mới
    Route::post('contact_room/add', [LienHeDatPhongController::class, 'add']);

    # Đăng bình luận tòa nhà mới
    Route::post('building_cmt/add', [BinhLuanToaNhaController::class, 'add']);

    # Đăng xuất
    Route::post('logout', [AuthController::class, 'logout']);

    # Lấy thông tin người dùng
    Route::get('profile', [AuthController::class, 'profile']);

    # Chỉnh sửa thông tin người dùng
    Route::put('updateProfile', [AuthController::class, 'updateProfile']);

    Route::prefix('hop-dong')->group(function () {
        # Hiển thị thông tin hợp đồng của người dùng
        Route::get('/', [HopDongController::class, 'show']);
    });

    # Bình luận tin tức
    Route::post('blog/comment', [BinhLuanTinTucController::class, 'postComment']);

    # Cập nhật bình luận
    Route::put('blog/update_comment', [BinhLuanTinTucController::class, 'updateComment']);

    #
    Route::get('thanh-toan/{id_hop_dong}', [ThanhToanController::class, 'getThanhToan']);
    #
    Route::post('updateAvatar', [AuthController::class, 'updateAvatar']);

    # Thay đổi mật khẩu
    Route::post('change_password', [AuthController::class, 'changePassword']);

    #
    Route::prefix('yeu-thich')->group(function () {
        Route::get('get', [YeuThichController::class, 'index']);
        Route::post('add', [YeuThichController::class, 'create']);
    });
});

# Những API cần đăng nhập và là ADMIN
Route::middleware(['Admin'])->group(function () {


    Route::prefix('cate_blog')->group(function () {
        # Lấy danh sách tất cả
        Route::get('/', [DanhMucTinTucController::class, 'all']);
        
        # Lấy danh sách đã xóa
        Route::get('/list_delete', [DanhMucTinTucController::class, 'list_delete']);

        # Lấy duy nhất 1
        Route::get('/{id}', [DanhMucTinTucController::class, 'one']);

        # Cập nhật danh mục tin tức
        Route::put('/edit/{id}', [DanhMucTinTucController::class, 'edit']);

        # Thêm danh mục tin tức
        Route::post('/add', [DanhMucTinTucController::class, 'add']);

        # Xóa danh mục tin tức
        Route::delete('/delete/{id}', [DanhMucTinTucController::class, 'destroy']);

        # Khôi phục danh mục tin tức
        Route::patch('/restore/{id}', [DanhMucTinTucController::class, 'restore']);
    });

    Route::prefix('hop-dong')->group(function () {

        # Lấy danh sách
        Route::get('/all', [HopDongController::class, 'index']);

        # Lấy danh sách đã xóa
        Route::get('/list_delete', [HopDongController::class, 'list_delete']);

        # Thêm hợp đồng
        Route::post('/add', [HopDongController::class, 'create']);

        # Sửa hợp đồng
        Route::put('/edit/{id}', [HopDongController::class, 'edit']);

        # Xóa hợp đồng
        Route::delete('/delete/{id}', [HopDongController::class, 'delete']);

        # Khôi phục hợp đồng
        Route::patch('/restore/{id}', [HopDongController::class, 'restore']);

    });


    Route::prefix('contact_room')->group(function () {

        # Lấy danh sách
        Route::get('/', [LienHeDatPhongController::class, 'all']);

        # Xóa
        Route::delete('/delete/{id}', [LienHeDatPhongController::class, 'destroy']);


        # Khôi phục
        Route::post('/restore/{id}', [LienHeDatPhongController::class, 'restore']);
    });



    Route::prefix('dashboard')->group(function () {

        # Thống kê tổng
        Route::get('/total', [DashBoardController::class, 'total']);
    });



    Route::prefix('blog')->group(function () {
        
        # Danh sách tin tức đã xóa
        Route::get('/list_delete', [TinTucController::class, 'listDelete']);

        # Lấy duy nhất 1
        Route::get('/{id}', [TinTucController::class, 'getOneByID']);

        // # Cập nhật tin tức
        Route::put('/edit/{id}', [TinTucController::class, 'edit']);

        # Thêm tin tức mới
        Route::post('/add', [TinTucController::class, 'add']);

        # Xóa tin tức
        Route::delete('/delete/{id}', [TinTucController::class, 'destroy']);

        # Khôi phục tin tức
        Route::get('/restore/{id}', [TinTucController::class, 'restore']);

        # Khôi phục tin tức
        Route::get('/duplicate/{id}', [TinTucController::class, 'duplicate']);
    });



    Route::prefix('user')->group(function () {

        # Lấy tất cả
        Route::get('/', [AuthController::class, 'all']);

        # Lấy tất cả id bị xóa
        Route::get('/list_delete', [AuthController::class, 'getDeletedUsers']);

        # Lấy 1 theo ID
        Route::get('/{id}', [AuthController::class, 'one']);

        # Chỉnh sửa theo ID
        Route::put('edit/{id}', [AuthController::class, 'editUser']);

        # Xóa theo ID
        Route::delete('delete/{id}', [AuthController::class, 'deleteUser']);

        #Khôi phục theo ID
        Route::post('restore/{id}', [AuthController::class, 'restoreUser']);

        # Nhân bản theo ID
        Route::get('duplicate/{id}', [AuthController::class, 'duplicateUser']);
    });



    Route::prefix('khu-vuc')->group(function () {

        # Thống kê tổng
        Route::get('/', [KhuVucController::class, 'all']);

        # Thống kê tổng
        Route::get('/list_delete', [KhuVucController::class, 'list_delete']);

        # Thống kê tổng
        Route::get('/{id}', [KhuVucController::class, 'one']);

        # Thêm mới
        Route::post('/add', [KhuVucController::class, 'store']);

        # Thêm mới
        Route::delete('/delete/{id}', [KhuVucController::class, 'delete']);

        # Khôi phục
        Route::post('/restore/{id}', [KhuVucController::class, 'restore']);

        # Nhân bản theo ID
        Route::get('/duplicate/{id}', [KhuVucController::class, 'duplicate']);
    });


    Route::prefix('toa-nha')->group(function () {

        # Thống kê tổng
        Route::get('/', [ToaNhaController::class, 'all']);

        # Thống kê tổng
        Route::get('/list_delete', [ToaNhaController::class, 'list_delete']);

        # Thống kê tổng
        Route::get('/{id}', [ToaNhaController::class, 'one']);

        # Thêm mới
        Route::post('/add', [ToaNhaController::class, 'store']);

        // # Cập nhật
        Route::post('/edit', [ToaNhaController::class, 'edit']);        

        # Thêm mới
        Route::delete('/delete/{id}', [ToaNhaController::class, 'delete']);

        # Khôi phục
        Route::patch('/restore/{id}', [ToaNhaController::class, 'restore']);

        # Nhân bản theo ID
        Route::get('/duplicate/{id}', [ToaNhaController::class, 'duplicate']);
    });

    Route::prefix('utilities')->group(function () {

        # Lấy tất cả
        Route::get('/all', [TienIchToaNhaController::class, 'all']);

        # Lấy tất cả
        Route::get('/list_delete', [TienIchToaNhaController::class, 'all_delete']);
        
        # Thêm mới
        Route::post('/add', [TienIchToaNhaController::class, 'store']);

        # Chỉnh sửa
        Route::put('/edit/{id}', [TienIchToaNhaController::class, 'update']);

        # Xóa
        Route::delete('/delete/{id}', [TienIchToaNhaController::class, 'destroy']);

    });
});


#
Route::get('phong/{id_toa_nha}', [PhongController::class, 'index']);

# Chức năng lọc theo tòa nhà
Route::get('/filter', [ToaNhaController::class, 'filter']);

# Chức năng lọc theo phòng
Route::get('/filter-room', [PhongController::class, 'filter']);

# Danh sách khu vực (option của Area để Filter)
Route::get('khu_vuc/option', [KhuVucController::class, 'option']);

# Danh sách khu vực nổi bật (Section Area Hot để Filter)
Route::get('khu_vuc/listHot', [KhuVucController::class, 'listHot']);

# Tạo liên hệ đặt phòng mới
Route::post('contact_room/add', [LienHeDatPhongController::class, 'add']);
