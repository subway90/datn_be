<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DangKyNhanTin extends Model
{
    use SoftDeletes;
    protected $table = 'dang_ky_nhan_tin';

    protected $fillable = [
        'email',
        'token_verify',
        'trang_thai',
    ];
}
