<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class HopDong extends Model
{
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
        return $this->belongsTo(User::class, 'tai_khoan_id');
    }
}
