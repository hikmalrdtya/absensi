@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <!-- TITLE -->
        <h2 class="text-2xl font-bold mb-6">Data Absensi</h2>
        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-2 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-2 text-sm">{{ session('error') }}</div>
        @endif

        <!-- FILTER -->
        <form method="GET" action="{{ route('admin.absensi.index') }}" class="bg-white rounded-xl shadow p-6 mb-6">
            <h3 class="font-semibold mb-4">Pilih Kelas & Tanggal</h3>

            <div class="flex flex-col md:flex-row gap-4 items-center">
                <!-- KELAS -->
                <select name="kelas_id"
                    class="w-full md:w-48 rounded-lg border border-blue-500 px-4 py-2 focus:ring-2 focus:ring-blue-500">
                    <option value="">-- Semua Kelas --</option>
                    @foreach ($kelasList as $k)
                        <option value="{{ $k->id }}" {{ isset($kelasId) && $kelasId == $k->id ? 'selected' : '' }}>
                            {{ $k->nama_kelas }}</option>
                    @endforeach
                </select>

                <!-- TANGGAL -->
                <div class="flex items-center gap-2">
                    <label class="text-gray-600">Tanggal:</label>
                    <input type="date" name="tanggal" value="{{ $tanggal ?? '' }}"
                        class="rounded-lg border border-gray-300 px-3 py-2 bg-white">
                </div>

                <div class="ml-auto flex gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
                    <a href="{{ route('admin.absensi.index') }}" class="px-4 py-2 border rounded">Reset</a>
                </div>
            </div>
        </form>

        <!-- TABLE -->
        <div class="bg-white rounded-xl shadow overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="border-b bg-gray-50">
                    <tr class="text-gray-600">
                        <th class="px-6 py-4 text-left">No</th>
                        <th class="px-6 py-4 text-left">Nama Siswa</th>
                        <th class="px-6 py-4 text-left">No. HP Ortu</th>
                        <th class="px-6 py-4 text-left">Tanggal</th>
                        <th class="px-6 py-4 text-left">Status</th>
                        <th class="px-6 py-4 text-left">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y">
                    @forelse ($absensi as $a)
                        <tr>
                            <td class="px-6 py-4">
                                {{ $loop->iteration + ($absensi->currentPage() - 1) * $absensi->perPage() }}
                            </td>
                            <td class="px-6 py-4 font-semibold">{{ $a->siswa->nama ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $a->siswa->no_hp_orang_tua ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $a->tanggal }}</td>
                            <td class="px-6 py-4">{{ $a->status }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <a href="{{ route('admin.absensi.show', $a) }}" class="text-blue-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#5630ff">
                                            <path
                                                d="M240-40H120q-33 0-56.5-23.5T40-120v-120h80v120h120v80Zm480 0v-80h120v-120h80v120q0 33-23.5 56.5T840-40H720ZM480-220q-120 0-217.5-71T120-480q45-118 142.5-189T480-740q120 0 217.5 71T840-480q-45 118-142.5 189T480-220Zm0-80q88 0 161-48t112-132q-39-84-112-132t-161-48q-88 0-161 48T207-480q39 84 112 132t161 48Zm0-40q58 0 99-41t41-99q0-58-41-99t-99-41q-58 0-99 41t-41 99q0 58 41 99t99 41Zm0-80q-25 0-42.5-17.5T420-480q0-25 17.5-42.5T480-540q25 0 42.5 17.5T540-480q0 25-17.5 42.5T480-420ZM40-720v-120q0-33 23.5-56.5T120-920h120v80H120v120H40Zm800 0v-120H720v-80h120q33 0 56.5 23.5T920-840v120h-80ZM480-480Z" />
                                        </svg></a>
                                    <a href="{{ route('admin.absensi.edit', $a) }}" class="text-green-600"><svg
                                            xmlns="http://www.w3.org/2000/svg" height="22px" viewBox="0 -960 960 960"
                                            width="22px" fill="#f5d902">
                                            <path
                                                d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                        </svg></a>
                                    <form action="{{ route('admin.absensi.destroy', $a) }}" method="POST"
                                        onsubmit="return confirm('Hapus data absensi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600"><svg xmlns="http://www.w3.org/2000/svg"
                                                height="22px" viewBox="0 -960 960 960" width="22px" fill="#f50202">
                                                <path
                                                    d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                                            </svg></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td class="px-6 py-4" colspan="6">Belum ada data absensi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $absensi->links('vendor.pagination.custom') }}
        </div>

    </div>
@endsection
