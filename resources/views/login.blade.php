@extends('layouts.app')

@section('title', 'Login - PT Agung Putra Group')

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #f8fafc;
            /* Slate 50 - Bersih dan profesional */
            margin: 0;
            padding: 0;
        }

        .glass-input {
            background: #ffffff;
            transition: all 0.3s ease;
        }

        .glass-input:focus-within {
            box-shadow: 0 4px 20px rgba(79, 70, 229, 0.1);
        }

        /* 3D Card Hover Effect - Dipertahankan karena elegan */
        .perspective-wrapper {
            perspective: 1200px;
        }

        .card-3d-effect {
            transition: transform 0.6s cubic-bezier(0.25, 0.8, 0.25, 1), box-shadow 0.6s ease;
            transform-style: preserve-3d;
            box-shadow: 0 20px 40px -10px rgba(0, 0, 0, 0.1);
        }

        @media (min-width: 768px) {
            .perspective-wrapper:hover .card-3d-effect {
                transform: translateY(-5px);
                box-shadow: 0 30px 60px -15px rgba(0, 0, 0, 0.15);
            }
        }
    </style>

    <div class="relative min-h-screen flex items-center justify-center p-4 sm:p-8 perspective-wrapper">

        <div
            class="relative z-10 w-full max-w-5xl bg-white rounded-3xl overflow-hidden flex flex-col md:flex-row card-3d-effect animate__animated animate__fadeInUp animate__fast">

            <div
                class="w-full md:w-5/12 relative overflow-hidden hidden md:flex flex-col justify-between p-12 bg-gradient-to-br from-slate-800 to-indigo-900">

                <div class="absolute inset-0 opacity-10">
                    <svg width="100%" height="100%" xmlns="http://www.w3.org/2000/svg">
                        <defs>
                            <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1" />
                            </pattern>
                        </defs>
                        <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                <div class="relative z-10 flex items-center gap-4 animate__animated animate__fadeInDown">
                    <img src="{{ asset('img/logo.png') }}" alt="Logo PT Agung Putra Group"
                        class="w-14 h-auto brightness-0 invert opacity-90 drop-shadow-md">

                    <div class="border-l border-white/20 pl-4">
                        <h1 class="text-xl font-bold text-white tracking-wide">PT Agung Putra Group</h1>
                        <p class="text-xs text-indigo-200 font-medium tracking-wider">GROUP HOLDING</p>
                    </div>
                </div>

                <div class="relative z-10 flex justify-center w-full my-8 animate__animated animate__fadeIn">
                    <svg class="w-full max-w-[280px] h-auto drop-shadow-2xl" viewBox="0 0 300 250" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M30 180 L150 140 L270 180 L150 220 Z" fill="#4F46E5" fill-opacity="0.3" />
                        <path d="M40 178 L150 145 L260 178 L150 212 Z" fill="#4F46E5" fill-opacity="0.5" />

                        <rect x="60" y="60" width="180" height="110" rx="8" fill="#F8FAFC" />
                        <path d="M60 68C60 63.5817 63.5817 60 68 60H232C236.418 60 240 63.5817 240 68V80H60V68Z"
                            fill="#E2E8F0" />
                        <circle cx="75" cy="70" r="3" fill="#CBD5E1" />
                        <circle cx="85" cy="70" r="3" fill="#CBD5E1" />
                        <circle cx="95" cy="70" r="3" fill="#CBD5E1" />

                        <rect x="80" y="90" width="60" height="70" rx="4" fill="#FFFFFF" stroke="#CBD5E1"
                            stroke-width="2" />
                        <rect x="90" y="100" width="40" height="4" rx="2" fill="#94A3B8" />
                        <rect x="90" y="110" width="30" height="4" rx="2" fill="#E2E8F0" />
                        <rect x="90" y="120" width="40" height="4" rx="2" fill="#E2E8F0" />
                        <rect x="90" y="135" width="15" height="15" fill="#475569" />

                        <rect x="160" y="130" width="15" height="30" rx="2" fill="#6366F1" />
                        <rect x="185" y="110" width="15" height="50" rx="2" fill="#818CF8" />
                        <rect x="210" y="140" width="15" height="20" rx="2" fill="#C7D2FE" />

                        <path d="M150 110L125 120V145C125 165 140 180 150 185C160 180 175 165 175 145V120L150 110Z"
                            fill="#10B981" />
                        <path d="M142 145L135 138L140 133L142 135L155 122L160 127L142 145Z" fill="#FFFFFF" />

                        <path d="M250 80 L255 95 L270 95 L258 105 L262 120 L250 110 L238 120 L242 105 L230 95 L245 95 Z"
                            fill="#FBBF24" opacity="0.8" />
                        <circle cx="40" cy="90" r="8" fill="#F472B6" opacity="0.8" />
                        <circle cx="210" cy="45" r="5" fill="#38BDF8" opacity="0.8" />
                    </svg>
                </div>

                <div class="relative z-10 animate__animated animate__fadeInUp">
                    <h2 class="text-2xl font-bold text-white mb-2">Portal Manajemen Dokumen</h2>
                    <p class="text-indigo-200 text-sm font-light leading-relaxed opacity-90">
                        Sistem terpusat untuk penerbitan, pengelolaan, dan verifikasi keaslian dokumen digital di seluruh
                        jaringan perusahaan.
                    </p>
                </div>
            </div>

            <div class="w-full md:w-7/12 p-8 sm:p-12 lg:p-16 flex items-center bg-white z-10">
                <div class="w-full max-w-md mx-auto">

                    <div class="md:hidden flex items-center justify-start gap-3 mb-10">
                        <img src="{{ asset('img/logo.png') }}" alt="Logo PT Agung Putra Group"
                            class="w-10 h-auto drop-shadow-sm">
                        <div>
                            <h1 class="text-lg font-bold text-slate-800 leading-none">Agung Putra Group</h1>
                            <span class="text-[10px] text-slate-500 font-semibold uppercase tracking-wider">E-Office
                                Portal</span>
                        </div>
                    </div>

                    <div class="mb-10 text-left">
                        <h2 class="text-3xl font-extrabold text-slate-800 tracking-tight">Otentikasi Akun</h2>
                        <p class="text-slate-500 mt-2 text-sm font-medium">Silakan masukkan kredensial korporat Anda.</p>
                    </div>

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <div class="space-y-2 text-left">
                            <label for="email" class="block text-sm font-bold text-slate-700">Alamat Email</label>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                                    </svg>
                                </div>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required
                                    autofocus
                                    class="block w-full pl-11 pr-4 py-3.5 glass-input border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-600 @error('email') border-red-500 ring-1 ring-red-500 @enderror"
                                    placeholder="nama@perusahaan.com">
                            </div>
                            @error('email')
                                <p class="text-red-500 text-xs font-semibold mt-1 animate__animated animate__fadeIn">
                                    {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="space-y-2 text-left">
                            <div class="flex justify-between items-end">
                                <label for="password" class="block text-sm font-bold text-slate-700">Kata Sandi</label>
                                @if (Route::has('password.request'))
                                    <a href="{{ route('password.request') }}"
                                        class="text-xs font-bold text-indigo-600 hover:text-indigo-800 transition-colors">
                                        Lupa Sandi?
                                    </a>
                                @endif
                            </div>
                            <div class="relative group">
                                <div
                                    class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none transition-colors group-focus-within:text-indigo-600 text-slate-400">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <input type="password" name="password" id="password" required
                                    class="block w-full pl-11 pr-4 py-3.5 glass-input border border-slate-200 rounded-xl text-slate-800 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-600 @error('password') border-red-500 ring-1 ring-red-500 @enderror"
                                    placeholder="••••••••">
                            </div>
                            @error('password')
                                <p class="text-red-500 text-xs font-semibold mt-1 animate__animated animate__fadeIn">
                                    {{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex items-center text-left pt-1">
                            <input id="remember_me" type="checkbox" name="remember"
                                class="w-4 h-4 text-indigo-600 border-slate-300 rounded focus:ring-indigo-500 transition duration-200 cursor-pointer">
                            <label for="remember_me" class="ml-2 block text-sm font-medium text-slate-600 cursor-pointer">
                                Ingat sesi saya
                            </label>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full flex justify-center items-center gap-2 bg-slate-800 text-white font-bold py-4 px-4 rounded-xl hover:bg-slate-900 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-slate-300">
                                <span>Masuk ke Sistem</span>
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-1" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>
                        </div>
                    </form>

                    <div class="mt-10 text-left border-t border-slate-100 pt-6">
                        <p class="text-xs text-slate-400 font-medium">
                            &copy; {{ date('Y') }} PT Agung Putra Group.<br>
                            Sistem Informasi Terpadu & Manajemen Dokumen.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
