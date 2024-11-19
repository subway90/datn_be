<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\HopDong;
class HoaDon extends Model
{
    use HasFactory,SoftDeletes;

    // Khai báo tên bảng
    protected $table = 'hoa_don';

    // Khai báo các trường có thể gán hàng loạt
    protected $fillable = [
        'hop_dong_id',
        'hinh_thuc',
        'tien_thue',
        'tien_dien',
        'tien_nuoc',
        'tien_xe',
        'tien_dich_vu',
        'noi_dung',
        'trang_thai',
    ];
    // Khai báo quan hệ với model HopDong
    public function hopDong()
    {
        return $this->belongsTo(HopDong::class, 'hop_dong_id');
    }
}