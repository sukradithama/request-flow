<?php

use App\Http\Controllers\RequestController;
use Illuminate\Support\Facades\Route;

// Request
Route::get('/request',[RequestController::class,'index'])->name('IndexRequest');
Route::get('/request/create',[RequestController::class,'create'])->name('CreateRequest');
Route::post('/request',[RequestController::class,'store'])->name('StoreRequest');
Route::get('/request/{slug}',[RequestController::class,'show'])->name('ShowRequest');
Route::get('/request/{slug}/edit',[RequestController::class,'edit'])->name('EditRequest');
Route::put('/request/{slug}',[RequestController::class,'update'])->name('UpdateRequest');
Route::delete('/request/{slug}',[RequestController::class,'destroy'])->name('DeleteRequest');

