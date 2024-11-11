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
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
        'gia_thue',
    ];
    public function user()
    {
        return $this->hasOne(User::class, 'tai_khoan_id');
    }

    // Quan hệ một-nhiều với thanh toán
    public function thanhToan()
    {
        return $this->hasMany(ThanhToan::class, 'hop_dong_id');
    }
}
