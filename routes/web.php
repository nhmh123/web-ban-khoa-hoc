<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\DasboardController;

Route::get('/', function () {
    return view('user.pages.home');
});

Route::middleware(['auth', 'IsAdmin'])->group(function () {
});
Route::get('/admin', [DasboardController::class,'index'])->name('admin.dashboard');

Route::prefix('admin')->group(function(){
    Route::resource('users',UserController::class);
});