@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Kelas</h1>
        <a href="{{ route('admin.kela.create') }}"
            class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Kelas
        </a>
    </div>

    {{-- NOTIFIKASI --}}
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
                    <th class="px-6 py-4 text-left">Nama Kelas</th>
                    <th class="px-6 py-4 text-left">Jurusan</th>
                    <th class="px-6 py-4 text-left">Wali Kelas</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>

            <tbody class="divide-y">
                @forelse ($kelas as $k)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">{{ $loop->iteration }}</td>

                        <td class="px-6 py-4 font-semibold">
                            {{ $k->nama_kelas }}
                        </td>

                        <td class="px-6 py-4">
                            {{ $k->jurusan }}
                        </td>

                        {{-- WALI KELAS (USER PETUGAS) --}}
                        <td class="px-6 py-4">
                            @if ($k->waliKelas)
                                <span class="font-medium text-gray-800">
                                    {{ $k->waliKelas->name }}
                                </span>
                            @else
                                <span class="text-gray-400 italic">
                                    Belum ditentukan
                                </span>
                            @endif
                        </td>

                        {{-- AKSI --}}
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="{{ route('admin.kela.edit', $k->id) }}"
                                class="bg-yellow-400 text-white px-3 py-1 rounded-lg hover:bg-yellow-500">
                                Edit
                            </a>

                            <form action="{{ route('admin.kela.destroy', $k->id) }}"
                                method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus kelas ini?')"
                                    class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-400">
                            Data kelas belum tersedia
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection