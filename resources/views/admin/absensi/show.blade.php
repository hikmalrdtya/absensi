@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-6">
        <h2 class="text-2xl font-bold mb-6">Detail Absensi</h2>

        <div class="bg-white rounded-xl shadow p-6">
            <div class="mb-4">
                <strong>Nama Siswa:</strong>
                <div>{{ $absensi->siswa->nama ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <strong>No. HP Orang Tua:</strong>
                <div>{{ $absensi->siswa->no_hp_orang_tua ?? '-' }}</div>
            </div>

            <div class="mb-4">
                <strong>Tanggal:</strong>
                <div>{{ $absensi->tanggal }}</div>
            </div>

            <div class="mb-4">
                <strong>Status:</strong>
                <div>{{ $absensi->status }}</div>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('admin.absensi.edit', $absensi) }}" class="text-green-600">Edit</a>
                <a href="{{ route('admin.absensi.index') }}" class="text-gray-600">Kembali</a>
            </div>
        </div>
    </div>
@endsection
