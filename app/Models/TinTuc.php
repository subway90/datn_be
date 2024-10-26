<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TinTuc extends Model
{
    use HasFactory,SoftDeletes;

    // Nếu tên bảng không theo quy tắc đặt tên mặc định, bạn có thể chỉ định tên bảng
    protected $table = 'tin_tuc';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'tai_khoan_id',
        'danh_muc_id',
        'tieu_de',
        'slug',
        'image',
        'noi_dung',
        'trang_thai',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'tai_khoan_id');
    }

    public function danhMuc()
    {
        return $this->belongsTo(DanhMucTinTuc::class, 'danh_muc_id');
    }
    
    public function binhLuanTinTuc()
    {
        return $this->hasMany(BinhLuanTinTuc::class, 'tin_tuc_id');
    }
}