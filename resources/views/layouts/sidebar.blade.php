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
                    <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px"
                        fill="#e3e3e3">
                        <path
                            d="M480-120 200-272v-240L40-600l440-240 440 240v320h-80v-276l-80 44v240L480-120Zm0-332 274-148-274-148-274 148 274 148Zm0 241 200-108v-151L480-360 280-470v151l200 108Zm0-241Zm0 90Zm0 0Z" />
                    </svg>
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
                    {{-- ================= ADMIN ================= --}}
                    <li>
                        <a href="{{ route('admin.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.dashboard') ? 'bg-blue-700/80' : 'hover:bg-blue-700/60' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#e3e3e3">
                                <path
                                    d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.petuga.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.petuga.*') ? 'bg-blue-700/80' : 'hover:bg-blue-700/60' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#e3e3e3">
                                <path
                                    d="M480-480q-51 0-85.5-34.5T360-600q0-50 34.5-85t85.5-35q50 0 85 35t35 85q0 51-35 85.5T480-480Zm0-80q17 0 28.5-11.5T520-600q0-17-11.5-28.5T480-640q-17 0-28.5 11.5T440-600q0 17 11.5 28.5T480-560ZM240-240v-76q0-21 10.5-39.5T279-385q46-27 96.5-41T480-440q54 0 104.5 14t96.5 41q18 11 28.5 29.5T720-316v76H240Zm160-110q-39 10-74 30h308q-35-20-74-30t-80-10q-41 0-80 10Zm80-250Zm80 280h74-308 234ZM160-80q-33 0-56.5-23.5T80-160v-160h80v160h160v80H160ZM80-640v-160q0-33 23.5-56.5T160-880h160v80H160v160H80ZM640-80v-80h160v-160h80v160q0 33-23.5 56.5T800-80H640Zm160-560v-160H640v-80h160q33 0 56.5 23.5T880-800v160h-80Z" />
                            </svg>
                            <span>Kelola Petugas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.kela.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.kela.*') ? 'bg-blue-700/80' : 'hover:bg-blue-700/60' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#e3e3e3">
                                <path
                                    d="M560-564v-68q33-14 67.5-21t72.5-7q26 0 51 4t49 10v64q-24-9-48.5-13.5T700-600q-38 0-73 9.5T560-564Zm0 220v-68q33-14 67.5-21t72.5-7q26 0 51 4t49 10v64q-24-9-48.5-13.5T700-380q-38 0-73 9t-67 27Zm0-110v-68q33-14 67.5-21t72.5-7q26 0 51 4t49 10v64q-24-9-48.5-13.5T700-490q-38 0-73 9.5T560-454ZM260-320q47 0 91.5 10.5T440-278v-394q-41-24-87-36t-93-12q-36 0-71.5 7T120-692v396q35-12 69.5-18t70.5-6Zm260 42q44-21 88.5-31.5T700-320q36 0 70.5 6t69.5 18v-396q-33-14-68.5-21t-71.5-7q-47 0-93 12t-87 36v394Zm-40 118q-48-38-104-59t-116-21q-42 0-82.5 11T100-198q-21 11-40.5-1T40-234v-482q0-11 5.5-21T62-752q46-24 96-36t102-12q58 0 113.5 15T480-740q51-30 106.5-45T700-800q52 0 102 12t96 36q11 5 16.5 15t5.5 21v482q0 23-19.5 35t-40.5 1q-37-20-77.5-31T700-240q-60 0-116 21t-104 59ZM280-494Z" />
                            </svg>
                            <span>Kelola Kelas</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.siswa.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.siswa.*') ? 'bg-blue-700/80' : 'hover:bg-blue-700/60' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#e3e3e3">
                                <path
                                    d="M480-120 200-272v-240L40-600l440-240 440 240v320h-80v-276l-80 44v240L480-120Zm0-332 274-148-274-148-274 148 274 148Zm0 241 200-108v-151L480-360 280-470v151l200 108Zm0-241Zm0 90Zm0 0Z" />
                            </svg>
                            <span>Kelola Siswa</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('admin.absensi.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md {{ request()->routeIs('admin.absensi.*') ? 'bg-blue-700/80' : 'hover:bg-blue-700/60' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#e3e3e3">
                                <path
                                    d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm221.5-198.5Q510-807 510-820t-8.5-21.5Q493-850 480-850t-21.5 8.5Q450-833 450-820t8.5 21.5Q467-790 480-790t21.5-8.5ZM200-200v-560 560Z" />
                            </svg>
                            <span>Data Absensi</span>
                        </a>
                    </li>
                @elseif (auth()->user()->role === 'petugas')
                    {{-- ================= PETUGAS ================= --}}

                    <li>
                        <a href="{{ route('petugas.dashboard') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-700/80 {{ request()->routeIs('petugas.dashboard') ? 'bg-blue-700/80' : 'hover:bg-blue-700/60' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#e3e3e3">
                                <path
                                    d="M520-600v-240h320v240H520ZM120-440v-400h320v400H120Zm400 320v-400h320v400H520Zm-400 0v-240h320v240H120Zm80-400h160v-240H200v240Zm400 320h160v-240H600v240Zm0-480h160v-80H600v80ZM200-200h160v-80H200v80Zm160-320Zm240-160Zm0 240ZM360-280Z" />
                            </svg>
                            <span>Dashboard</span>
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('petugas.absensi.index') }}"
                            class="flex items-center gap-3 px-3 py-2 rounded-md hover:bg-blue-700/60 {{ request()->routeIs('petugas.absensi.*') ? 'bg-blue-700/80' : 'hover:bg-blue-700/60' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#e3e3e3">
                                <path
                                    d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h168q13-36 43.5-58t68.5-22q38 0 68.5 22t43.5 58h168q33 0 56.5 23.5T840-760v560q0 33-23.5 56.5T760-120H200Zm0-80h560v-560H200v560Zm80-80h280v-80H280v80Zm0-160h400v-80H280v80Zm0-160h400v-80H280v80Zm221.5-198.5Q510-807 510-820t-8.5-21.5Q493-850 480-850t-21.5 8.5Q450-833 450-820t8.5 21.5Q467-790 480-790t21.5-8.5ZM200-200v-560 560Z" />
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
                    <div>
                        <div class="font-medium">{{ auth()->user()->name }}</div>
                        <div class="text-sm text-blue-200">{{ ucfirst(auth()->user()->role ?? 'user') }}</div>
                    </div>
                </div>
                <div>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="w-full cursor-pointer text-left text-blue-100 hover:text-white flex items-center gap-2 bg-transparent border-0 p-0">
                            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960"
                                width="24px" fill="#e3e3e3">
                                <path
                                    d="M200-120q-33 0-56.5-23.5T120-200v-560q0-33 23.5-56.5T200-840h280v80H200v560h280v80H200Zm440-160-55-58 102-102H360v-80h327L585-622l55-58 200 200-200 200Z" />
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
