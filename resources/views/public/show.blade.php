@extends('layouts.app')

@section('title', $item->nama)

@section('content')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #f0f2f5;
        }

        .glass-container {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.4);
        }

        .bg-gradient-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .accent-line {
            height: 4px;
            width: 50px;
            background: #667eea;
            border-radius: 2px;
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 py-10">
        <div class="mb-6 animate__animated animate__fadeInLeft">
           <a href="{{ route('home') }}" class="inline-flex items-center text-indigo-600 hover:text-indigo-800 font-medium transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali ke Dashboard
            </a>
        </div>

        <div class="glass-container rounded-3xl shadow-2xl overflow-hidden animate__animated animate__zoomIn">
            <div class="bg-gradient-header p-8 md:p-12 text-white relative">
                <div class="absolute top-0 right-0 p-6 opacity-20">
                    <svg class="w-24 h-24" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"
                            clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <span
                        class="bg-white/20 text-xs font-bold px-3 py-1 rounded-full uppercase tracking-widest mb-4 inline-block">Detail
                        Informasi</span>
                    <h1 class="text-3xl md:text-4xl font-extrabold leading-tight">{{ $item->nama }}</h1>
                    <div class="flex items-center mt-4 text-indigo-100 text-sm">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                            <path fill-rule="evenodd"
                                d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                clip-rule="evenodd" />
                        </svg>
                        Telah dilihat {{ $item->views }} kali
                    </div>
                </div>
            </div>

            <div class="p-8 md:p-12 space-y-10">


                @if ($item->letterhead)
                    <div class="animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="flex items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800 mr-4">Nomor Surat</h3>
                            <div class="accent-line"></div>
                        </div>
                        <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                            <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $item->letterhead }}</p>
                        </div>
                    </div>
                @endif

                
                @if ($item->deskripsi)
                    <div class="animate__animated animate__fadeInUp animate__delay-1s">
                        <div class="flex items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-800 mr-4">Deskripsi</h3>
                            <div class="accent-line"></div>
                        </div>
                        <p class="text-gray-600 leading-relaxed text-lg italic">
                            "{{ $item->deskripsi }}"
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <p class="mt-8 text-center text-gray-400 text-sm">
            &copy; {{ date('Y') }} Layanan Data.
        </p>
    </div>
@endsection
