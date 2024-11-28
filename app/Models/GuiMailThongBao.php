<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GuiMailThongBao extends Model
{
    protected $table = 'gui_mail_thong_bao';

    protected $fillable = [
        'content',
        'email',
        'all_mail',
    ];
}
