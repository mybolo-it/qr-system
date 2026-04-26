<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'APG Portal') | E-Office System</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

    <style>
        /* PERBAIKAN FOOTER: Mengatur html dan body agar 100% tingginya */
        html,
        body {
            height: 100%;
            margin: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f1f5f9;
            display: flex;
            flex-direction: column;
        }

        /* Glassmorphism Toastify */
        .toastify {
            background: rgba(255, 255, 255, 0.9) !important;
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.8);
            border-radius: 1rem !important;
            color: #1e293b !important;
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 8px 10px -6px rgba(0, 0, 0, 0.1) !important;
            padding: 16px 24px !important;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .toastify.success {
            border-left: 6px solid #10b981 !important;
        }

        .toastify.error {
            border-left: 6px solid #ef4444 !important;
        }

        /* Nav Link Underline Hover Effect */
        .nav-link {
            position: relative;
            transition: color 0.3s ease;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: #4f46e5;
            transition: width 0.3s ease;
            border-radius: 2px;
        }

        .nav-link:hover::after,
        .nav-link.active::after {
            width: 100%;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="antialiased text-slate-800">

    @if (!request()->routeIs('login'))
        <nav x-data="{ mobileMenuOpen: false, scrollAtTop: true, navHidden: false, lastScroll: 0, manageOpen: false }"
            @scroll.window="
             navHidden = window.scrollY > lastScroll && window.scrollY > 80;
             lastScroll = window.scrollY;
             scrollAtTop = window.scrollY <= 0;
         "
            :class="{
                '-translate-y-full': navHidden,
                'bg-white/80 backdrop-blur-xl shadow-sm border-b border-slate-200/60': !scrollAtTop,
                'bg-transparent border-b border-transparent': scrollAtTop
            }"
            class="fixed w-full top-0 z-50 transition-all duration-300 ease-in-out">

            <div class="w-full px-6 lg:px-12 py-4 flex justify-between items-center">

                <a href="{{ route('home') }}" class="flex items-center gap-3 relative z-50 group">
                    <img src="{{ asset('img/logo.png') }}" alt="APG Logo"
                        class="w-9 h-auto drop-shadow-sm group-hover:scale-105 transition-transform duration-300">
                    <div class="flex flex-col">
                        <span class="text-lg font-extrabold text-slate-800 leading-none tracking-tight">Agung Putra
                            Group</span>
                        <span class="text-[10px] text-indigo-600 font-bold uppercase tracking-wider">E-Office</span>
                    </div>
                </a>

                <div class="hidden lg:flex items-center space-x-6">
                    @auth
                        <a href="{{ route('home') }}"
                            class="nav-link text-sm font-semibold text-slate-600 hover:text-indigo-600">Dashboard</a>
                        <a href="{{ route('documents.index') }}"
                            class="nav-link text-sm font-semibold text-slate-600 hover:text-indigo-600">Arsip Dokumen</a>

                        @if (auth()->user()->isAdmin() || auth()->user()->isGlobalHR())
                            <div class="relative">
                                <button @click="manageOpen = !manageOpen" @click.outside="manageOpen = false"
                                    class="flex items-center gap-1 nav-link text-sm font-semibold text-slate-600 hover:text-indigo-600 focus:outline-none">
                                    Manajemen Data
                                    <svg class="w-4 h-4 transition-transform duration-200"
                                        :class="{ 'rotate-180': manageOpen }" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                <div x-show="manageOpen" x-transition x-cloak
                                    class="absolute top-full mt-4 right-0 w-56 bg-white border border-slate-100 rounded-2xl shadow-xl py-2 overflow-hidden z-50">
                                    <a href="{{ route('admin.form') }}"
                                        class="block px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">Penerbitan
                                        Dokumen (QR)</a>

                                    @if (auth()->user()->isGlobalHR())
                                        <div class="h-px bg-slate-100 my-1 mx-4"></div>
                                        <a href="#"
                                            class="block px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">Kategori
                                            Dokumen</a>
                                        <a href="#"
                                            class="block px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">Manajemen
                                            Perusahaan</a>
                                        <a href="{{ route('users.index') }}"
                                            class="block px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50 hover:text-indigo-600 transition-colors">Pengguna
                                            Akses</a>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if (auth()->user()->isGlobalHR() || auth()->user()->isAdmin() || auth()->user()->isGM() || auth()->user()->isManager())
                            <a href="#"
                                class="nav-link text-sm font-semibold text-slate-600 hover:text-indigo-600">Laporan & Audit
                                Log</a>
                        @endif

                        <div class="h-6 w-px bg-slate-200 mx-2"></div>

                        <a href="{{ route('profile.edit') }}"
                            class="flex items-center justify-center w-9 h-9 rounded-full bg-slate-100 text-slate-600 hover:bg-indigo-50 hover:text-indigo-600 transition-colors"
                            title="Profil Anda">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </a>

                        <form method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <button type="submit"
                                class="bg-slate-800 hover:bg-slate-900 text-white px-5 py-2.5 rounded-xl text-sm font-bold shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300">
                                Keluar
                            </button>
                        </form>
                    @else
                        <a href="#"
                            class="nav-link text-sm font-semibold text-slate-600 hover:text-indigo-600">Verifikasi
                            Publik</a>
                        <a href="{{ route('login') }}"
                            class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-md hover:shadow-lg shadow-indigo-600/30 transform hover:-translate-y-0.5 transition-all duration-300">
                            Login Portal
                        </a>
                    @endauth
                </div>

                <div class="lg:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="text-slate-600 focus:outline-none p-2.5 rounded-xl bg-slate-100 hover:bg-slate-200 transition-colors">
                        <svg x-show="!mobileMenuOpen" class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16m-7 6h7" />
                        </svg>
                        <svg x-show="mobileMenuOpen" x-cloak class="w-5 h-5" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <div x-show="mobileMenuOpen" x-cloak x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 -translate-y-4" x-transition:enter-end="opacity-100 translate-y-0"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-4"
                class="lg:hidden bg-white border-t border-slate-100 absolute w-full shadow-2xl rounded-b-3xl">

                <div class="px-6 py-6 flex flex-col space-y-2 text-left">
                    @auth
                        <a href="{{ route('home') }}"
                            class="flex justify-start text-slate-600 font-bold py-3 border-b border-slate-50 hover:text-indigo-600 hover:pl-2 transition-all">Dashboard</a>
                        <a href="{{ route('documents.index') }}"
                            class="flex justify-start text-slate-600 font-bold py-3 border-b border-slate-50 hover:text-indigo-600 hover:pl-2 transition-all">Arsip
                            Dokumen</a>

                        @if (auth()->user()->isAdmin() || auth()->user()->isGlobalHR())
                            <a href="{{ route('admin.form') }}"
                                class="flex justify-start text-slate-600 font-bold py-3 border-b border-slate-50 hover:text-indigo-600 hover:pl-2 transition-all">Penerbitan
                                Dokumen</a>
                            @if (auth()->user()->isGlobalHR())
                                <a href="#"
                                    class="flex justify-start text-slate-600 font-bold py-3 border-b border-slate-50 hover:text-indigo-600 hover:pl-2 transition-all">Kategori
                                    & Perusahaan</a>
                                <a href="{{ route('users.index') }}"
                                    class="flex justify-start text-slate-600 font-bold py-3 border-b border-slate-50 hover:text-indigo-600 hover:pl-2 transition-all">Manajemen
                                    Pengguna</a>
                            @endif
                        @endif

                        @if (auth()->user()->isGlobalHR() || auth()->user()->isAdmin() || auth()->user()->isGM() || auth()->user()->isManager())
                            <a href="#"
                                class="flex justify-start text-slate-600 font-bold py-3 border-b border-slate-50 hover:text-indigo-600 hover:pl-2 transition-all">Laporan
                                & Log</a>
                        @endif

                        <a href="{{ route('profile.edit') }}"
                            class="flex justify-start text-slate-600 font-bold py-3 border-b border-slate-50 hover:text-indigo-600 hover:pl-2 transition-all">Pengaturan
                            Profil</a>

                        <form method="POST" action="{{ route('logout') }}" class="pt-4">
                            @csrf
                            <button type="submit"
                                class="w-full bg-slate-800 text-white py-3.5 rounded-xl font-bold shadow-md transition-all active:scale-95">
                                Keluar Aplikasi
                            </button>
                        </form>
                    @else
                        <a href="#"
                            class="flex justify-start text-slate-600 font-bold py-3 border-b border-slate-50 hover:text-indigo-600 transition-all">Verifikasi
                            Publik</a>
                        <a href="{{ route('login') }}"
                            class="mt-4 w-full bg-indigo-600 text-white py-3.5 rounded-xl font-bold text-center shadow-lg shadow-indigo-600/30 transition-all active:scale-95">
                            Login Portal
                        </a>
                    @endauth
                </div>
            </div>
        </nav>
    @endif

    <main class="w-full px-6 lg:px-12 py-10 pt-28 flex-1">
        @yield('content')
    </main>

    <footer class="py-8 bg-white border-t border-slate-200/60 w-full shrink-0">
        <div class="w-full px-6 lg:px-12">
            <div
                class="flex flex-col md:flex-row justify-between items-center text-slate-400 text-xs sm:text-sm font-medium">
                <div class="mb-4 md:mb-0 flex items-center gap-2">
                    <img src="{{ asset('img/logo.png') }}" class="h-5 opacity-40 grayscale" alt="Logo">
                    <span>&copy; {{ date('Y') }} Divisi IT PT Agung Putra Group. All rights reserved.</span>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-indigo-600 transition-colors">Panduan Sistem</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">Kebijakan Keamanan</a>
                    <a href="#" class="hover:text-indigo-600 transition-colors">IT Helpdesk</a>
                </div>
            </div>
        </div>
    </footer>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        @if (session('success'))
            Toastify({
                text: "✓ {{ session('success') }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "right",
                className: "success",
                stopOnFocus: true,
            }).showToast();
        @endif

        @if (session('error'))
            Toastify({
                text: "✕ {{ session('error') }}",
                duration: 4000,
                close: true,
                gravity: "top",
                position: "right",
                className: "error",
                stopOnFocus: true,
            }).showToast();
        @endif
    </script>
</body>

</html>
