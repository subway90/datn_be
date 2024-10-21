<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HopDongModel extends Model
{
    protected $table = 'hop_dong';

    protected $fillable = [
        'id_phong',
        'id_tai_khoan',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
        'gia_thue',
        'created_at',
        'updated_at'
    ];
    public function user()
    {
        return $this->belongsTo(Tai_Khoan::class, 'id_tai_khoan');
    }
}
