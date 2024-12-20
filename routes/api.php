<?php

use App\Http\Controllers\BinhLuanToaNhaController;
use App\Http\Controllers\BinhLuanTinTucController;
use App\Http\Controllers\ConfigWebsiteController;
use App\Http\Controllers\DashBoardController;
use App\Http\Controllers\HoaDonController;
use App\Http\Controllers\TienIchToaNhaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\DangKyNhanTinController;
use App\Http\Controllers\PhongController;
use App\Http\Controllers\ToaNhaController;
use App\Http\Controllers\KhuVucController;
use App\Http\Controllers\HopDongController;
use App\Http\Controllers\ThanhToanController;
use App\Http\Controllers\TinTucController;
use App\Http\Controllers\DanhMucTinTucController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LienHeDatPhongController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\YeuThichController;
use App\Http\Controllers\GuiMailThongBaoController;


# Danh sách tòa nhà (option)
Route::get('toa-nha/option', [ToaNhaController::class, 'option']);

# Đăng kí email nhận tin
Route::post('/dang-ky-nhan-tin', [DangKyNhanTinController::class, 'register']);

# Xác thực email
Route::get('/verify-email-register/{token}',[DangKyNhanTinController::class, 'verify']);

# Danh sách banner
Route::get('banner/show', [BannerController::class, 'show']);

# Callback thanh toán vnpay
Route::get('pay/callback', [ThanhToanController::class, 'handleCallback']);

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

Route::post('google/loginWithGoogle', [GoogleController::class, 'loginWithGoogle']);

# Những API cần đăng nhập
Route::middleware(['CusTom'])->group(function () {

    # Tạo thanh toán VNPAY
    Route::get('pay/{token}', [ThanhToanController::class, 'pay']);

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
        Route::get('/show', [HopDongController::class, 'show']);

    });

    # Bình luận tin tức
    Route::post('blog/comment', [BinhLuanTinTucController::class, 'postComment']);

    # Cập nhật bình luận
    Route::put('blog/update_comment', [BinhLuanTinTucController::class, 'updateComment']);

    # Cập nhật avatar
    Route::post('updateAvatar', [AuthController::class, 'updateAvatar']);

    # Thay đổi mật khẩu
    Route::post('change_password', [AuthController::class, 'changePassword']);

    Route::prefix('yeu-thich')->group(function () {

        # Lấy danh sách
        Route::get('get', [YeuThichController::class, 'index']);

        # Cập nhật thêm/xóa
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

        # Lấy tất cả
        Route::get('/all', [HopDongController::class, 'all']);

        # Lấy danh sách đang hoạt động 
        Route::get('/hoat-dong', [HopDongController::class, 'index']);

         # Lấy danh sách hết hạn
         Route::get('/het-han', [HopDongController::class, 'het_han']);

         # Lấy danh sách gần hết hạn 10 ngày kể từ lúc hết hạn 
         Route::get ('/sap-het-han', [HopDongController::class, 'sap_het_han']);

        # Lấy danh sách đã xóa
        Route::get('/list_delete', [HopDongController::class, 'list_delete']);

        # Thêm hợp đồng
        Route::post('/add', [HopDongController::class, 'create']);

        # Sửa hợp đồng
        Route::post('/edit/{id}', [HopDongController::class, 'edit']);

        # Xóa hợp đồng
        Route::delete('/delete/{id}', [HopDongController::class, 'delete']);

        # Khôi phục hợp đồng
        Route::patch('/restore/{id}', [HopDongController::class, 'restore']);
        
        # Lấy theo id
        Route::get('/{id}', [HopDongController::class, 'detail']);

    });

    Route::prefix('comment_building')->group(function(){
        Route::get('/', [BinhLuanToaNhaController::class, 'getAll']); // Lấy tất cả
        Route::get('/list_delete', [BinhLuanToaNhaController::class, 'getdelete']); // Lấy danh sách đã xóa
        Route::get('/{id}', [BinhLuanToaNhaController::class, 'getid']); // Lấy theo id
        Route::delete('/delete/{id}', [BinhLuanToaNhaController::class, 'delete']); // Xóa theo id
        Route::patch('/restore/{id}', [BinhLuanToaNhaController::class, 'restore']); // Khôi phục theo id
    });    


    Route::prefix('contact_room')->group(function () {

        # Lấy danh sách
        Route::get('/', [LienHeDatPhongController::class, 'all']);

        # Thay đổi trạng thái xử lí
        Route::put('/xu-li/{id}', [LienHeDatPhongController::class, 'handle_contact']);

        # Lấy danh sách đã xóa
        Route::get('/list_delete', [LienHeDatPhongController::class, 'list_delete']);

        # Khôi phục
        Route::patch('/restore/{id}', [LienHeDatPhongController::class, 'restore']);

        # Xóa vĩnh viễn
        Route::delete('/delete/{id}', [LienHeDatPhongController::class, 'delete']);

    });

    Route::prefix('config_website')->group(function(){

        # Chỉnh sửa
        Route::post('/{id}',[ConfigWebsiteController::class, 'edit']);

        # Lấy thông tin
        Route::get('/getall', [ConfigWebsiteController::class, 'getall']);
    });


    Route::prefix('dashboard')->group(function () {

        # Thống kê tổng
        Route::get('/total', [DashBoardController::class, 'total']);

        # Thống kê doanh thu theo tháng
        Route::get('/doanh_thu', [DashBoardController::class, 'thongke']);

        # Lấy danh sách liên hệ chưa được sữ lý, limit là 5
        Route::get('/lien_he', [DashBoardController::class, 'lienhe']);
        
        # Lấy danh sách trễ hạn, mặc định là qua 0h00 ngày 1 hằng tháng
        Route::get('/tre_han', [DashBoardController::class, 'trehan']);

        # Lấy danh sách hợp đồng 
        Route::get('/hop_dong', [DashBoardController::class, 'hop_dong']);

         # Thống kê tổng liên hệ
         Route::get('/total_contact', [DashBoardController::class, 'total_contact']);
        # Lấy danh sách thống kê theo quận
        Route::get('/distric', [DashBoardController::class, 'distric']);

        # Thống kê hóa đơn theo quận và theo tháng 
        Route::get('/hoa_don/{year}', [DashBoardController::class, 'thongkehoadon']);
        
    
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
        Route::post('ban/{id}', [AuthController::class, 'banUser']);

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

        # Chỉnh sửa
        Route::post('/edit/{id}', [KhuVucController::class, 'edit']);

        # Khôi phục
        Route::patch('/restore/{id}', [KhuVucController::class, 'restore']);

        # Nhân bản theo ID
        Route::get('/duplicate/{id}', [KhuVucController::class, 'duplicate']);

        # Cập nhật hot
        Route::patch('/editHot/{id}', [KhuVucController::class, 'editHot']);
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
        Route::post('/edit/{id}', [ToaNhaController::class, 'edit']);

        # Thêm mới
        Route::delete('/delete/{id}', [ToaNhaController::class, 'delete']);

        # Khôi phục
        Route::patch('/restore/{id}', [ToaNhaController::class, 'restore']);

        # Nhân bản theo ID
        Route::get('/duplicate/{id}', [ToaNhaController::class, 'duplicate']);

        # Cập nhật hot
        Route::patch('/editHot/{id}', [ToaNhaController::class, 'editHot']);
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

        # Khôi phục
        Route::patch('/restore/{id}', [TienIchToaNhaController::class, 'restore']);
    });

    Route::prefix('hoa-don')->group(function () {

        # Lấy danh sách
        Route::get('/', [HoaDonController::class, 'all']);

        # Thêm mới
        Route::post('/add', [HoaDonController::class, 'store']);

        # Lấy theo ID
        Route::get('/{token}', [HoaDonController::class, 'detail']);
    });


    Route::prefix('phong')->group(function () {

        # Lấy danh sách
        Route::get('/', [PhongController::class, 'getAll']);

        # Lấy danh sách đã xóa
        Route::get('/list_delete', [PhongController::class, 'list_delete']);

        # Xóa theo id
        Route::delete('/delete/{id}', [PhongController::class, 'delete']);

        # Khôi phục theo id
        Route::patch('/restore/{id}', [PhongController::class, 'restore']);

        # Tạo mới
        Route::post('/add', [PhongController::class, 'store']);

        # Chỉnh sửa theo id
        Route::post('/edit/{id}', [PhongController::class, 'edit']);

        # Nhân bản theo id
        Route::get('duplicate/{id}', [PhongController::class, 'duplicate']);
    });


    Route::prefix('banner')->group(function () {

        # Lấy danh sách
        Route::get('/', [BannerController::class, 'all']);

        # Lấy danh sách đã xóa
        Route::get('/list_delete', [BannerController::class, 'list_delete']);

        # Lấy theo ID
        Route::get('/{id}', [BannerController::class, 'one']);

        # Thêm mới
        Route::post('/add', [BannerController::class, 'store']);

        # Chỉnh sữa
        Route::post('/update/{id}', [BannerController::class, 'update']);

        # Xóa mềm
        Route::delete('/delete/{id}', [BannerController::class, 'delete']);

        # Khôi phục
        Route::patch('/restore/{id}', [BannerController::class, 'restore']);

        # Nhân bản theo ID
        Route::get('/duplicate/{id}', [BannerController::class, 'duplicate']);

        # Cập nhật trạng thái
        Route::patch('/editStatus/{id}', [BannerController::class, 'editStatus']);
    });

    Route::prefix('dang-ky-nhan-tin')->group(function () {

        # Lấy danh sách
        Route::get('/', [DangKyNhanTinController::class, 'index']);

        # Lấy danh sách đã xóa
        Route::get('/list_delete', [DangKyNhanTinController::class, 'list_delete']);

        # Xóa theo ID
        Route::delete('/delete/{id}', [DangKyNhanTinController::class, 'destroy']);

        # Khôi phục theo ID
        Route::patch('/restore/{id}', [DangKyNhanTinController::class, 'restore']);
        
        # Gửi mail
        Route::post('/gui-mail', [DangKyNhanTinController::class, 'sendMail']);

        # Lịch sử gửi mail
        Route::get('/lich-su', [GuiMailThongBaoController::class, 'all']);
    });

});


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

# Lấy theo id
Route::get('phong/{id}', [PhongController::class, 'index']);
