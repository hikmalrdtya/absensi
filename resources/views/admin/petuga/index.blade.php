@extends('layouts.app')

@section('content')
<div class="p-6 bg-gray-50 min-h-screen">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Data Petugas</h1>
        <a href="{{ route('admin.petuga.create') }}"
           class="bg-blue-600 text-white px-5 py-2 rounded-lg hover:bg-blue-700 transition">
            + Tambah Petugas
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
                    <th class="px-6 py-4 text-left">Email</th>
                    <th class="px-6 py-4 text-center">Role</th>
                    <th class="px-6 py-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y">
                @forelse ($petuga as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-6 py-4">{{ $loop->iteration }}</td>
                    <td class="px-6 py-4 font-semibold">{{ $p->name }}</td>
                    <td class="px-6 py-4">{{ $p->email }}</td>
                    <td class="px-6 py-4 text-center"><span class="bg-blue-100 text-blue-800 text-xs font-semibold px-2 py-1 rounded">{{ ucfirst($p->role) }}</span></td>
                    <td class="px-6 py-4 text-center space-x-2">
                        <a href="{{ route('admin.petuga.edit', $p->id) }}"
                           class="bg-yellow-400 text-white px-3 py-1 rounded-lg hover:bg-yellow-500">
                            Edit
                        </a>

                        <form action="{{ route('admin.petuga.destroy', $p->id) }}"
                              method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus petugas ini?')"
                                class="bg-red-500 text-white px-3 py-1 rounded-lg hover:bg-red-600">
                                Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-4 text-center text-gray-500">Data hidup</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
