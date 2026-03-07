@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 grid place-items-center">

    <h1 class="text-2xl font-bold mb-6">Edit Siswa</h1>

    <div class="bg-white rounded-xl shadow p-6 w-4xl">
        <form action="{{ route('admin.siswa.update', $siswa->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- NAMA -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Nama Siswa</label>
                <input type="text" name="nama"
                       class="w-full rounded-lg border px-4 py-2"
                       value="{{ $siswa->nama }}" required>
            </div>

            <!-- KELAS -->
            <div class="mb-4">
                <label class="block mb-1 font-medium">Kelas</label>
                <select name="kelas_id"
                        class="w-full rounded-lg border px-4 py-2" required>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}"
                            {{ $siswa->kelas_id == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- NO HP -->
            <div class="mb-6">
                <label class="block mb-1 font-medium">No. HP Ortu</label>
                <input type="text" name="no_hp_orang_tua"
                       class="w-full rounded-lg border px-4 py-2"
                       value="{{ $siswa->no_hp_orang_tua }}" required>
            </div>

            <!-- BUTTON -->
            <div class="flex gap-3">
                <button class="bg-yellow-500 text-white px-6 py-2 rounded-lg hover:bg-yellow-600">
                    Update
                </button>

                <a href="{{ route('admin.siswa.index') }}"
                   class="px-6 py-2 rounded-lg border hover:bg-gray-100">
                    Kembali
                </a>
            </div>
        </form>
    </div>

</div>
@endsection
