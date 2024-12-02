<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('emails.verify_email_register');
});

Route::get('/pay_result', function () {
    return view('pay.result');
});