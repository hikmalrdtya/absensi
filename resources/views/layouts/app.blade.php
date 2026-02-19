<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite('resources/css/app.css')
    <title>Absensi Siswa</title>
</head>

<body class="bg-white">
    <header class="fixed top-0 left-0 right-0 bg-white shadow-md z-50 flex items-center h-20">
        <div class="flex items-center gap-3 ml-4  h-20">
            <button id="sidebarToggle"
                class="w-10 h-10 bg-white/10 text-black rounded-lg flex items-center justify-center focus:outline-none">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="black">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            <h2 class="text-xl font-semibold">Dashboard Petugas</h2>
        </div>
    </header>

    <nav>
        @include('layouts.sidebar')
    </nav>

    <main class="content mt-20">
        @yield('content')
    </main>

    @vite('resources/js/app.js')
</body>

</html>
