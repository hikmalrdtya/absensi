<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function masuk()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            return view('admin.dashboard')->with('success', 'Selamat Datang Di Dashboard Admin');
        } elseif ($user->role === 'petugas') {
            return view('petugas.dashboard')->with('success', 'Welcome Petugas!');
        }
        abort(403, 'Role tidak dikenali.');
    }
}
