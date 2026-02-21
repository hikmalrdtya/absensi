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
                    <h2 class="text-3xl font-bold mt-2">10</h2>
                </div>
                <div class="bg-blue-100 p-4 rounded-lg">
                    <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 14l6.16-3.422A12.083 12.083 0 0112 21.5a12.083 12.083 0 01-6.16-10.922L12 14z" />
                    </svg>
                </div>
            </div>

            <!-- TOTAL KELAS -->
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between">
                <div>
                    <p class="text-gray-500">Total Kelas</p>
                    <h2 class="text-3xl font-bold mt-2">5</h2>
                </div>
                <div class="bg-green-100 p-4 rounded-lg">
                    <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 10l9-7 9 7v10a1 1 0 01-1 1h-4a1 1 0 01-1-1V14H9v6a1 1 0 01-1 1H4a1 1 0 01-1-1z" />
                    </svg>
                </div>
            </div>

            <!-- TOTAL PETUGAS -->
            <div class="bg-white rounded-xl shadow-sm p-6 flex items-center justify-between">
                <div>
                    <p class="text-gray-500">Total Petugas</p>
                    <h2 class="text-3xl font-bold mt-2">2</h2>
                </div>
                <div class="bg-yellow-100 p-4 rounded-lg">
                    <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-4-4h-1" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 20H4v-2a4 4 0 014-4h1" />
                        <circle cx="12" cy="7" r="4" />
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
                    <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <rect x="9" y="2" width="6" height="4" rx="1" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v14a2 2 0 01-2 2H6a2 2 0 01-2-2z" />
                    </svg>
                </div>
            </div>

        </div>
    </div>
@endsection
