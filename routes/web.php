<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;



// Authentication
Route::middleware('guest')->group(function () {
    Route::get('/', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/', [AuthController::class, 'login'])
        ->name('Login');

    Route::get('/register', [AuthController::class, 'showRegister'])
        ->name('RegisterForm');

    Route::post('/register', [AuthController::class, 'register'])
        ->name('Register');
});

Route::middleware('auth')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout'])->name('Logout');
    
    // Request
    Route::get('/request',[RequestController::class,'index'])->name('IndexRequest');
    Route::get('/request/create',[RequestController::class,'create'])->name('CreateRequest');
    Route::post('/request',[RequestController::class,'store'])->name('StoreRequest');
    Route::get('/request/{slug}',[RequestController::class,'show'])->name('ShowRequest');
    Route::get('/request/{slug}/edit',[RequestController::class,'edit'])->name('EditRequest');
    Route::put('/request/{slug}',[RequestController::class,'update'])->name('UpdateRequest');
    Route::put('/request/{slug}/status',[RequestController::class,'updateStatus'])->name('UpdateRequestStatus');
    Route::delete('/request/{slug}',[RequestController::class,'destroy'])->name('DeleteRequest');
});



