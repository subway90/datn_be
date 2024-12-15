<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class HopDong extends Model
{
    use SoftDeletes;
    protected $table = 'hop_dong';
    protected $fillable = [
        'phong_id',
        'tai_khoan_id',
        'file_hop_dong',
        'so_luong_xe',
        'so_luong_nguoi',
        'ngay_bat_dau',
        'ngay_ket_thuc',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    // Quan hệ một-nhiều với thanh toán
    public function hoaDon()
    {
        return $this->hasMany(HoaDon::class, 'hop_dong_id');
    }

    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }
}
