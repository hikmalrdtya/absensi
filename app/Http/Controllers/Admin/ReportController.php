<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
  public function index(Request $request)
  {
    $date = $request->query('date', now()->toDateString());
    return view('admin.reports.index', compact('date'));
  }

  public function pdf(Request $request)
  {
    $request->validate(['date' => 'required|date']);
    $date = $request->query('date');

    $kelas = Kelas::with(['siswa' => function ($q) use ($date) {
      $q->with(['absensi' => function ($q2) use ($date) {
        $q2->whereDate('tanggal', $date);
      }])->orderBy('nama');
    }])->orderBy('nama_kelas')->get();

    $title = "Laporan Absensi - {$date}";

    $pdf = Pdf::loadView('reports.daily_pdf', compact('kelas', 'date', 'title'))
      ->setPaper('a4', 'portrait');

    return $pdf->download("laporan-absensi-{$date}.pdf");
  }
}
