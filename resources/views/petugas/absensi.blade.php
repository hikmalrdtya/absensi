@extends('layouts.app')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8 mt-20">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-3">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-800">
                Absensi Harian Kelas {{ $kelas->nama_kelas }} - {{ now()->translatedFormat('d F Y') }}
            </h2>

            <a href="{{ route('petugas.absensi.editSingle') }}"
                class="bg-yellow-400 mt-3 hover:bg-yellow-500 text-white font-semibold 
                       py-2.5 px-6 rounded-lg transition
                       disabled:opacity-50 disabled:cursor-not-allowed">Edit
                Absensi</a>
        </div>


        {{-- SESSION --}}
        @if (session('success'))
            <div id="server-success" data-message="{{ session('success') }}" hidden></div>
        @endif
        @if (session('error'))
            <div id="server-error" data-message="{{ session('error') }}" hidden></div>
        @endif


        <form action="{{ route('petugas.absensi.store') }}" method="POST" id="absensiForm">
            @csrf

            <div class="grid gap-4">
                @foreach ($siswa as $s)
                    @php $current = $attendances[$s->id] ?? null; @endphp

                    <div
                        class="bg-white rounded-xl shadow-sm p-4 
                            flex flex-col sm:flex-row 
                            sm:items-center sm:justify-between gap-4">

                        <div>
                            <div class="font-semibold text-gray-800">
                                {{ ucfirst($s->nama) }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $s->no_hp_orang_tua }}
                            </div>
                        </div>

                        {{-- RADIO BUTTON MODERN --}}
                        <div class="flex flex-wrap gap-2">
                            @foreach (['Hadir', 'Sakit', 'Izin', 'Alpa'] as $status)
                                <label class="cursor-pointer {{ $disableSave ? 'opacity-60 cursor-not-allowed' : '' }}">

                                    <input type="radio" name="absensi[{{ $s->id }}]" value="{{ $status }}"
                                        class="peer hidden" {{ $current === $status ? 'checked' : '' }}
                                        {{ $disableSave ? 'disabled' : '' }}>

                                    <span
                                        class="
                    px-3 py-1.5 rounded-lg text-sm font-medium border
                    transition-all duration-200
                    border-gray-300 text-gray-600
                    {{ $disableSave ? '' : 'hover:bg-white' }}
                    {{ $disableSave ? '' : 'hover:text-blue-600' }}
                    peer-checked:bg-blue-600
                    peer-checked:text-white
                    peer-checked:border-blue-600
                ">
                                        {{ $status }}
                                    </span>
                                </label>
                            @endforeach
                        </div>

                    </div>
                @endforeach
            </div>


            <div class="mt-6 flex flex-col sm:flex-row justify-between gap-4 items-center">

                <button type="submit" id="btnSubmit"
                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold 
                       py-2.5 px-6 rounded-lg transition
                       disabled:opacity-50 disabled:cursor-not-allowed"
                    {{ $disableSave ? 'disabled' : '' }}>
                    {{ $disableSave ? 'Absensi Disimpan' : 'Simpan Absensi' }}
                </button>

                <div>
                    {{ $siswa->links('vendor.pagination.custom') }}
                </div>

            </div>

        </form>
    </div>


    {{-- TOAST CONTAINER --}}
    <div id="toast-container" class="fixed top-4 right-4 z-50 flex flex-col gap-3"></div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const disableSave = @json($disableSave ?? false);
            const btn = document.getElementById('btnSubmit');

            if (disableSave && btn) {
                btn.disabled = true;
            }

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

            // SESSION TOAST
            const ss = document.getElementById('server-success');
            if (ss?.dataset?.message) {
                showToast('success', ss.dataset.message, 4000);
            }

            const se = document.getElementById('server-error');
            if (se?.dataset?.message) {
                showToast('error', se.dataset.message, 4000);
            }

            // ==============================
            // PAGINATION SAFE LOCAL STORAGE
            // ==============================

            const form = document.getElementById('absensiForm');
            if (!form) return;

            const storageKey = 'absensi_' + '{{ auth()->id() }}' + '_' + '{{ now()->toDateString() }}';

            function saveCurrentPage() {
                let stored = JSON.parse(localStorage.getItem(storageKey) || '{}');

                const radios = form.querySelectorAll('input[type="radio"]');

                radios.forEach(r => {
                    const match = r.name.match(/absensi\[(\d+)\]/);
                    if (!match) return;

                    if (r.checked) {
                        stored[match[1]] = r.value;
                    }
                });

                localStorage.setItem(storageKey, JSON.stringify(stored));
            }

            function loadSaved() {
                const stored = JSON.parse(localStorage.getItem(storageKey) || '{}');

                Object.keys(stored).forEach(id => {
                    const radios = document.getElementsByName('absensi[' + id + ']');
                    radios.forEach(r => {
                        if (r.value === stored[id]) {
                            r.checked = true;
                        }
                    });
                });
            }

            loadSaved();

            form.addEventListener('change', function(e) {
                if (e.target.type === 'radio') {
                    saveCurrentPage();
                }
            });

            document.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;
                if (!link.closest('nav')) return;

                saveCurrentPage();
            });

            form.addEventListener('submit', function(e) {

                if (disableSave) return;

                e.preventDefault();

                saveCurrentPage();

                const stored = JSON.parse(localStorage.getItem(storageKey) || '{}');

                if (Object.keys(stored).length === 0) {
                    showToast('error', 'Belum ada data absensi.');
                    return;
                }

                const fd = new FormData();
                fd.append('_token', '{{ csrf_token() }}');

                Object.entries(stored).forEach(([id, status]) => {
                    fd.append('absensi[' + id + ']', status);
                });

                fetch(form.action, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: fd,
                        credentials: 'same-origin'
                    })
                    .then(res => {
                        if (res.ok) {
                            localStorage.removeItem(storageKey);
                            showToast('success', 'Absensi berhasil disimpan.');
                            setTimeout(() => location.reload(), 1000);
                        } else {
                            showToast('error', 'Gagal menyimpan absensi.');
                        }
                    });

            });

        });
    </script>
@endsection
