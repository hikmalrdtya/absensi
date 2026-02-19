<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = Siswa::with('kelas')->orderBy('nama')->get();
        $today = now()->toDateString();
        $attendances = Absensi::where('tanggal', $today)->get()->keyBy('siswa_id')->map(function ($a) {
            return $a->status;
        })->toArray();

        return view('petugas.absensi', compact('siswa', 'attendances'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'absensi' => 'required|array',
        ]);

        foreach ($data['absensi'] as $siswa_id => $status) {
            $siswa = Siswa::find($siswa_id);
            if (! $siswa) {
                Log::warning('Absensi store: siswa not found', ['siswa_id' => $siswa_id]);
                continue;
            }

            // create or update today's attendance (prevent unique constraint error)
            $absensi = Absensi::updateOrCreate(
                ['siswa_id' => $siswa_id, 'tanggal' => now()->toDateString()],
                ['status' => $status, 'petugas_id' => auth()->id()]
            );

            // kirim SMS jika tidak hadir
            if ($status !== 'Hadir') {
                $pesan = "Yth. Orang tua dari {$siswa->nama}, "
                    . "Anak anda hari ini tidak masuk sekolah. "
                    . "Status: {$status} "
                    . "Tanggal: " . now()->format('d-m-Y');

                $smsResult = SmsService::send($siswa->no_hp_orang_tua, $pesan, $siswa->id);
                if (!is_array($smsResult) || ($smsResult['success'] ?? false) === false) {
                    $detail = is_array($smsResult) ? json_encode($smsResult) : (string)$smsResult;
                    Log::error('Failed to send SMS for siswa', ['siswa_id' => $siswa_id, 'sms' => $smsResult]);
                    return back()->with('error', 'Gagal mengirim SMS: ' . $detail);
                }
            }
        }

        return back()->with('success', 'Absensi berhasil disimpan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Send manual SMS to a siswa's parent.
     */
    public function sendSms(Request $request, $siswa_id)
    {
        $siswa = Siswa::find($siswa_id);
        if (! $siswa) {
            return back()->with('error', 'Siswa tidak ditemukan');
        }

        $pesan = "Yth. Orang tua dari {$siswa->nama}, "
            . "Ini pemberitahuan dari sekolah. Tanggal: " . now()->format('d-m-Y');

        $smsResult = SmsService::send($siswa->no_hp_orang_tua, $pesan);

        if (!is_array($smsResult) || ($smsResult['success'] ?? false) === false) {
            return back()->with('error', 'Gagal mengirim SMS.');
        }

        return back()->with('success', 'SMS berhasil dikirim.');
    }
}
