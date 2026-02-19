@extends('layouts.app')

@section('content')
    {{-- Content --}}
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- Welcome text --}}
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">
            Selamat Datang, Petugas
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-white rounded-xl shadow-sm p-6 flex justify-between items-center">
                <div>
                    <p class="text-gray-500 text-sm">
                        Total Kelas
                    </p>

                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        5
                    </h3>
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
                    <p class="text-gray-500 text-sm">
                        Total Siswa
                    </p>
                    <h3 class="text-3xl font-bold text-gray-900 mt-2">
                        10
                    </h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    {{-- icon --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 14l6.16-3.422A12.083 12.083 0 0112 20.055" />
                    </svg>
                </div>
            </div>
        </div>
    </div>
@endsection
