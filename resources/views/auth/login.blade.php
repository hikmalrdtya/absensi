<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">

        <!-- ICON -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
               <svg xmlns="http://www.w3.org/2000/svg" height="35px" viewBox="0 -960 960 960" width="35px" fill="#e3e3e3"><path d="M480-120 200-272v-240L40-600l440-240 440 240v320h-80v-276l-80 44v240L480-120Zm0-332 274-148-274-148-274 148 274 148Zm0 241 200-108v-151L480-360 280-470v151l200 108Zm0-241Zm0 90Zm0 0Z"/></svg>
            </div>
        </div>

        <!-- TITLE -->
        <h1 class="text-2xl font-bold text-center text-gray-800">
            Sistem Absensi Siswa
        </h1>
        <p class="text-center text-gray-500 mt-1 mb-6">
            Masuk dengan akun Anda
        </p>

        <!-- ❌ ERROR LOGIN -->
        @if (session('error'))
            <div class="mb-4 rounded-lg bg-red-100 text-red-700 px-4 py-2 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <!-- FORM -->
        <form action="{{ url('/login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- EMAIL -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" placeholder="Masukkan email"
                    class="w-full rounded-lg px-4 py-2 border
                       @error('email') border-red-500 @else border-gray-300 @enderror
                       focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('email')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" placeholder="Masukkan password"
                    class="w-full rounded-lg px-4 py-2 border
                       @error('password') border-red-500 @else border-gray-300 @enderror
                       focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('password')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- BUTTON -->
            <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2.5 rounded-lg transition">
                Masuk
            </button>
        </form>
    </div>

</body>

</html>
