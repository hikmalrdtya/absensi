<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function masuk()
    {
        $user = Auth::user();
        if ($user->role === 'admin') {
            $siswa = Siswa::all()->count();
            $kelas = Kelas::all()->count();
            $petugas = User::where('role', 'petugas')->count();
            return view('admin.dashboard', compact('siswa', 'kelas', 'petugas'))->with('success', 'Selamat Datang Di Dashboard Admin');
        } elseif ($user->role === 'petugas') {
            return view('petugas.dashboard')->with('success', 'Welcome Petugas!');
        }
        abort(403, 'Role tidak dikenali.');
    }
}
