@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Kelola Siswa</h1>

        <a href="{{ route('admin.siswa.create') }}"
           class="flex items-center gap-2 bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            <span class="text-xl leading-none">+</span>
            Tambah Siswa
        </a>
    </div>

    <!-- NOTIF -->
    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-2 text-sm">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-2 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <!-- TABLE -->
    <div class="bg-white rounded-xl shadow overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-100 text-gray-600">
                <tr>
                    <th class="px-6 py-4 text-left">No</th>
                    <th class="px-6 py-4 text-left">Nama</th>
                    <th class="px-6 py-4 text-left">Kelas</th>
                    <th class="px-6 py-4 text-left">No. HP Ortu</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($siswa as $s)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $s->nama }}</td>
                    <td class="px-6 py-4">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                    <td class="px-6 py-4">{{ $s->no_hp_orang_tua }}</td>
                    <td class="px-6 py-4">
                        <div class="flex justify-center gap-4">
                            <!-- EDIT -->
                            <a href="{{ route('admin.siswa.edit', $s->id) }}"
                               class="text-gray-700 hover:text-blue-600"
                               title="Edit">
                                ✏️
                            </a>

                            <!-- DELETE -->
                            <form action="{{ route('admin.siswa.destroy', $s->id) }}"
                                  method="POST"
                                  onsubmit="return confirm('Hapus siswa ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="text-red-600 hover:text-red-800"
                                        title="Hapus">
                                    🗑️
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                        Data siswa belum tersedia
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
