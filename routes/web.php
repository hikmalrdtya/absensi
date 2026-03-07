<?php

use App\Http\Controllers\Admin\KelasController;
use App\Http\Controllers\Admin\PetugasController;
use App\Http\Controllers\Admin\SiswaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Petugas\AbsensiController;
use App\Http\Controllers\Admin\AbsensiController as AdminAbsensiController;
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

        // Single-student edit form (select one siswa to edit today's attendance)
        Route::get('absensi/edit-single', [AbsensiController::class, 'editSingle'])->name('absensi.editSingle');
        Route::post('absensi/update-single', [AbsensiController::class, 'updateSingle'])->name('absensi.updateSingle');

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

        Route::resource('petuga', PetugasController::class);
        Route::resource('kela', KelasController::class);
        Route::resource('siswa', SiswaController::class);
        Route::resource('absensi', AdminAbsensiController::class)->only(['index', 'show', 'edit', 'update', 'destroy']);
        Route::get('siswa/{siswa}/absensi', [SiswaController::class, 'showAbsensi'])->name('siswa.absensi');
    });
