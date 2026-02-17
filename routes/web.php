<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('petugas.dashboard');
});

Route::get('/absensi/petugas', function () {
    return view('petugas.absensi');
});
