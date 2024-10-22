<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TinTuc extends Model
{
    use HasFactory;

    // Nếu tên bảng không theo quy tắc đặt tên mặc định, bạn có thể chỉ định tên bảng
    protected $table = 'tin_tuc';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'tai_khoan_id',
        'danh_muc_id',
        'tieu_de',
        'slug',
        'image',
        'noi_dung',
        'trang_thai',
    ];

    // Định nghĩa quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class, 'tai_khoan_id');
    }

    // Định nghĩa quan hệ với model DanhMucTinTuc
    public function danhMuc()
    {
        return $this->belongsTo(DanhMucTinTuc::class, 'danh_muc_id');
    }
}