<?php

use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Petugas\AbsensiController;
use Illuminate\Support\Facades\Route;
use App\Services\SmsService;

// test sms - returns provider response as JSON. Use ?phone=08xxx&message=...
Route::get('/test-sms', function () {
    $phone = request('phone', env('TEST_SMS_NUMBER', '08XXXXXXXXXX'));
    $message = request('message', 'Test SMS dari Laravel Absensi');

    $result = SmsService::send($phone, $message);

    return response()->json($result);
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

//prefix admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'masuk'])->name('dashboard');
    Route::resource('petuga', PetugasController::class);
    Route::resource('kela', KelasController::class);
    Route::resource('siswa', SiswaController::class);
});

// prefix petugas
Route::prefix('petugas')->name('petugas.')->middleware(['auth', 'role:petugas'])->group(function () {
    Route::get('dashboard', [DashboardController::class, 'masuk'])->name('dashboard');

    // manual send sms route (per-siswa)
    Route::post('absensi/{siswa}/send-sms', [AbsensiController::class, 'sendSms'])->name('absensi.sendSms');

    Route::resource('absensi', AbsensiController::class);
});
