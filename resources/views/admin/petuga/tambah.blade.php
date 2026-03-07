@extends('layouts.app')

@section('content')
    <div class="p-6 bg-gray-50 min-h-screen grid place-items-center">
        <h1 class="text-2xl font-bold text-gray-800">Tambah Petugas</h1>
        <div class="bg-white rounded-xl shadow p-6 w-4xl">
            <form action="{{ route('admin.petuga.store') }}" method="POST">
                @csrf

                <!-- NAMA -->
                <div class="mb-4">
                    <label class="block text-gray-600 mb-2">Nama</label>
                    <input type="text" name="name"
                        class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- EMAIL -->
                <div class="mb-4">
                    <label class="block text-gray-600 mb-2">Email</label>
                    <input type="email" name="email"
                        class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                </div>

                <!-- PASSWORD -->
                <div class="mb-4">
                    <label class="block text-gray-600 mb-2">Password</label>
                    <input type="password" name="password"
                        class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- PASSWORD CONFIRMATION -->
                <div class="mb-6">
                    <label class="block text-gray-600 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation"
                        class="w-full rounded-lg border px-4 py-2 focus:ring-2 focus:ring-blue-500" required>
                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- BUTTON -->
                <div class="flex gap-3">
                    <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
                        Simpan
                    </button>
                    <a href="{{ route('admin.petuga.index') }}"
                        class="bg-gray-400 text-white px-6 py-2 rounded-lg hover:bg-gray-500">
                        Batal
                    </a>
                </div>
            </form>
        </div>

    </div>
@endsection
