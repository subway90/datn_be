<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return view('emails.success_email_register');
    return view('404');

});

Route::get('/pay_result', function () {
    return view('pay.result');
});

Route::get('/pay_result', function () {
    return view('pay.result');
});