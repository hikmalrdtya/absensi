@extends('layouts.app')

@section('content')
    {{-- Content --}}
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- Welcome text --}}
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">
            Selamat Datang, Petugas
        </h2>

        @php
            $totalKelas = \App\Models\Kelas::count();
            $totalSiswa = \App\Models\Siswa::count();
            $today = \Carbon\Carbon::now()->toDateString();
            $absensiToday = \App\Models\Absensi::where('tanggal', $today)->count();
            $missingCount = max(0, $totalSiswa - $absensiToday);
            $missingList = \App\Models\Siswa::whereNotIn(
                'id',
                \App\Models\Absensi::where('tanggal', $today)->pluck('siswa_id'),
            )
                ->limit(5)
                ->get();
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Total Kelas</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalKelas }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2" />
                    </svg>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">Total Siswa</p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">{{ $totalSiswa }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422A12.083 12.083 0 0112 20.055" />
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

        <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h4 class="font-semibold mb-3">Preview: Siswa Belum Diisi (maks 5)</h4>
                @if ($missingList->isEmpty())
                    <p class="text-sm text-gray-500">Semua siswa sudah diisi hari ini.</p>
                @else
                    <ul class="divide-y">
                        @foreach ($missingList as $m)
                            <li class="py-2 flex justify-between items-center">
                                <div>
                                    <div class="font-medium">{{ ucfirst($m->nama) }}</div>
                                    <div class="text-sm text-gray-500">{{ $m->kelas->nama_kelas ?? '-' }}</div>
                                </div>
                                <a href="{{ route('petugas.absensi.index') }}" class="text-sm text-blue-600">Isi</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            <div class="bg-white rounded-xl shadow-sm p-6">
                <h4 class="font-semibold mb-3">Quick Links</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="{{ route('petugas.absensi.index') }}" class="text-blue-600">Kelola Absensi</a></li>
                    <li><a href="{{ route('petugas.dashboard') }}" class="text-blue-600">Lihat Laporan</a></li>
                </ul>
            </div>
        </div>
    </div>
@endsection
