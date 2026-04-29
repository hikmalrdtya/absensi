@extends('layouts.app')

@section('content')
    <div class="p-6 bg-gray-50 min-h-screen">
        <h1 class="text-2xl font-bold mb-6">Laporan Absensi (Petugas)</h1>

        <div class="bg-white rounded-xl shadow p-6 w-full max-w-md">
            <form action="{{ route('petugas.laporan.absensi.pdf') }}" method="GET">
                <label class="block mb-2">Tanggal</label>
                <input type="date" name="date" value="{{ $date }}" class="w-full rounded border px-3 py-2 mb-4">

                <div class="flex gap-3">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Download PDF</button>
                    <a href="{{ route('petugas.dashboard') }}" class="px-4 py-2 border rounded">Kembali</a>
                </div>
            </form>
        </div>
    </div>
@endsection
