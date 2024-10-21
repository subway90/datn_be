<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\HopDong;
use App\Models\MaUuDai;

class ThanhToan extends Model
{
    use HasFactory;

    // Khai báo tên bảng
    protected $table = 'thanh_toan';

    // Khai báo các trường có thể gán hàng loạt
    protected $fillable = [
        'hop_dong_id',
        'code_uu_dai',
        'ma_giao_dich',
        'so_tien',
        'noi_dung',
        'trang_thai',
        'hinh_thuc',
        'ngay_giao_dich',
    ];
    // Khai báo quan hệ với model HopDong
    public function hopDong()
    {
        return $this->belongsTo(HopDong::class, 'hop_dong_id');
    }

    // Khai báo quan hệ với model MaUuDai
    public function maUuDai()
    {
        return $this->belongsTo(MaUuDai::class, 'code_uu_dai');
    }
}