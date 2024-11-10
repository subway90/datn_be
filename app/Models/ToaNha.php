<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ToaNha extends Model
{
    use HasFactory,SoftDeletes;

    // Đặt tên bảng nếu khác với quy tắc mặc định
    protected $table = 'toa_nha';

    // Các thuộc tính có thể gán
    protected $fillable = [
        'khu_vuc_id',
        'slug',
        'ten',
        'image',
        'mo_ta',
        'vi_tri',
        'tien_ich',
        'noi_bat',
        'luot_xem',
    ];

    // Định nghĩa mối quan hệ với model KhuVuc
    public function khuVuc()
    {
        return $this->belongsTo(KhuVuc::class, 'khu_vuc_id');
    }
    public function phongTro()
    {
        return $this->hasMany(Phong::class,'toa_nha_id');
    }
    public function binhLuanToaNha()
    {
        return $this->hasMany(BinhLuanToaNha::class, 'toa_nha_id');
    }
}