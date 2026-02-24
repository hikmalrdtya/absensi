<style>
    .sidebar {
        transform: translateX(-100%);
        transition: transform 300ms cubic-bezier(.2, .8, .2, 1);
    }

    body.sidebar-open .sidebar {
        transform: translateX(0) !important;
    }

    .content {
        transition: margin-left 300ms cubic-bezier(.2, .8, .2, 1);
    }

    /* Do not shift page content when sidebar opens; sidebar should overlay */
    body.sidebar-open .content {
        margin-left: 0 !important;
    }

    #sidebarToggle svg {
        stroke: black;
    }
</style>

<aside class="sidebar fixed inset-y-0 left-0 w-72 bg-blue-600 text-white shadow-lg rounded-r-2xl overflow-hidden"
    style="z-index:99999; will-change:transform; pointer-events:auto;">
    <div class="h-full flex flex-col">
        <div class="px-6 py-6 border-b border-blue-500">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-blue-800 rounded flex items-center justify-center font-bold">A</div>
                    <div>
                        <div class="font-semibold">Absensi Siswa</div>
                        <div class="text-sm text-blue-200">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </div>
                <button id="sidebarCloseBtn" aria-label="Close sidebar" class="p-2 rounded-md hover:bg-blue-500/20">
                    <svg id="iconClose" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none"
                        viewBox="0 0 24 24" stroke="white" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <nav class="flex-1 px-4 py-6">
            <ul class="space-y-3">
                @if (auth()->user()->role === 'admin')
                    {{-- Admin --}}
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md bg-blue-700/80">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.petuga.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-700/60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-100" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A12.055 12.055 0 0112 15c2.5 0 4.847.7 6.879 1.904M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span>Kelola Petugas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.kela.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-700/60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-100" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M10 2a1 1 0 00-.894.553L7.382 6H4a1 1 0 000 2h2v6a2 2 0 002 2h4a2 2 0 002-2V8h2a1 1 0 100-2h-3.382l-1.724-3.447A1 1 0 0010 2z" />
                            </svg>
                            <span>Kelola Kelas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.siswa.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-700/60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-100" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
                                <path d="M6 20a6 6 0 0112 0H6z" />
                            </svg>
                            <span>Kelola Siswa</span>
                        </a>
                    </li>

                    <li>
                        <a href="" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-700/60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-100" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM7 10h10v2H7v-2z" />
                            </svg>
                            <span>Data Absensi</span>
                        </a>
                    </li>

                    <li>
                        <a href="/sms" class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-700/60">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-100" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path d="M2 7a2 2 0 012-2h16a2 2 0 012 2v9a2 2 0 01-2 2H6l-4 4V7z" />
                            </svg>
                            <span>Riwayat SMS</span>
                        </a>
                    </li>
                @elseif (auth()->user()->role === 'petugas')
                    {{-- Petugas --}}
                    <li>
                        <a href="{{ route('petugas.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-700/80 {{ request()->routeIs('petugas.dashboard') ? 'bg-blue-700/80' : 'hover:bg-blue-700/60' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M13 5v6h6" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('petugas.absensi.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-700/60 {{ request()->routeIs('petugas.absensi.*') ? 'bg-blue-700/80' : 'hover:bg-blue-700/60' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-100" viewBox="0 0 24 24"
                                fill="currentColor">
                                <path
                                    d="M19 3h-1V1h-2v2H8V1H6v2H5a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2V5a2 2 0 00-2-2zM7 10h10v2H7v-2z" />
                            </svg>
                            <span>Input Absensi</span>
                        </a>
                    </li>
                @endif
            </ul>
        </nav>

        <div class="px-4 py-5 border-t border-blue-500">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-full bg-blue-800 flex items-center justify-center">A</div>
                    <div>
                        <div class="font-medium">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-blue-200">{{ ucfirst(auth()->user()->role ?? 'user') }}</div>
                    </div>
                </div>
                <div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="w-full text-left text-blue-100 hover:text-white flex items-center gap-2 bg-transparent border-0 p-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7" />
                            </svg>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</aside>

<!-- Overlay shown when sidebar is open; clicking it closes the sidebar -->
<div id="sidebarOverlay" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.45);z-index:99990;"></div>
