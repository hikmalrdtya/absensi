@extends('layouts.app')

@section('content')
    <div class="p-6 bg-gray-50 min-h-screen">

        <!-- HEADER -->
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Dashboard Admin</h1>

        <!-- CARD GRID -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- TOTAL SISWA -->
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between">
                <div>
                    <p class="text-gray-500">Total Siswa</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $siswa }}</h2>
                </div>
                <div class="bg-blue-100 p-4 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#5630ff">
                        <path
                            d="M480-120 200-272v-240L40-600l440-240 440 240v320h-80v-276l-80 44v240L480-120Zm0-332 274-148-274-148-274 148 274 148Zm0 241 200-108v-151L480-360 280-470v151l200 108Zm0-241Zm0 90Zm0 0Z" />
                    </svg>
                </div>
            </div>

            <!-- TOTAL KELAS -->
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between">
                <div>
                    <p class="text-gray-500">Total Kelas</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $kelas }}</h2>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#049e02">
                        <path
                            d="M560-564v-68q33-14 67.5-21t72.5-7q26 0 51 4t49 10v64q-24-9-48.5-13.5T700-600q-38 0-73 9.5T560-564Zm0 220v-68q33-14 67.5-21t72.5-7q26 0 51 4t49 10v64q-24-9-48.5-13.5T700-380q-38 0-73 9t-67 27Zm0-110v-68q33-14 67.5-21t72.5-7q26 0 51 4t49 10v64q-24-9-48.5-13.5T700-490q-38 0-73 9.5T560-454ZM260-320q47 0 91.5 10.5T440-278v-394q-41-24-87-36t-93-12q-36 0-71.5 7T120-692v396q35-12 69.5-18t70.5-6Zm260 42q44-21 88.5-31.5T700-320q36 0 70.5 6t69.5 18v-396q-33-14-68.5-21t-71.5-7q-47 0-93 12t-87 36v394Zm-40 118q-48-38-104-59t-116-21q-42 0-82.5 11T100-198q-21 11-40.5-1T40-234v-482q0-11 5.5-21T62-752q46-24 96-36t102-12q58 0 113.5 15T480-740q51-30 106.5-45T700-800q52 0 102 12t96 36q11 5 16.5 15t5.5 21v482q0 23-19.5 35t-40.5 1q-37-20-77.5-31T700-240q-60 0-116 21t-104 59ZM280-494Z" />
                    </svg>
                </div>
            </div>

            <!-- TOTAL PETUGAS -->
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between">
                <div>
                    <p class="text-gray-500">Total Petugas</p>
                    <h2 class="text-3xl font-bold mt-2">{{ $petugas }}</h2>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#f2c42c">
                        <path
                            d="M480-480q-51 0-85.5-34.5T360-600q0-50 34.5-85t85.5-35q50 0 85 35t35 85q0 51-35 85.5T480-480Zm0-80q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560ZM240-240v-76q0-21 10.5-39.5T279-385q46-27 96.5-41T480-440q54 0 104.5 14t96.5 41q18 11 28.5 29.5T720-316v76H240Zm160-110q-39 10-74 30h308q-35-20-74-30t-80-10q-41 0-80 10Zm80-250Zm80 280h74-308 234ZM160-80q-33 0-56.5-23.5T80-160v-160h80v160h160v80H160ZM80-640v-160q0-33 23.5-56.5T160-880h160v80H160v160H80ZM640-80v-80h160v-160h80v160q0 33-23.5 56.5T800-80H640Zm160-560v-160H640v-80h160q33 0 56.5 23.5T880-800v160h-80Z" />
                    </svg>
                </div>
            </div>

            <!-- ABSENSI HARI INI -->
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between">
                <div>
                    <p class="text-gray-500">Absensi Hari Ini</p>
                    <h2 class="text-3xl font-bold mt-2">0</h2>
                </div>
                <div class="bg-purple-100 p-4 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#d930ff">
                        <path
                            d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm221.5-198.5Q510-807 510-820t-8.5-21.5Q493-850 480-850t-21.5 8.5Q450-833 450-820t8.5 21.5Q467-790 480-790t21.5-8.5ZM200-200v-560 560Z" />
                    </svg>
                </div>
            </div>

        </div>

        <!-- Charts Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-3">Jumlah Siswa per Kelas</h3>
                <p class="text-sm text-gray-500 mb-4">Distribusi siswa di setiap kelas</p>
                <canvas id="kelasChart" style="max-height:260px;"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-3">Status Absensi</h3>
                <p class="text-sm text-gray-500 mb-4">Rekap seluruh data absensi</p>
                <canvas id="statusChart" style="max-height:260px;"></canvas>
                <div class="mt-4 text-sm text-gray-600 flex flex-wrap gap-4" id="statusLegend"></div>
            </div>
        </div>

        <!-- Lists Row -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-3">Absensi Terbaru</h3>
                <p class="text-sm text-gray-500 mb-4">5 data absensi terakhir</p>

                <div class="space-y-3">
                    @foreach ($recentAbsensi as $a)
                        <div class="border rounded-lg p-4 flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-gray-800">{{ $a->siswa->nama ?? '-' }}</div>
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

            <div class="bg-white rounded-xl shadow p-6">
                <h3 class="text-lg font-semibold mb-3">SMS Terbaru</h3>
                <p class="text-sm text-gray-500 mb-4">Riwayat pengiriman SMS ke orang tua</p>

                <div class="space-y-3">
                    @foreach ($recentSms as $s)
                        <div class="border rounded-lg p-4 flex items-center justify-between">
                            <div>
                                <div class="font-semibold text-gray-800">{{ $s->siswa->nama ?? '-' }}</div>
                                <div class="text-sm text-gray-500">{{ $s->phone }} ·
                                    {{ optional($s->created_at)->toDateString() }}</div>
                            </div>
                            <div>
                                <span
                                    class="px-3 py-1 rounded-full text-sm font-medium bg-blue-600 text-white">{{ $s->status ?? '' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Chart.js CDN + render -->
        <!-- Chart.js loaded via npm and bundled by Vite -->
        <script>
            (function() {
                const kelasLabels = @json($kelasLabels ?? []);
                const kelasCounts = @json($kelasCounts ?? []);
                const statusCounts = @json($statusCounts ?? []);

                const kelasCtx = document.getElementById('kelasChart');
                if (kelasCtx) {
                    new Chart(kelasCtx.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: kelasLabels,
                            datasets: [{
                                label: 'Jumlah Siswa',
                                data: kelasCounts,
                                backgroundColor: 'rgba(39, 78, 237, 0.8)'
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false
                        }
                    });
                }

                const statusCtx = document.getElementById('statusChart');
                if (statusCtx) {
                    const labels = Object.keys(statusCounts);
                    const data = labels.map(k => statusCounts[k]);
                    const colors = {
                        'Hadir': '#10B981',
                        'Sakit': '#F59E0B',
                        'Izin': '#3B82F6',
                        'Alpa': '#EF4444'
                    };
                    const bg = labels.map(l => colors[l] || '#9CA3AF');

                    new Chart(statusCtx.getContext('2d'), {
                        type: 'doughnut',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: data,
                                backgroundColor: bg
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            cutout: '70%'
                        }
                    });

                    const legend = document.getElementById('statusLegend');
                    if (legend) {
                        labels.forEach((lab, i) => {
                            const el = document.createElement('div');
                            el.className = 'flex items-center gap-2';
                            el.innerHTML =
                                `<span class="w-3 h-3 rounded-full" style="background:${bg[i]}"></span><span>${lab}: ${data[i]}</span>`;
                            legend.appendChild(el);
                        });
                    }
                }
            })();
        </script>
    </div>
@endsection
