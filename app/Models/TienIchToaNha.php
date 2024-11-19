<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TienIchToaNha extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tien_ich_phong_tro';

    protected $fillable = [
        'name',
    ];
}
