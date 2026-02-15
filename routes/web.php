<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.login');
});

//auth login
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});
//auth logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

//prefix admin
Route::prefix('admin')->name('admin.')->middleware(['auth','role:admin'])->group(function (){
//dashboard
    Route::get('dashboard', [DashboardController::class, 'masuk'])->name('dashboard');
});