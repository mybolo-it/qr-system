<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'QR System') | Panel Akses</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">

<style>
    /* Kustomisasi Toast agar sesuai dengan tema Glassmorphism Anda */
    .toastify {
        background: rgba(255, 255, 255, 0.8) !important;
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        border-radius: 1.5rem !important;
        color: #1e293b !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
        padding: 16px 28px !important;
        font-family: 'Poppins', sans-serif;
        font-weight: 600;
        font-size: 0.9rem;
    }
    .toastify.success {
        border-left: 6px solid #10b981 !important;
    }
    .toastify.error {
        border-left: 6px solid #ef4444 !important;
    }
</style>

    <style>
        body { 
            font-family: 'Poppins', sans-serif; 
            background: radial-gradient(circle at top right, #fdfcfb 0%, #e2d1f9 100%);
            min-height: 100vh;
        }
        .glass-nav {
            background: rgba(255, 255, 255, 0.75);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.3);
        }
        .nav-link {
            position: relative;
            transition: all 0.3s ease;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -4px;
            left: 0;
            background: linear-gradient(90deg, #667eea, #764ba2);
            transition: width 0.3s ease;
        }
        .nav-link:hover::after {
            width: 100%;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="antialiased text-gray-800">

    @if(!request()->routeIs('login'))
    <nav x-data="{ mobileMenuOpen: false }" class="glass-nav sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        
        <a href="{{ route('home') }}" class="flex items-center group relative z-50">
            <div class="bg-gradient-to-tr from-indigo-600 to-purple-600 p-2 rounded-lg shadow-lg group-hover:rotate-12 transition-transform">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                </svg>
            </div>
            <span class="ml-3 text-xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-gray-800 to-gray-500">
                QR<span class="text-indigo-600">System</span>
            </span>
        </a>

        <div class="hidden md:flex items-center space-x-8">
            <a href="{{ route('home') }}" class="nav-link text-sm font-medium text-gray-600 hover:text-indigo-600">Dashboard Publik</a>
            <a href="{{ route('documents.index') }}" class="nav-link text-sm font-medium text-gray-600 hover:text-indigo-600">List Document</a>
            
            @auth
            <a href="{{ route('admin.form') }}" class="nav-link text-sm font-medium text-gray-600 hover:text-indigo-600">Input Data</a>
            @if(auth()->user()->isSuperadmin())
            <a href="{{ route('users.index') }}" class="nav-link text-sm font-medium text-gray-600 hover:text-indigo-600">Manajemen User</a>
            @endif
            <a href="{{ route('profile.edit') }}" class="nav-link text-sm font-medium text-gray-600 hover:text-indigo-600">Profile</a>
            <div class="h-6 w-px bg-gray-200"></div>
            <form method="POST" action="{{ route('logout') }}" class="inline">
                @csrf
                <button type="submit" class="bg-red-50 hover:bg-red-100 text-red-600 px-4 py-2 rounded-xl text-sm font-bold transition duration-300">
                    Logout
                </button>
            </form>
            @else
            <a href="{{ route('login') }}" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2.5 rounded-xl text-sm font-bold shadow-lg transition transform hover:-translate-y-0.5">
                Login Admin
            </a>
            @endauth
        </div>

        <div class="md:hidden">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 focus:outline-none p-2 rounded-xl bg-gray-50/50">
                <svg x-show="!mobileMenuOpen" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/></svg>
                <svg x-show="mobileMenuOpen" x-cloak class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </div>

    <div x-show="mobileMenuOpen" 
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden glass-nav border-t border-gray-100 absolute w-full shadow-xl">
        
        <div class="px-6 py-6 flex flex-col space-y-4 bg-white/90">
            <a href="{{ route('home') }}" class="text-gray-600 font-semibold py-2 border-b border-gray-50 hover:text-indigo-600 transition">Dashboard Publik</a>
            <a href="{{ route('documents.index') }}" class="text-gray-600 font-semibold py-2 border-b border-gray-50 hover:text-indigo-600 transition">List Document</a>
            
            @auth
                @if(auth()->user()->isSuperadmin())
                    <a href="{{ route('users.index') }}" class="text-gray-600 font-semibold py-2 border-b border-gray-50 hover:text-indigo-600 transition">Manajemen User</a>
                @endif
                <a href="{{ route('admin.form') }}" class="text-gray-600 font-semibold py-2 border-b border-gray-50 hover:text-indigo-600 transition">Input Data</a>
                
                <form method="POST" action="{{ route('logout') }}" class="pt-2">
                    @csrf
                    <button type="submit" class="w-full bg-red-50 text-red-600 py-3 rounded-xl font-bold transition">
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="w-full bg-indigo-600 text-white py-3 rounded-xl font-bold text-center shadow-lg shadow-indigo-100 transition">
                    Login Admin
                </a>
            @endauth
        </div>
    </div>
</nav>
    @endif

    <main class="container mx-auto px-6 py-10">
        @yield('content')
    </main>

    <footer class="mt-auto py-12 border-t border-gray-200/50">
        <div class="container mx-auto px-6">
            <div class="flex flex-col md:flex-row justify-between items-center text-gray-400 text-sm">
                <div class="mb-4 md:mb-0 text-center md:text-left">
                    &copy; {{ date('Y') }} <span class="font-bold text-gray-600 uppercase tracking-widest">QR System</span>. All rights reserved.
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="hover:text-indigo-500 transition">Panduan</a>
                    <a href="#" class="hover:text-indigo-500 transition">Privasi</a>
                    <a href="#" class="hover:text-indigo-500 transition">Kontak</a>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>

<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

<script>
    @if(session('success'))
        Toastify({
            text: "✅ {{ session('success') }}",
            duration: 4000,
            close: true,
            gravity: "top", 
            position: "right",
            className: "success",
            stopOnFocus: true,
        }).showToast();
    @endif

    @if(session('error'))
        Toastify({
            text: "❌ {{ session('error') }}",
            duration: 4000,
            close: true,
            gravity: "top",
            position: "right",
            className: "error",
            stopOnFocus: true,
        }).showToast();
    @endif
</script>