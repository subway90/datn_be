<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Binh_luan_tin_tuc extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'binh_luan_tin_tuc';

    protected $fillable = [
        'id_tai_khoan',
        'id_bai_viet',
        'noi_dung',
        'trang_thai',
    ];
}
