<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucTinTuc extends Model
{
    use HasFactory;

    // Nếu tên bảng không theo quy tắc đặt tên mặc định, bạn có thể chỉ định tên bảng
    protected $table = 'danh_muc_tin_tuc';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'ten_danh_muc',
        'slug',
        'trang_thai',
        'thu_tu',
    ];
}