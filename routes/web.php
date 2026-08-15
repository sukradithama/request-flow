<?php

use Illuminate\Support\Facades\Route;

Route::get('/request', function () {
    return 'Request Page';
});

Route::get('/dashboard', function () {
    return 'Dashboard Page';
});
