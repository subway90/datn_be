<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhuVuc extends Model
{
    use HasFactory;

    // Đặt tên bảng nếu khác với quy tắc mặc định
    protected $table = 'khu_vuc';

    // Các thuộc tính có thể gán
    protected $fillable = [
        'ten',
        'slug',
        'image',
        'thu_tu',
        'noi_bat',
    ];
}