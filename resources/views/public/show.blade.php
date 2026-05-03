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
            padding: 1.25rem;
            transition: all 0.3s ease;
        }

        .info-block:hover {
            border-color: #c7d2fe;
            box-shadow: 0 4px 15px -3px rgba(99, 102, 241, 0.08);
            transform: translateY(-2px);
        }
    </style>

    <div class="max-w-4xl mx-auto px-4 py-8 md:py-12">

        <div class="mb-6 animate__animated animate__fadeInDown flex justify-between items-center">
            @auth
                <a href="{{ route('admin.arsip') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-full text-sm font-bold text-slate-600 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Arsip Internal
                </a>

                <span class="text-xs font-bold bg-amber-100 text-amber-700 px-3 py-1.5 rounded-full flex items-center gap-1.5">
                    <span class="w-2 h-2 bg-amber-500 rounded-full animate-pulse"></span>
                    Mode Admin (Testing)
                </span>
            @endauth

            @guest
                <a href="https://mybolo.id"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-full text-sm font-bold text-slate-600 hover:text-indigo-600 shadow-sm transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Portal Utama MyBolo
                </a>
            @endguest
        </div>

        <div class="glass-card rounded-[2rem] overflow-hidden animate__animated animate__fadeInUp">

            <div
                class="relative bg-gradient-to-r from-indigo-600 via-indigo-800 to-slate-900 p-8 md:p-10 text-white overflow-hidden">
                <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-10 pointer-events-none">
                    <svg width="250" height="250" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <path
                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                    </svg>
                </div>

                <div class="relative z-10">
                    <div class="flex flex-wrap items-center gap-3 mb-5">

                        @if ($item->status == 'published')
                            <span
                                class="inline-flex items-center gap-1.5 bg-emerald-500/20 text-emerald-100 border border-emerald-400/30 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm">
                                <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                Terverifikasi Valid
                            </span>
                        @elseif($item->status == 'revoked')
                            <span
                                class="inline-flex items-center gap-1.5 bg-rose-500/20 text-rose-100 border border-rose-400/30 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm">
                                <svg class="w-4 h-4 text-rose-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                                DOKUMEN DICABUT / TIDAK SAH
                            </span>
                        @elseif($item->status == 'draft')
                            <span
                                class="inline-flex items-center gap-1.5 bg-slate-500/50 text-slate-100 border border-slate-400/30 text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider backdrop-blur-sm">
                                <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                STATUS DRAFT
                            </span>
                        @endif

                        <span
                            class="inline-flex items-center gap-1 bg-white/10 text-white border border-white/20 text-[10px] font-mono px-3 py-1.5 rounded-full backdrop-blur-sm">
                            ID: {{ substr($item->token, 0, 10) }}
                        </span>
                    </div>

                    <h1 class="text-3xl md:text-4xl font-extrabold leading-tight tracking-tight text-white mb-2">
                        {{ $item->nama }}
                    </h1>
                    <p class="text-indigo-200 text-sm md:text-base font-medium flex items-center gap-2">
                        Diterbitkan pada {{ $item->created_at->translatedFormat('d F Y') }}
                    </p>
                </div>
            </div>

            <div class="p-6 md:p-10">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="info-block">
                        <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">Entitas</p>
                        <p class="text-sm font-extrabold text-slate-800 line-clamp-2">
                            {{ $item->company ? $item->company->nama_perusahaan : 'PT Agung Putra Group' }}</p>
                    </div>
                    <div class="info-block">
                        <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">Kategori</p>
                        <p class="text-sm font-extrabold text-slate-800 line-clamp-2">
                            {{ $item->category ? $item->category->nama_kategori : 'Dokumen Umum' }}</p>
                    </div>

                    <div class="info-block">
                        <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">Integritas Data</p>
                        <p class="text-sm font-extrabold text-emerald-600 flex items-center gap-1">
                            <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span> Aman
                        </p>
                    </div>

                    @auth
                        <div class="info-block">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">Total Scan</p>
                            <p class="text-sm font-extrabold text-indigo-600">{{ $item->views }} Kali</p>
                        </div>
                    @else
                        <div class="info-block">
                            <p class="text-[10px] uppercase tracking-widest font-bold text-slate-400 mb-1">Format</p>
                            <p class="text-sm font-extrabold text-slate-800">Digital / PDF</p>
                        </div>
                    @endauth
                </div>

                <hr class="border-slate-100 mb-8">

                <div class="space-y-8">
                    @if ($item->letterhead)
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-1.5 h-6 bg-indigo-500 rounded-full"></div>
                                <h3 class="text-lg font-extrabold text-slate-800">Nomor / Identitas Surat</h3>
                            </div>
                            <div class="bg-slate-50 rounded-2xl p-5 border border-slate-200">
                                <p class="text-slate-700 font-mono text-sm leading-relaxed whitespace-pre-line">
                                    {{ $item->letterhead }}</p>
                            </div>
                        </div>
                    @endif

                    @if ($item->deskripsi)
                        <div>
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-1.5 h-6 bg-purple-500 rounded-full"></div>
                                <h3 class="text-lg font-extrabold text-slate-800">Keterangan Tambahan</h3>
                            </div>
                            <p class="text-slate-600 leading-relaxed text-base bg-white">{{ $item->deskripsi }}</p>
                        </div>
                    @endif
                </div>

                <div class="mt-10 pt-8 border-t border-slate-100 flex justify-center">
                    @if (isset($item->file_path))
                        <a href="{{ route('document.file', $item->id) }}" target="_blank"
                            class="group relative inline-flex items-center justify-center gap-3 px-8 py-4 bg-indigo-600 text-white font-bold rounded-2xl overflow-hidden shadow-lg shadow-indigo-600/30 transition-all hover:scale-105 active:scale-95">
                            <div
                                class="absolute inset-0 w-full h-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]">
                            </div>
                            <svg class="w-6 h-6 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="relative z-10">Lihat Lampiran Asli</span>
                        </a>
                    @else
                        <div
                            class="inline-flex items-center gap-2 px-4 py-3 bg-slate-100 text-slate-500 rounded-xl text-sm font-bold border border-slate-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                            </svg>
                            Lampiran File Tidak Tersedia
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
