@extends('layouts.app')

@section('content')
    <div class="p-4 sm:p-6 lg:p-8">

        {{-- Title --}}
        <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-6">
            Input Absensi
        </h2>


        {{-- Card Pilih kelas --}}
        <div class="bg-white rounded-xl border shadow-sm p-6 mb-6">

            <h3 class="font-semibold text-gray-800 mb-4">
                Pilih Kelas & Tanggal
            </h3>

            <div class="flex flex-col sm:flex-row gap-4">

                {{-- Select kelas --}}
                <select id="kelasSelect"
                    class="w-full sm:w-64 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

                    <option value="">Pilih Kelas</option>
                    <option value="1">X-A</option>
                    <option value="2">X-B</option>
                    <option value="3">XI-A</option>

                </select>


                {{-- Tanggal --}}
                <input type="date" value="{{ date('Y-m-d') }}"
                    class="w-full sm:w-64 border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 focus:outline-none">

            </div>

        </div>



        {{-- Card daftar siswa --}}
        <div id="siswaCard" class="bg-white rounded-xl border shadow-sm overflow-hidden hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-50 border-b">

                        <tr class="text-left text-gray-600">

                            <th class="px-6 py-4 font-semibold">No</th>
                            <th class="px-6 py-4 font-semibold">Nama Siswa</th>
                            <th class="px-6 py-4 font-semibold">No. HP Ortu</th>
                            <th class="px-6 py-4 font-semibold">Status</th>

                        </tr>

                    </thead>


                    <tbody class="divide-y">
                        <tr>

                            <td class="px-6 py-4">1</td>

                            <td class="px-6 py-4 font-medium">
                                Ahmad Fauzi
                            </td>

                            <td class="px-6 py-4">
                                081234567890
                            </td>

                            <td class="px-6 py-4">
                                <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih</option>
                                    <option value="hadir">Hadir</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="alpha">Alpha</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4">2</td>

                            <td class="px-6 py-4 font-medium">
                                Dewi Lestari
                            </td>

                            <td class="px-6 py-4">
                                081234567891
                            </td>

                            <td class="px-6 py-4">
                                <select class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                                    <option value="">Pilih</option>
                                    <option value="hadir">Hadir</option>
                                    <option value="izin">Izin</option>
                                    <option value="sakit">Sakit</option>
                                    <option value="alpha">Alpha</option>
                                </select>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('kelasSelect').addEventListener('change', function() {

            const siswaCard = document.getElementById('siswaCard');

            if (this.value === "") {

                siswaCard.classList.add('hidden');

            } else {

                siswaCard.classList.remove('hidden');

            }

        });
    </script>
@endsection
