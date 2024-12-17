<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConfigWebsite extends Model
{
    // Tên bảng trong cơ sở dữ liệu
    protected $table = 'config_website';

    // Các trường có thể được gán giá trị
    protected $fillable = [
        'name',
        'description',
        'favicon',
        'logo',
        'phone',
        'email',
        'address',
    ];

    public $timestamps = true;
}
