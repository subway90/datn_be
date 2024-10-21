<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ToaNha extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu khác với quy tắc mặc định
    protected $table = 'toa_nha';

    // Các thuộc tính có thể gán
    protected $fillable = [
        'khu_vuc_id',
        'slug',
        'ten',
        'image',
        'gia_thue',
        'dien_tich',
        'mo_ta',
        'vi_tri',
        'tien_ich',
    ];

    // Định nghĩa mối quan hệ với model KhuVuc
    public function khuVuc()
    {
        return $this->belongsTo(KhuVuc::class, 'khu_vuc_id');
    }
    public function phongTro()
    {
        return $this->hasMany(Phong::class);
    }
}