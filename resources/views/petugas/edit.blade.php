@extends('layouts.app')

@section('content')
    <style>
        .ts-dropdown .ts-dropdown-content {
            max-height: 200px;
            overflow-y: auto;
        }
    </style>

    <div class="p-4 sm:p-6 lg:p-8 mt-20">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                Edit Absensi (Pilih Siswa)
            </h2>

            <a href="{{ route('petugas.absensi.index') }}"
                class="bg-gray-200 mt-3 hover:bg-gray-300 text-gray-800 font-semibold py-2.5 px-6 rounded-lg transition">
                Kembali
            </a>
        </div>

        {{-- SESSION --}}
        @if (session('success'))
            <div id="server-success" data-message="{{ session('success') }}" hidden></div>
        @endif

        @if (session('error'))
            <div id="server-error" data-message="{{ session('error') }}" hidden></div>
        @endif


        <div class="bg-white rounded-xl shadow-sm p-4">
            <form action="{{ route('petugas.absensi.updateSingle') }}" method="POST" id="editAbsensiForm">
                @csrf

                <div class="grid gap-4">

                    {{-- SELECT SISWA --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Siswa
                        </label>

                        <select id="siswaSelect" name="siswa_id"
                            class="w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">-- Pilih Siswa --</option>

                            @foreach ($siswaList as $s)
                                <option value="{{ $s->id }}" {{ $selectedSiswa?->id == $s->id ? 'selected' : '' }}>
                                    {{ ucfirst($s->nama) }} - {{ $s->no_hp_orang_tua ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>


                    {{-- DATA SISWA --}}
                    @if ($selectedSiswa)
                        <div>

                            <div class="font-semibold text-gray-800">
                                {{ ucfirst($selectedSiswa->nama) }}
                            </div>

                            <div class="text-sm text-gray-500 mb-2">
                                {{ $selectedSiswa->no_hp_orang_tua ?? '-' }}
                            </div>


                            {{-- RADIO BUTTON --}}
                            <div class="flex flex-wrap gap-2">

                                @foreach (['Hadir', 'Sakit', 'Izin', 'Alpa'] as $status)
                                    <label class="cursor-pointer">

                                        <input type="radio" name="status" value="{{ $status }}"
                                            class="hidden peer" {{ $currentStatus === $status ? 'checked' : '' }}>

                                        <span
                                            class="px-3 py-1.5 rounded-lg text-sm font-medium border
                                        transition-all duration-200
                                        border-gray-300 text-gray-600
                                        peer-checked:bg-blue-600
                                        peer-checked:text-white
                                        peer-checked:border-blue-600">
                                            {{ $status }}
                                        </span>

                                    </label>
                                @endforeach

                            </div>

                        </div>
                    @endif

                </div>


                {{-- BUTTON --}}
                <div class="mt-6 flex items-center gap-3">

                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 px-6 rounded-lg transition">
                        Simpan
                    </button>

                    <a href="{{ route('petugas.absensi.index') }}" class="text-sm text-gray-500">
                        Batal
                    </a>

                </div>

            </form>
        </div>

    </div>


    {{-- TOAST --}}
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-3"></div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {

            new TomSelect("#siswaSelect", {
                maxOptions: null,
                dropdownParent: "body"
            });

            const ss = document.getElementById('server-success');
            const se = document.getElementById('server-error');

            function showToast(type, message, timeout = 3000) {

                const container = document.getElementById('toast-container');

                const toast = document.createElement('div');

                toast.className =
                    "px-4 py-3 rounded-lg shadow-lg text-white text-sm min-w-[250px] transition-all duration-300 opacity-0 translate-x-5";

                let bg = "bg-blue-600";

                if (type === "success") bg = "bg-green-600";
                if (type === "error") bg = "bg-red-600";

                toast.classList.add(bg);
                toast.innerHTML = message;

                container.appendChild(toast);

                setTimeout(() => {
                    toast.classList.remove("opacity-0", "translate-x-5");
                    toast.classList.add("opacity-100", "translate-x-0");
                }, 50);

                setTimeout(() => {
                    toast.classList.add("opacity-0", "translate-x-5");
                    setTimeout(() => toast.remove(), 300);
                }, timeout);
            }

            if (ss?.dataset?.message) showToast('success', ss.dataset.message, 4000);
            if (se?.dataset?.message) showToast('error', se.dataset.message, 4000);


            // SELECT SISWA CHANGE
            const select = document.getElementById('siswaSelect');

            if (select) {

                select.addEventListener('change', function() {

                    const val = this.value;

                    const url = new URL(window.location.href);

                    if (val)
                        url.searchParams.set('siswa_id', val);
                    else
                        url.searchParams.delete('siswa_id');

                    window.location.href = url.toString();

                });

            }

        });
    </script>

@endsection
