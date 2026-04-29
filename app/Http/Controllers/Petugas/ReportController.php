<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
  public function index(Request $request)
  {
    $date = $request->query('date', now()->toDateString());
    return view('petugas.reports.index', compact('date'));
  }

  public function pdf(Request $request)
  {
    $request->validate(['date' => 'required|date']);
    $date = $request->query('date');

    $user = Auth::user();
    $kelasId = $user->kelas_id;

    $kelas = Kelas::where('id', $kelasId)
      ->with(['siswa' => function ($q) use ($date) {
        $q->with(['absensi' => function ($q2) use ($date) {
          $q2->whereDate('tanggal', $date);
        }])->orderBy('nama');
      }])->get();

    $title = "Laporan Absensi Kelas - {$date}";

    $pdf = Pdf::loadView('reports.daily_pdf', compact('kelas', 'date', 'title'))
      ->setPaper('a4', 'portrait');

    return $pdf->download("laporan-absensi-kelas-{$kelasId}-{$date}.pdf");
  }
}
