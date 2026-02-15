<?php

namespace App\Http\Controllers;

use App\Models\Activity_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function formLogin()
    {
        return view("auth.login");
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:3'],
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // ✅ LOG LOGIN (PAKAI TABEL KAMU)
            Activity_log::create([
                'user_id' => $user->id,
                'aktivitas' => 'Login sebagai ' . ucfirst($user->role),
            ]);

            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat Datang Di Dashboard Admin');
            } elseif ($user->role === 'petugas') {
                return redirect()->route('petugas.dashboard')->with('success', 'Welcome Petugas!');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors('Role tidak dikenali.');
            }
        }
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }
}
