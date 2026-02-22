<?php

use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Petugas\AbsensiController;
use App\Services\SmsService;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| TEST SMS
|--------------------------------------------------------------------------
*/

Route::get('/test-sms', function () {
    SmsService::send(
        '0895366123060',
        'Test SMS dari Laravel Absensi'
    );
    return "SMS berhasil dikirim";
});

/*
|--------------------------------------------------------------------------
| AUTH
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('auth.login');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'formLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout')
    ->middleware('auth');


/*
|--------------------------------------------------------------------------
| PETUGAS & WALI KELAS
|--------------------------------------------------------------------------
*/
Route::prefix('petugas')
    ->name('petugas.')
    ->middleware(['auth', 'role:petugas,wali_kelas'])
    ->group(function () {

        Route::get('dashboard', [DashboardController::class, 'masuk'])
            ->name('dashboard');

        Route::post(
            'absensi/{siswa}/send-sms',
            [AbsensiController::class, 'sendSms']
        )->name('absensi.sendSms');

        Route::resource('absensi', AbsensiController::class);
    });

/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'role:admin'])
    ->group(function () {

        Route::get('dashboard', [DashboardController::class, 'masuk'])
            ->name('dashboard');

        Route::resource('petugas', PetugasController::class);
        Route::resource('kelas', KelasController::class);
        Route::resource('siswa', SiswaController::class);
    });
