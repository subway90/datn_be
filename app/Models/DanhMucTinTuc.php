<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMucTinTuc extends Model
{
    use HasFactory,SoftDeletes;

    // Nếu tên bảng không theo quy tắc đặt tên mặc định, bạn có thể chỉ định tên bảng
    protected $table = 'danh_muc_tin_tuc';

    // Các trường có thể được gán hàng loạt
    protected $fillable = [
        'ten_danh_muc',
        'slug',
    ];

    protected $dates = ['deleted_at']; // Đảm bảo trường deleted_at được xử lý như một ngày

    public function tinTuc()
    {
        return $this->hasMany(TinTuc::class, 'danh_muc_id'); // 'danh_muc_id' là khóa ngoại trong bảng tin_tuc
    }
}