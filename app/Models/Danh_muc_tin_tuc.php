<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Danh_muc_tin_tuc extends Model
{
    protected $table = 'danh_muc_tin_tuc';

    protected $fillable = [
        'ten_danh_muc',
        'trang_thai',
    ];

}
