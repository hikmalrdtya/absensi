@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto px-4 py-6">

        <h2 class="text-2xl font-bold mb-6">Edit Absensi</h2>

        @if ($errors->any())
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-2 text-sm">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="bg-white rounded-xl shadow p-6">
            <form action="{{ route('admin.absensi.update', $absensi) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Nama Siswa</label>
                    <div class="mt-1 text-gray-900">{{ $absensi->siswa->nama ?? '-' }}</div>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ old('tanggal', $absensi->tanggal) }}"
                        class="mt-1 block w-full rounded-md border-gray-300" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700">Status</label>
                    <select name="status" class="mt-1 block w-48 rounded-md border-gray-300" required>
                        @foreach ($statuses as $s)
                            <option value="{{ $s }}"
                                {{ old('status', $absensi->status) == $s ? 'selected' : '' }}>{{ $s }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-center gap-3">
                    <button class="bg-blue-600 text-white px-4 py-2 rounded">Simpan</button>
                    <a href="{{ route('admin.absensi.index') }}" class="text-gray-600">Batal</a>
                </div>
            </form>
        </div>

    </div>
@endsection
