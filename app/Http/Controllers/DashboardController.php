<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Absensi;
use App\Models\SmsLog;
use Illuminate\Support\Facades\DB;
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

            // Data for charts / widgets
            $kelasWithCount = Kelas::withCount('siswa')->get();
            $kelasLabels = $kelasWithCount->pluck('nama_kelas')->toArray();
            $kelasCounts = $kelasWithCount->pluck('siswa_count')->toArray();

            $statusCounts = Absensi::select('status', DB::raw('count(*) as total'))
                ->groupBy('status')
                ->get()
                ->pluck('total', 'status')
                ->toArray();

            $recentAbsensi = Absensi::with('siswa')->orderBy('tanggal', 'desc')->limit(5)->get();
            $recentSms = SmsLog::with('siswa')->orderBy('created_at', 'desc')->limit(5)->get();

            return view('admin.dashboard', compact(
                'siswa',
                'kelas',
                'petugas',
                'kelasLabels',
                'kelasCounts',
                'statusCounts',
                'recentAbsensi',
                'recentSms'
            ))->with('success', 'Selamat Datang Di Dashboard Admin');
        } elseif ($user->role === 'petugas') {
            return view('petugas.dashboard')->with('success', 'Welcome Petugas!');
        }
        abort(403, 'Role tidak dikenali.');
    }
}
