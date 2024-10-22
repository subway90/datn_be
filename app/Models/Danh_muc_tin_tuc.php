<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Danh_muc_tin_tuc extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'danh_muc_tin_tuc';

    protected $fillable = [
        'ten_danh_muc',
        'trang_thai',
    ];

}
