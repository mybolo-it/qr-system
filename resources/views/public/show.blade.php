@extends('layouts.app')

@section('title', 'Verifikasi Dokumen - ' . $item->nama)

@section('content')
    <style>
        body {
            background-color: #f8fafc;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 30px -5px rgba(0, 0, 0, 0.05);
        }

        .info-block {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1rem;
            transition: all 0.3s ease;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .info-block:hover {
            border-color: #c7d2fe;
            box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.08);
            transform: translateY(-2px);
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 py-6 md:py-12">

        <!-- Navigasi -->
        <div
            class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 animate__animated animate__fadeInDown">
            @auth
                <a href="{{ route('admin.arsip') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-full text-sm font-bold text-slate-600 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 shadow-sm transition-all w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Arsip Internal
                </a>

                <a href="{{ route('home') }}"
                    class="inline-flex items-center gap-2 px-4 py-2.5 bg-white border border-slate-200 rounded-full text-sm font-bold text-slate-600 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 shadow-sm transition-all w-full sm:w-auto justify-center">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            @endauth
        </div>

        <div class="glass-card rounded-2xl md:rounded-[2rem] overflow-hidden animate__animated animate__fadeInUp">

            <!-- Header Dokumen -->
            <div
                class="relative bg-gradient-to-br from-indigo-700 via-indigo-800 to-slate-900 p-6 md:p-10 text-white overflow-hidden">
                <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-10 pointer-events-none">
                    <svg width="250" height="250" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <path
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex flex-wrap items-center gap-2.5 mb-5">
                        @if ($item->status == 'published')
                            <span
                                class="inline-flex items-center gap-1.5 bg-emerald-500/20 text-emerald-100 border border-emerald-400/30 text-[10px] md:text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm">
                                
                                Terverifikasi Valid
                            </span>
                        @elseif($item->status == 'revoked')
                            <span
                                class="inline-flex items-center gap-1.5 bg-rose-500/20 text-rose-100 border border-rose-400/30 text-[10px] md:text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm">
                                
                                Tidak Sah / Dicabut
                            </span>
                        @elseif($item->status == 'draft')
                            <span
                                class="inline-flex items-center gap-1.5 bg-slate-500/50 text-slate-100 border border-slate-400/30 text-[10px] md:text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm">
                                
                                Status Draft
                            </span>
                        @endif

                        <span
                            class="inline-flex items-center gap-1 bg-white/10 text-white border border-white/20 text-[10px] font-mono px-3 py-1.5 rounded-full backdrop-blur-sm">
                            ID: {{ substr($item->token, 0, 10) }}
                        </span>
                    </div>

                    <h1 class="text-2xl md:text-4xl font-extrabold leading-snug tracking-tight text-white mb-4">
                        {{ $item->nama }}
                    </h1>

                    <div
                        class="flex flex-col sm:flex-row sm:items-center gap-3 sm:gap-6 text-indigo-100/90 text-sm md:text-base font-medium">
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span>Nomor: <strong>{{ $item->nomor_surat ?? 'Tidak ada nomor' }}</strong></span>
                        </div>
                        <div class="hidden sm:block w-1.5 h-1.5 rounded-full bg-indigo-400/50"></div>
                        <div class="flex items-center gap-2">
                            <svg class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span>Tanggal:
                                <strong>{{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') : '-' }}</strong></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Konten Utama -->
            <div class="p-5 md:p-10">

                <!-- Paragraf Validasi Resmi -->
                <div
                    class="bg-indigo-50/80 border-l-4 border-indigo-500 rounded-r-2xl p-5 md:p-6 mb-8 text-sm md:text-base text-slate-700 leading-relaxed shadow-sm">
                    <strong>Pernyataan Validasi Sistem:</strong> Dokumen ini merupakan instrumen resmi yang diterbitkan
                    secara sah oleh
                    <strong>{{ $item->company ? $item->company->nama_perusahaan : 'PT Agung Putra Group' }}</strong>.
                    Berdasarkan rekam jejak digital dalam sistem, dokumen dengan nomor referensi
                    <strong>{{ $item->nomor_surat ?? '(-)' }}</strong> ini tercatat valid dan berlaku terhitung sejak
                    tanggal
                    <strong>{{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') : '-' }}</strong>.
                </div>

                <!-- Informasi Grid -->
                <!-- Grid dinamis: 3 kolom jika admin, 2 kolom jika publik -->
                <div class="grid grid-cols-2 {{ auth()->check() ? 'md:grid-cols-3' : '' }} gap-3 md:gap-4 mb-8">
                    <div class="info-block">
                        <p class="text-[10px] md:text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">Entitas
                        </p>
                        <p class="text-sm font-extrabold text-slate-800 line-clamp-2">
                            {{ $item->company ? $item->company->nama_perusahaan : 'PT Agung Putra Group' }}</p>
                    </div>
                    <div class="info-block">
                        <p class="text-[10px] md:text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">Kategori
                        </p>
                        <p class="text-sm font-extrabold text-slate-800 line-clamp-2">
                            {{ $item->category ? $item->category->nama_kategori : 'Dokumen Umum' }}</p>
                    </div>

                    @auth
                        <div class="info-block">
                            <p class="text-[10px] md:text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">Intensitas
                                Akses</p>
                            <p class="text-sm font-extrabold text-indigo-600">{{ $item->views }} Pemindaian</p>
                        </div>
                    @endauth
                </div>

                <hr class="border-slate-100 mb-8">

                <!-- Detail Tambahan -->
                <div class="space-y-6 md:space-y-8">
                    @if ($item->letterhead)
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                                <h3 class="text-base md:text-lg font-extrabold text-slate-800">Atribut Kepala Surat</h3>
                            </div>
                            <div class="bg-slate-50 rounded-2xl p-4 md:p-5 border border-slate-200 overflow-x-auto">
                                <p class="text-slate-700 font-mono text-xs md:text-sm leading-relaxed whitespace-pre-line">
                                    {{ $item->letterhead }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($item->deskripsi)
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-1.5 h-6 bg-purple-500 rounded-full"></div>
                                <h3 class="text-base md:text-lg font-extrabold text-slate-800">Uraian Ringkas</h3>
                            </div>
                            <p class="text-slate-600 leading-relaxed text-sm md:text-base bg-white">{{ $item->deskripsi }}
                            </p>
                        </div>
                    @endif
                </div>

                <!-- Modul Akses Lampiran Fisik (Eksklusif Administrator) -->
                @auth
                    <div class="mt-8 md:mt-10 pt-8 border-t border-slate-100 flex justify-center">
                        @php
                            $fileExists =
                                !empty($item->file_path) &&
                                \Illuminate\Support\Facades\Storage::disk('public')->exists($item->file_path);
                        @endphp

                        @if ($fileExists)
                            <a href="{{ route('document.file', $item->id) }}" target="_blank"
                                class="group relative inline-flex items-center justify-center gap-3 px-6 md:px-8 py-3.5 md:py-4 bg-indigo-600 text-white font-bold rounded-2xl overflow-hidden shadow-lg shadow-indigo-600/30 transition-all hover:scale-105 active:scale-95 w-full sm:w-auto">
                                <div
                                    class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]">
                                </div>
                                <svg class="w-5 h-5 md:w-6 md:h-6 relative z-10" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span class="relative z-10 text-sm md:text-base">Akses Dokumen Fisik</span>
                            </a>
                        @else
                            <div
                                class="inline-flex items-center justify-center gap-2 px-5 py-3.5 bg-slate-50 text-slate-400 rounded-xl text-sm font-bold border border-slate-200 cursor-not-allowed w-full sm:w-auto">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                </svg>
                                Dokumen Fisik Tidak Ditemukan
                            </div>
                        @endif
                    </div>
                @endauth

            </div>
        </div>
    </div>
@endsection
