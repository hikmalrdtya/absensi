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

        <!-- FILTER -->
        <form method="GET" action="{{ route('admin.siswa.index') }}" class="mb-4 flex items-center gap-3">
            <label for="kelas" class="text-sm text-gray-600">Filter Kelas:</label>
            <select name="kelas" id="kelas" class="px-3 py-2 rounded-lg text-sm w-80">
                <option value="" {{ request('kelas') == null ? 'selected' : '' }}>Semua Kelas</option>
                @foreach ($kelas as $k)
                    <option value="{{ $k->id }}"
                        {{ (string) request('kelas') === (string) $k->id ? 'selected' : '' }}>
                        {{ $k->nama_kelas }}</option>
                @endforeach
            </select>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm">Terapkan</button>

            @if (request('kelas'))
                <a href="{{ route('admin.siswa.index') }}" class="text-sm text-gray-600 underline">Reset</a>
            @endif
        </form>

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
                            <td class="px-6 py-4 font-semibold">{{ ucfirst($s->nama) }}</td>
                            <td class="px-6 py-4">{{ $s->kelas->nama_kelas ?? '-' }}</td>
                            <td class="px-6 py-4">{{ $s->no_hp_orang_tua }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">

                                    <a href="{{ route('admin.siswa.edit', $s->id) }}"
                                        class="p-2 rounded-lg hover:bg-yellow-100 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                            width="24px" fill="#f5d902">
                                            <path
                                                d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.siswa.destroy', $s->id) }}" method="POST">
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
                            <td colspan="5" class="px-6 py-6 text-center text-gray-500">
                                Data siswa belum tersedia
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- PAGINATION -->
        <div class="mt-4">
            {{ $siswa->links('vendor.pagination.custom') }}
        </div>
    </div>
@endsection

@push('scripts')
    <style>
        /* Slightly larger option padding to match screenshot */
        .ts-dropdown .option,
        .tom-select-dropdown .option,
        .ts-dropdown .ts-option {
            padding: .75rem 1rem;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const select = document.querySelector('#kelas');
            if (!select) return;

            const optionCount = Array.from(select.options).filter(o => o.value !== '').length;

            const ts = new TomSelect('#kelas', {
                allowEmptyOption: true,
                dropdownDirection: 'auto'
            });

            function applyDropdownStyle() {
                let wrapper = select.nextElementSibling;
                let dropdown = null;

                if (wrapper) {
                    dropdown = wrapper.querySelector(
                        '.ts-dropdown, .tom-select-dropdown, .dropdown-content, .dropdown');
                }

                if (!dropdown) {
                    dropdown = document.querySelector(
                        '.ts-dropdown, .tom-select-dropdown, .dropdown-content, .dropdown');
                }

                if (dropdown) {
                    if (optionCount > 6) {
                        dropdown.style.maxHeight = '220px';
                        dropdown.style.overflowY = 'auto';
                    } else {
                        dropdown.style.maxHeight = '';
                        dropdown.style.overflowY = '';
                    }
                }
            }

            applyDropdownStyle();

            const control = select.nextElementSibling;
            if (control) {
                control.addEventListener('click', function() {
                    setTimeout(applyDropdownStyle, 30);
                });
            }

            const observer = new MutationObserver(function() {
                applyDropdownStyle();
            });
            observer.observe(document.body, {
                childList: true,
                subtree: true
            });
        });
    </script>
@endpush
