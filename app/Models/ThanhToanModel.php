<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\HopDongModel;

class ThanhToanModel extends Model
{
    protected $table = 'thanh_toan';

    protected $fillable = [
        'token',
        'id_hop_dong',
        'so_tien',
        'hinh_thuc',
        'ma_giao_dich',
        'trang_thai',
        'created_at',
        'updated_at'
    ];
    public function hopDong()
    {
        return $this->belongsTo(HopDongModel::class, 'id_hop_dong');
    }
}
