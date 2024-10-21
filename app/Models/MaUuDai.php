<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaUuDai extends Model
{
    use HasFactory;

    // Khai báo tên bảng (nếu không theo quy tắc mặc định)
    protected $table = 'ma_uu_dai';

    // Khai báo các trường có thể gán hàng loạt
    protected $fillable = [
        'code',
        'mo_ta',
        'hinh_thuc',
        'gia_tri',
        'so_luong',
        'ngay_ket_thuc',
        'trang_thai',
    ];

    // Khai báo khóa chính nếu không phải là id
    protected $primaryKey = 'code';

    // Nếu khóa chính không phải là kiểu integer
    protected $keyType = 'string';

    // Xác định rằng khóa chính không tự động tăng
    public $incrementing = false;

    // Nếu bạn không muốn timestamps
    // public $timestamps = false;
}