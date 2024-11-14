<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class YeuThich extends Model
{
    protected $table = 'yeu_thich';
    protected $fillable = ['tai_khoan_id', 'toa_nha_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'tai_khoan_id');
    }
    public function toa_nha()
    {
        return $this->belongsTo(ToaNha::class, 'toa_nha_id');
    }
}
