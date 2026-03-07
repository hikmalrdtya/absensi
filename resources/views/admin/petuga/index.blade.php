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

        <!-- TABLE for md+ -->
        <div class="hidden md:block bg-white rounded-xl shadow overflow-hidden">
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
                            <td class="px-6 py-4 text-center"><span
                                    class="text-blue-600 text-xs font-semibold px-4 py-2 rounded">{{ ucfirst($p->role) }}</span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">

                                    <a href="{{ route('admin.petuga.edit', $p->id) }}"
                                        class="p-2 rounded-lg hover:bg-yellow-100 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#f5d902">
                                            <path
                                                d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.petuga.destroy', $p->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button onclick="return confirm('Hapus petugas ini?')"
                                            class="p-2 rounded-lg hover:bg-red-100 transition">
                                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                                width="24px" fill="#f50202">
                                                <path
                                                    d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                            </svg>
                                        </button>

                                    </form>

                                </div>
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

        <!-- Mobile list for small screens -->
        <div class="md:hidden space-y-3">
            @forelse ($petuga as $p)
                <div class="bg-white rounded-xl shadow p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1">
                            <div class="font-semibold text-gray-800">{{ $p->name }}</div>
                            <div class="text-sm text-gray-500">{{ $p->email }}</div>
                            <div class="mt-2">
                                <span
                                    class="inline-block text-blue-600 text-xs font-semibold px-3 py-1 rounded">{{ ucfirst($p->role) }}</span>
                            </div>
                        </div>

                        <div class="flex items-start gap-2">
                            <a href="{{ route('admin.petuga.edit', $p->id) }}"
                                class="p-2 rounded-lg hover:bg-yellow-100 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960"
                                    width="22px" fill="#f5d902">
                                    <path
                                        d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                </svg>
                            </a>

                            <form action="{{ route('admin.petuga.destroy', $p->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button onclick="return confirm('Hapus petugas ini?')"
                                    class="p-2 rounded-lg hover:bg-red-100 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960"
                                        width="22px" fill="#f50202">
                                        <path
                                            d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500">Data hidup</div>
            @endforelse
        </div>

        <div>
            {{ $petuga->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection
