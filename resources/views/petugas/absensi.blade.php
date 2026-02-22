@extends('layouts.app')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        <h2 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6">Absensi Harian</h2>

        @if (session('success'))
            <div class="mb-4 rounded-lg bg-green-100 text-green-700 px-4 py-2 text-sm">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-2 text-sm">{{ session('error') }}</div>
        @endif

        <form action="{{ route('petugas.absensi.store') }}" method="POST" class="space-y-4">
            @csrf

            @if (isset($missing) && count($missing) > 0)
                <div id="absensi-missing-toast" class="mb-4 rounded-lg bg-yellow-100 text-yellow-800 px-4 py-2 text-sm">
                    Terdapat {{ count($missing) }} siswa yang belum diisi kehadirannya. Silakan lengkapi.
                </div>
            @endif

            <div class="grid grid-cols-1 gap-4">
                @foreach ($siswa as $s)
                    <div class="bg-white rounded-lg p-4 flex items-center justify-between">
                        <div>
                            <div class="font-semibold">{{ ucfirst($s->nama) }} <span
                                    class="text-sm text-gray-500">({{ $s->kelas->nama_kelas ?? '-' }})</span></div>
                            <div class="text-sm text-gray-500">{{ $s->no_hp_orang_tua }}</div>
                        </div>

                        <div class="flex items-center gap-4">
                            <div class="flex items-center gap-2">
                                @php $current = $attendances[$s->id] ?? null; @endphp
                                <label class="text-sm">Hadir</label>
                                <input type="radio" name="absensi[{{ $s->id }}]" value="Hadir"
                                    {{ $current === 'Hadir' ? 'checked' : '' }} required>
                                <label class="text-sm">Sakit</label>
                                <input type="radio" name="absensi[{{ $s->id }}]" value="Sakit"
                                    {{ $current === 'Sakit' ? 'checked' : '' }}>
                                <label class="text-sm">Izin</label>
                                <input type="radio" name="absensi[{{ $s->id }}]" value="Izin"
                                    {{ $current === 'Izin' ? 'checked' : '' }}>
                                <label class="text-sm">Alpa</label>
                                <input type="radio" name="absensi[{{ $s->id }}]" value="Alpa"
                                    {{ $current === 'Alpa' ? 'checked' : '' }}>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-4 rounded"
                    @if (isset($disableSave) && $disableSave) disabled aria-disabled="true" style="opacity:0.6;cursor:not-allowed;" @endif>
                    Simpan Absensi
                </button>
            </div>

            <div class="mt-4">
                {{ $siswa->links('vendor.pagination.custom') }}
            </div>
        </form>
    </div>
@endsection
