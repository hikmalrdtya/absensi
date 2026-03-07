<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index(Request $request)
  {
    $kelasList = Kelas::orderBy('nama_kelas')->get();

    $query = Absensi::with(['siswa', 'petugas'])->orderBy('tanggal', 'desc');

    $kelasId = $request->query('kelas_id');
    $tanggal = $request->query('tanggal');

    if ($kelasId) {
      $query->whereHas('siswa', function ($q) use ($kelasId) {
        $q->where('kelas_id', $kelasId);
      });
    }

    if ($tanggal) {
      $query->where('tanggal', $tanggal);
    }

    $absensi = $query->paginate(10)->appends($request->only(['kelas_id', 'tanggal']));

    return view('admin.absensi.index', compact('absensi', 'kelasList', 'kelasId', 'tanggal'));
  }

  /**
   * Display the specified resource.
   */
  public function show(Absensi $absensi)
  {
    return view('admin.absensi.show', compact('absensi'));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Absensi $absensi)
  {
    $statuses = ['Hadir', 'Izin', 'Sakit', 'Alpa'];
    return view('admin.absensi.edit', compact('absensi', 'statuses'));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request, Absensi $absensi)
  {
    $request->validate([
      'status' => 'required|string|in:Hadir,Izin,Sakit,Alpa',
      'tanggal' => 'required|date',
    ]);

    $absensi->update([
      'status' => $request->status,
      'tanggal' => $request->tanggal,
    ]);

    return redirect()->route('admin.absensi.index')->with('success', 'Data absensi berhasil diperbarui');
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Absensi $absensi)
  {
    $absensi->delete();
    return redirect()->route('admin.absensi.index')->with('success', 'Data absensi berhasil dihapus');
  }
}
