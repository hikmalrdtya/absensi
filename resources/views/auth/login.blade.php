<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Absensi</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4">

    <div class="w-full max-w-md bg-white rounded-xl shadow-lg p-8">

        <!-- ICON -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-white" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 21h18M4 21V7a1 1 0 011-1h3m10 15V7a1 1 0 00-1-1h-3m-4 15V3m0 0L8 5m4-2l4 2" />
                </svg>
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

            <!-- USERNAME -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text"
                       name="name"
                       value="{{ old('name') }}"
                       placeholder="Masukkan username"
                       class="w-full rounded-lg px-4 py-2 border
                       @error('name') border-red-500 @else border-gray-300 @enderror
                       focus:outline-none focus:ring-2 focus:ring-blue-500">

                @error('name')
                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password"
                       name="password"
                       placeholder="Masukkan password"
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

        <!-- DEMO -->
        <p class="text-center text-sm text-gray-500 mt-6">
            Demo: <strong>admin / admin123</strong> atau <strong>budi / budi123</strong>
        </p>

    </div>

</body>
</html>
