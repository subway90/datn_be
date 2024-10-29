<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResetPassword extends Model
{
    protected $table = 'otp_reset_password';
    protected $fillable = ['otp', 'email'];
    protected $primaryKey = 'otp';
    public $incrementing = false;
    public $timestamps = true;
}