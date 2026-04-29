@extends('layouts.app')

@section('content')
    {{-- Content --}}
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- Welcome text --}}
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">
            Selamat Datang, Petugas
        </h2>

        @php
            $userId = auth()->id();
            $totalKelas = \App\Models\Kelas::where('wali_id', $userId)->count();
            $totalSiswa = \App\Models\Siswa::whereHas('kelas', function ($q) use ($userId) {
                $q->where('wali_id', $userId);
            })->count();
            $today = \Carbon\Carbon::now()->toDateString();
            $absensiToday = \App\Models\Absensi::where('tanggal', $today)
                ->whereHas('siswa.kelas', function ($q) use ($userId) {
                    $q->where('wali_id', $userId);
                })
                ->count();
            $missingCount = max(0, $totalSiswa - $absensiToday);
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Total Kelas</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalKelas }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="text-green-600" height="24px" viewBox="0 -960 960 960"
                        width="24px" fill="green">
                        <path
                            d="m590-488 160-92-160-92-160 92 160 92Zm0 122 110-64v-84l-110 64-110-64v84l110 64ZM480-480Zm320 320H600q0-20-1.5-40t-4.5-40h206v-480H160v46q-20-3-40-4.5T80-680v-40q0-33 23.5-56.5T160-800h640q33 0 56.5 23.5T880-720v480q0 33-23.5 56.5T800-160Zm-720 0v-120q50 0 85 35t35 85H80Zm200 0q0-83-58.5-141.5T80-360v-80q117 0 198.5 81.5T360-160h-80Zm160 0q0-75-28.5-140.5t-77-114q-48.5-48.5-114-77T80-520v-80q91 0 171 34.5T391-471q60 60 94.5 140T520-160h-80Z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSiswa }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" width="24px" viewBox="0 -960 960 960"
                        class="text-blue-600" fill="blue">
                        <path
                            d="M480-120 200-272v-240L40-600l440-240 440 240v320h-80v-276l-80 44v240L480-120Zm0-332 274-148-274-148-274 148 274 148Zm0 241 200-108v-151L480-360 280-470v151l200 108Zm0-241Zm0 90Zm0 0Z" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Absensi Hari Ini</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $absensiToday }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $missingCount }} siswa belum diisi</p>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-yellow-600" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8h.01" />
                    </svg>
                </div>
            </div>
        </div>

        {{-- Charts & Lists --}}
        @php
            use App\Models\Absensi;
            use Illuminate\Support\Facades\DB;

            // per-hari (hari ini) status counts for this petugas's kelas
$statusCounts = Absensi::whereDate('tanggal', $today)
    ->whereHas('siswa.kelas', function ($q) use ($userId) {
        $q->where('wali_id', $userId);
    })
    ->select('status', DB::raw('count(*) as total'))
    ->groupBy('status')
    ->get()
    ->pluck('total', 'status')
    ->toArray();

// Ensure keys exist
$statuses = ['Hadir', 'Sakit', 'Izin', 'Alpa'];
$statusCounts = array_merge(array_fill_keys($statuses, 0), $statusCounts);

$recent = Absensi::with('siswa')
    ->whereHas('siswa.kelas', function ($q) use ($userId) {
        $q->where('wali_id', $userId);
    })
    ->orderBy('tanggal', 'desc')
                ->limit(5)
                ->get();
        @endphp

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-3">Rekap Status Absensi Saya Hari Ini</h3>
                <p class="text-sm text-gray-500 mb-4">{{ now()->translatedFormat('d F Y') }}</p>
                <canvas id="petugasStatusChart" style="max-height:260px;"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-3">Absensi Terbaru</h3>
                <p class="text-sm text-gray-500 mb-4">5 catatan terakhir Anda</p>

                <div class="space-y-3">
                    @foreach ($recent as $a)
                        <div class="border rounded-lg p-4 flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-gray-800">{{ ucfirst($a->siswa->nama ?? '-') }}</div>
                                <div class="text-sm text-gray-500">{{ $a->siswa->kelas->nama_kelas ?? '-' }} ·
                                    {{ $a->tanggal }}</div>
                            </div>
                            <div>
                                @php $st = ucfirst($a->status ?? ''); @endphp
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium {{ strtolower($st) == 'alpa' ? 'bg-red-500 text-white' : (strtolower($st) == 'hadir' ? 'bg-blue-600 text-white' : 'bg-gray-200 text-gray-800') }}">{{ $st }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Chart.js CDN + render for petugas --}}
        <!-- Chart.js loaded via npm and bundled by Vite -->
        <script>
            (function waitForChart() {
                function init() {
                    const ctx = document.getElementById('petugasStatusChart');
                    if (!ctx) return;

                    const labels = @json(array_keys($statusCounts));
                    const data = @json(array_values($statusCounts));
                    const colors = ['#2563EB', '#F59E0B', '#3B82F6', '#EF4444'];

                    new Chart(ctx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: 'Jumlah',
                                data: data,
                                backgroundColor: colors
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            }
                        }
                    });
                }

                if (typeof Chart !== 'undefined') {
                    init();
                } else {
                    const id = setInterval(function() {
                        if (typeof Chart !== 'undefined') {
                            clearInterval(id);
                            init();
                        }
                    }, 50);
                }
            })();
        </script>
    </div>
@endsection
