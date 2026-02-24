@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    <h1 class="text-2xl font-bold text-gray-800 mb-6">Edit Kelas</h1>

    <div class="bg-white rounded-xl shadow p-6 max-w-xl">
        <form action="{{ route('admin.kela.update', $kela) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- NAMA KELAS -->
            <div class="mb-4">
                <label class="block text-gray-600 mb-2">Nama Kelas</label>
                <input type="text" name="nama_kelas"
                    value="{{ old('nama_kelas', $kela->nama_kelas) }}"
                    class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                @error('nama_kelas')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <!-- JURUSAN -->
            <div class="mb-4">
                <label class="block text-gray-600 mb-2">Jurusan</label>
                <input type="text" name="jurusan"
                    value="{{ old('jurusan', $kela->jurusan) }}"
                    class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                @error('jurusan')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <!-- WALI KELAS -->
            <div class="mb-6">
                <label class="block text-gray-600 mb-2">Wali Kelas</label>
                <select name="wali_kelas_id"
                    class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Pilih Wali Kelas --</option>

                    @foreach ($petugas as $p)
                        <option value="{{ $p->id }}"
                            {{ old('wali_kelas_id', $kela->wali_kelas_id) == $p->id ? 'selected' : '' }}>
                            {{ $p->name }}
                        </option>
                    @endforeach
                </select>

                @error('wali_kelas_id')
                    <small class="text-red-500">{{ $message }}</small>
                @enderror
            </div>

            <!-- BUTTON -->
            <div class="flex gap-3">
                <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                    Update
                </button>
                <a href="{{ route('admin.kela.index') }}"
                    class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
                    Batal
                </a>
            </div>

        </form>
    </div>

</div>
@endsection