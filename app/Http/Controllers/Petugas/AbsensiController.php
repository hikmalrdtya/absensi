<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Services\SmsService;
use App\Models\SmsLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AbsensiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();
        $today = now()->toDateString();

        // Ambil kelas yang diwalikan user
        $kelas = Kelas::where('wali_id', $user->id)->first();

        // Kalau user tidak punya kelas
        if (!$kelas) {
            return redirect()->back()->with('error', 'Anda tidak memiliki kelas yang diwalikan.');
        }

        $kelasId = $kelas->id;

        // Ambil siswa kelas tersebut saja
        $siswa = Siswa::with('kelas')
            ->where('kelas_id', $kelasId)
            ->orderBy('nama')
            ->paginate(10);

        // Ambil semua siswa id di kelas itu
        $allStudentIds = Siswa::where('kelas_id', $kelasId)->pluck('id');

        // Ambil absensi hari ini untuk kelas itu
        $attendances = Absensi::where('tanggal', $today)
            ->whereIn('siswa_id', $allStudentIds)
            ->get()
            ->keyBy('siswa_id')
            ->map(function ($a) {
                return $a->status;
            })
            ->toArray();

        // Hitung apakah semua sudah diisi
        $totalStudents = $allStudentIds->count();
        $filledCount = Absensi::where('tanggal', $today)
            ->whereIn('siswa_id', $allStudentIds)
            ->count();

        $disableSave = $filledCount >= $totalStudents && $totalStudents > 0;

        return view('petugas.absensi', compact(
            'siswa',
            'attendances',
            'disableSave',
            'kelasId',
            'kelas'
        ));
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
        $user = auth()->user();
        $today = now()->toDateString();

        // if user is wali_kelas, prevent saving when whole class already filled for today
        if ($user->role === 'wali_kelas' && $user->kelas_id) {
            $classStudentIds = Siswa::where('kelas_id', $user->kelas_id)->pluck('id');
            $totalStudents = $classStudentIds->count();
            $filledCount = Absensi::where('tanggal', $today)->whereIn('siswa_id', $classStudentIds)->count();

            if ($filledCount >= $totalStudents && $totalStudents > 0) {
                return back()->with('error', 'Absensi untuk hari ini sudah lengkap sehingga tidak dapat disimpan lagi.');
            }
        }

        // save provided absensi (only for submitted siswa)
        foreach ($data['absensi'] as $siswa_id => $status) {
            $siswa = Siswa::find($siswa_id);
            if (! $siswa) {
                Log::warning('Absensi store: siswa not found', ['siswa_id' => $siswa_id]);
                continue;
            }

            $absensi = Absensi::updateOrCreate(
                ['siswa_id' => $siswa_id, 'tanggal' => $today],
                ['status' => $status, 'petugas_id' => auth()->id()]
            );
            // send SMS notification for absent students (ALPA)
            try {
                if (strtoupper($status) === 'ALPA' && !empty($siswa->no_hp_orang_tua)) {
                    $tanggal = Carbon::parse(now())->locale('id')->isoFormat('D MMMM YYYY');

                    $pesan = "📢 NOTIFIKASI ABSENSI SISWA\n\n";
                    $pesan .= "Yth. Orang tua / wali dari:\n";
                    $pesan .= "Nama   : {$siswa->nama}\n";
                    $pesan .= "Kelas  : " . ($siswa->kelas->nama_kelas ?? '-') . "\n\n";
                    $pesan .= "Kami informasikan bahwa siswa tersebut tidak hadir pada:\n\n";
                    $pesan .= "Tanggal : {$tanggal}\n";
                    $pesan .= "Status  : " . strtoupper($status) . "\n\n";
                    $pesan .= "Mohon perhatian dan konfirmasinya.\n\n";
                    $pesan .= "Terima kasih.\n" . env('APP_SCHOOL_NAME', 'Sekolah');

                    $smsResult = SmsService::send($siswa->no_hp_orang_tua, $pesan, ['siswa_id' => $siswa->id]);

                    $ok = true;
                    if (is_object($smsResult)) {
                        $ok = (property_exists($smsResult, 'sid') && !empty($smsResult->sid));
                    } elseif (is_array($smsResult)) {
                        $ok = array_key_exists('success', $smsResult) ? (bool)$smsResult['success'] : true;
                    } else {
                        $ok = false;
                    }

                    if (! $ok) {
                        Log::warning('Absensi store: failed to send SMS', ['siswa_id' => $siswa->id, 'result' => $smsResult]);
                    }
                }
            } catch (\Throwable $e) {
                Log::warning('Absensi store: exception while sending SMS', ['error' => $e->getMessage(), 'siswa_id' => $siswa->id]);
            }
        }

        // after saving, check for missing students in class and notify
        $missing = [];
        if ($user->role === 'wali_kelas' && $user->kelas_id) {
            $missing = Siswa::where('kelas_id', $user->kelas_id)
                ->whereNotIn('id', Absensi::where('tanggal', $today)->pluck('siswa_id'))
                ->get();
        }

        if (count($missing) > 0) {
            return back()->with('warning', 'Absensi disimpan. Namun masih ada ' . count($missing) . ' siswa yang belum diisi.');
        }

        return back()->with('success', 'Absensi berhasil disimpan.');
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
     * Show form to edit attendance for a single selected siswa.
     */
    public function editSingle(Request $request)
    {
        $user = auth()->user();
        $kelas = Kelas::where('wali_id', $user->id)->first();

        if (! $kelas) {
            return back()->with('error', 'Anda tidak memiliki kelas yang diwalikan.');
        }

        $siswaList = Siswa::where('kelas_id', $kelas->id)->orderBy('nama')->get();

        $siswaId = $request->query('siswa_id');
        $currentStatus = null;
        $selectedSiswa = null;

        if ($siswaId) {
            $selectedSiswa = Siswa::find($siswaId);
            $attendance = Absensi::where('siswa_id', $siswaId)->where('tanggal', now()->toDateString())->first();
            $currentStatus = $attendance->status ?? null;
        }

        return view('petugas.edit', compact('siswaList', 'selectedSiswa', 'currentStatus', 'kelas'));
    }

    /**
     * Update attendance for a single siswa (today).
     */
    public function updateSingle(Request $request)
    {
        $data = $request->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'status' => 'required|string',
        ]);

        $siswa = Siswa::find($data['siswa_id']);
        if (! $siswa) {
            return back()->with('error', 'Siswa tidak ditemukan.');
        }

        $today = now()->toDateString();

        $absensi = Absensi::updateOrCreate(
            ['siswa_id' => $siswa->id, 'tanggal' => $today],
            ['status' => $data['status'], 'petugas_id' => auth()->id()]
        );

        // send SMS if ALPA (reuse same logic as store)
        try {
            if (strtoupper($data['status']) === 'ALPA' && !empty($siswa->no_hp_orang_tua)) {
                $tanggal = Carbon::parse(now())->locale('id')->isoFormat('D MMMM YYYY');

                $pesan = "📢 NOTIFIKASI ABSENSI SISWA\n\n";
                $pesan .= "Yth. Orang tua / wali dari:\n";
                $pesan .= "Nama   : {$siswa->nama}\n";
                $pesan .= "Kelas  : " . ($siswa->kelas->nama_kelas ?? '-') . "\n\n";
                $pesan .= "Kami informasikan bahwa siswa tersebut tidak hadir pada:\n\n";
                $pesan .= "Tanggal : {$tanggal}\n";
                $pesan .= "Status  : " . strtoupper($data['status']) . "\n\n";
                $pesan .= "Mohon perhatian dan konfirmasinya.\n\n";
                $pesan .= "Terima kasih.\n" . env('APP_SCHOOL_NAME', 'Sekolah');

                $smsResult = SmsService::send($siswa->no_hp_orang_tua, $pesan, ['siswa_id' => $siswa->id]);

                $ok = true;
                if (is_object($smsResult)) {
                    $ok = (property_exists($smsResult, 'sid') && !empty($smsResult->sid));
                } elseif (is_array($smsResult)) {
                    $ok = array_key_exists('success', $smsResult) ? (bool)$smsResult['success'] : true;
                } else {
                    $ok = false;
                }

                if (! $ok) {
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Absensi updateSingle: exception while sending SMS', ['error' => $e->getMessage(), 'siswa_id' => $siswa->id]);
        }

        return redirect()->route('petugas.absensi.editSingle', ['siswa_id' => $siswa->id])->with('success', 'Absensi siswa berhasil diperbarui.');
    }

    // removed duplicate sendWhatsApp() to avoid confusion

    /**
     * Send manual SMS message to a siswa's parent.
     */
    public function sendSms(Request $request, $siswa_id)
    {
        $siswa = Siswa::find($siswa_id);
        if (! $siswa) {
            return back()->with('error', 'Siswa tidak ditemukan');
        }

        $absensiToday = Absensi::where('siswa_id', $siswa->id)->where('tanggal', now()->toDateString())->first();
        $status = $absensiToday->status ?? 'ALPA';
        $tanggal = Carbon::parse(now())->locale('id')->isoFormat('D MMMM YYYY');

        $pesan = "📢 NOTIFIKASI ABSENSI SISWA\n\n";
        $pesan .= "Yth. Orang tua / wali dari:\n";
        $pesan .= "Nama   : {$siswa->nama}\n";
        $pesan .= "Kelas  : " . ($siswa->kelas->nama_kelas ?? '-') . "\n\n";
        $pesan .= "Kami informasikan bahwa siswa tersebut tidak hadir pada:\n\n";
        $pesan .= "Tanggal : {$tanggal}\n";
        $pesan .= "Status  : " . strtoupper($status) . "\n\n";
        $pesan .= "Mohon perhatian dan konfirmasinya.\n\n";
        $pesan .= "Terima kasih.\n" . env('APP_SCHOOL_NAME', 'Sekolah');

        $smsResult = SmsService::send($siswa->no_hp_orang_tua, $pesan);

        $ok = true;
        if (is_object($smsResult)) {
            $ok = (property_exists($smsResult, 'sid') && !empty($smsResult->sid));
        } elseif (is_array($smsResult)) {
            if (array_key_exists('success', $smsResult)) {
                $ok = (bool) $smsResult['success'];
            }
        } else {
            $ok = false;
        }

        // Log result to sms_logs table if possible
        try {
            $responseStr = is_string($smsResult) ? $smsResult : (@json_encode($smsResult) ?: (string)$smsResult);

            SmsLog::create([
                'siswa_id' => $siswa->id,
                'phone' => $siswa->no_hp_orang_tua,
                'message' => $pesan,
                'status' => $ok ? 'sent' : 'failed',
                'response' => $responseStr,
                'error' => $ok ? null : $responseStr,
            ]);
        } catch (\Throwable $e) {
            Log::warning('Failed to persist SMS SmsLog', ['error' => $e->getMessage()]);
        }

        if (! $ok) {
            return back()->with('error', 'Gagal mengirim SMS.');
        }

        return back()->with('success', 'SMS berhasil dikirim.');
    }
}
