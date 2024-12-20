<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class BinhLuanToaNha extends Model
{
    use HasFactory, SoftDeletes;

    // Nếu tên bảng không theo quy tắc đặt tên mặc định, bạn có thể chỉ định tên bảng
    protected $table = 'binh_luan_toa_nha';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'tai_khoan_id',
        'toa_nha_id',
        'noi_dung',
        'trang_thai',
    ];
    protected $dates = ['deleted_at'];

    // Định nghĩa quan hệ với model User
    public function user()
    {
        return $this->belongsTo(User::class, 'tai_khoan_id');
    }

    // Định nghĩa quan hệ với model DanhMucTinTuc
    public function toaNha()
    {
        return $this->belongsTo(TinTuc::class, 'toa_nha_id');
    }
}
