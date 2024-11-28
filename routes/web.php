<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('emails.new_password');
});

Route::get('/pay_result', function () {
    return view('pay.result');
});