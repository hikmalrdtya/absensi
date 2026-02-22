<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Petugas\AbsensiController;
use App\Services\SmsService;
use Illuminate\Support\Facades\Route;

Route::get('/test-sms', function () {
    SmsService::send(
        '0895366123060',
        'Test SMS dari Laravel Absensi'
    );
    return "SMS berhasil dikirim";
});

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

// routes for petugas/wali_kelas (shared dashboard)
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas,wali_kelas'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'masuk'])->name('dashboard');
    Route::post('absensi/{siswa}/send-sms', [AbsensiController::class, 'sendSms'])->name('absensi.sendSms');
    Route::resource('absensi', AbsensiController::class);
});

Route::get('/dashboard', [DashboardController::class, 'masuk'])->name('dashboard')->middleware('auth');

// admin routes (keep admin-only group for future admin pages)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // admin-only pages can be added here
});
