<?php

namespace App\Http\Controllers;

use App\Models\Activity_log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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
            // Guard logging so missing model/table doesn't break login
            if (class_exists(\App\Models\Activity_log::class)) {
                \App\Models\Activity_log::create([
                    'user_id' => $user->id,
                    'aktivitas' => 'Login sebagai ' . ucfirst($user->role),
                ]);
            }

            // log role for debugging
            Log::info('Login role check', ['email' => $user->email, 'role' => $user->role]);

            // route admins to admin dashboard, petugas and wali_kelas to petugas dashboard
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat Datang Di Dashboard Admin');
            }

            if (in_array($user->role, ['petugas', 'wali_kelas'])) {
                return redirect()->route('petugas.dashboard')->with('success', 'Selamat Datang.');
            }

            $roleVal = $user->role;
            Auth::logout();
            return redirect()->route('login')->withErrors('Role tidak dikenali: ' . ($roleVal ?? 'null'));
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
