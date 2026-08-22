<?php

use Illuminate\Support\Facades\Route;

Route::get('/request', function () {
    return view("request");
});

Route::get('/dashboard', function () {
    return view('dashboard');
});
