<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Phong extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu khác với quy tắc mặc định
    protected $table = 'phong';

    // Các thuộc tính có thể gán
    protected $fillable = [
        'toa_nha_id',
        'ten_phong',
        'hinh_anh',
        'dien_tich',
        'gac_lung',
        'gia_thue',
        'don_gia_dien',
        'don_gia_nuoc',
        'tien_xe_may',
        'phi_dich_vu',
        'tien_ich',
        'noi_that',
        'trang_thai',
    ];

    // Định nghĩa mối quan hệ với model ToaNha
    public function toaNha()
    {
        return $this->belongsTo(ToaNha::class, 'toa_nha_id');
    }
}