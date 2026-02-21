@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- TITLE -->
        <h2 class="text-2xl font-bold mb-6">Input Absensi</h2>
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-2 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-2 text-sm">{{ session('error') }}</div>
        @endif

        <!-- FILTER -->
        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="font-semibold mb-4">Pilih Kelas & Tanggal</h3>

            <div class="flex flex-col md:flex-row gap-4">
                <!-- KELAS -->
                <select class="w-full md:w-48 rounded-lg border border-blue-500 px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option>X-A</option>
                    <option>X-B</option>
                    <option>XI-A</option>
                </select>

                <!-- TANGGAL -->
                <div class="flex items-center rounded-lg border border-gray-300 px-4 py-2 bg-gray-50">
                    <span class="text-gray-600">Tanggal:</span>
                    <span class="ml-2 font-semibold">2026-02-15</span>
                </div>
            </div>
        </div>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="border-b bg-gray-50">
                    <tr class="text-gray-600">
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Nama Siswa</th>
                        <th class="px-6 py-4 text-left">No. HP Ortu</th>
                        <th class="px-6 py-4 text-left">Status</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    <tr>
                        <td class="px-6 py-4">1</td>
                        <td class="px-6 py-4 font-semibold">Ahmad Fauzi</td>
                        <td class="px-6 py-4">081234567890</td>
                        <td class="px-6 py-4">
                            <select class="rounded-lg border border-gray-300 px-4 py-2 w-40">
                                <option>Pilih</option>
                                <option>Hadir</option>
                                <option>Izin</option>
                                <option>Sakit</option>
                                <option>Alpa</option>
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td class="px-6 py-4">2</td>
                        <td class="px-6 py-4 font-semibold">Dewi Lestari</td>
                        <td class="px-6 py-4">081234567891</td>
                        <td class="px-6 py-4">
                            <select class="rounded-lg border border-gray-300 px-4 py-2 w-40">
                                <option>Pilih</option>
                                <option>Hadir</option>
                                <option>Izin</option>
                                <option>Sakit</option>
                                <option>Alpa</option>
                            </select>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

    </div>
@endsection
