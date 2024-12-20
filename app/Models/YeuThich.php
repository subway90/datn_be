<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YeuThich extends Model
{
    protected $table = 'yeu_thich';
    protected $fillable = ['tai_khoan_id', 'phong_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'tai_khoan_id');
    }
    public function phong()
    {
        return $this->belongsTo(Phong::class, 'phong_id');
    }
}
