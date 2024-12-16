<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class LienHeDatPhong extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'lien_he_dat_phong'; // Tên bảng nếu không theo quy tắc Laravel

    protected $fillable = [
        'phong_id',
        'tai_khoan_id',
        'ho_ten',
        'so_dien_thoai',
        'noi_dung',
        'trang_thai',
    ];

    // Mối quan hệ với model Phong
    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id')->withDefault();
    }

    // Mối quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class, 'tai_khoan_id')->withDefault();
    }
}