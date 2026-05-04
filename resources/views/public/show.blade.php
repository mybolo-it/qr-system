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

        /* Styling khusus scrollbar untuk area preview */
        .preview-container::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        .preview-container::-webkit-scrollbar-track {
            background: #f1f5f9;
            border-radius: 8px;
        }

        .preview-container::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 8px;
        }

        .preview-container::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @php
        // Cek ekstensi file untuk menentukan cara preview
        $fileExtension = '';
        $fileExists = false;
        $fileUrl = '';

        if (!empty($item->file_path) && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->file_path)) {
            $fileExists = true;
            $fileUrl = route('document.file', $item->id);
            $fileExtension = strtolower(pathinfo($item->file_path, PATHINFO_EXTENSION));
        }

        $isImage = in_array($fileExtension, ['jpg', 'jpeg', 'png', 'svg']);
        $isPdf = $fileExtension === 'pdf';
    @endphp

    {{-- KONTINER UTAMA: Full width jika Admin, Max-w-4xl jika Publik --}}
    <div class="{{ auth()->check() ? 'w-full px-4 lg:px-8' : 'max-w-4xl mx-auto px-4' }} py-6 md:py-8">

        <!-- Navigasi -->
        <div
            class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 animate__animated animate__fadeInDown">
            @auth
                <div class="flex flex-wrap gap-3 w-full sm:w-auto">
                    <a href="{{ route('admin.arsip') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-full text-sm font-bold text-slate-600 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 shadow-sm transition-all justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Arsip Internal
                    </a>

                    <a href="{{ route('home') }}"
                        class="inline-flex items-center gap-2 px-4 py-2 bg-white border border-slate-200 rounded-full text-sm font-bold text-slate-600 hover:text-indigo-600 hover:border-indigo-200 hover:bg-indigo-50 shadow-sm transition-all justify-center">
                        Dashboard
                    </a>
                </div>

                @if ($fileExists)
                    <a href="{{ $fileUrl }}" target="_blank"
                        class="inline-flex items-center gap-2 px-5 py-2 bg-indigo-600 text-white rounded-full text-sm font-bold hover:bg-indigo-700 shadow-md transition-all justify-center">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        Unduh Penuh
                    </a>
                @endif
            @endauth
        </div>

        {{-- GRID LAYOUT: 2 Kolom untuk Admin, 1 Kolom untuk Publik --}}
        <div class="{{ auth()->check() ? 'lg:grid lg:grid-cols-12 lg:gap-6 items-start' : '' }}">

            {{-- KOLOM KIRI (INFORMASI DOKUMEN) --}}
            <div
                class="glass-card rounded-2xl md:rounded-[2rem] overflow-hidden animate__animated animate__fadeInUp {{ auth()->check() ? 'lg:col-span-5 xl:col-span-4 sticky top-28' : '' }}">

                <!-- Header Dokumen -->
                <div
                    class="relative bg-gradient-to-br from-indigo-700 via-indigo-800 to-slate-900 p-6 md:p-8 text-white overflow-hidden">
                    <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-10 pointer-events-none">
                        <svg width="200" height="200" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                            <path
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                        </svg>
                    </div>

                    <div class="relative z-10">
                        <div class="flex flex-wrap items-center gap-2 mb-4">
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

                        <h1 class="text-2xl md:text-3xl font-extrabold leading-snug tracking-tight text-white mb-3">
                            {{ $item->nama }}
                        </h1>

                        <div class="flex flex-col gap-2 text-indigo-100/90 text-sm font-medium">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                <span>No: <strong>{{ $item->nomor_surat ?? 'Tidak ada nomor' }}</strong></span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Tgl:
                                    <strong>{{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d F Y') : '-' }}</strong></span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Konten Kiri (Informasi Grid) -->
                <div class="p-5 md:p-6">
                    <div
                        class="bg-indigo-50 border-l-4 border-indigo-500 rounded-r-xl p-4 mb-6 text-xs md:text-sm text-slate-700 leading-relaxed">
                        Dokumen ini diterbitkan sah oleh
                        <strong>{{ $item->company ? $item->company->nama_perusahaan : 'PT Agung Putra Group' }}</strong>.
                        Terdata sejak
                        <strong>{{ $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->translatedFormat('d M Y') : '-' }}</strong>.
                    </div>

                    <div class="grid grid-cols-2 gap-3 mb-6">
                        <div class="info-block">
                            <p class="text-[10px] md:text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">
                                Entitas</p>
                            <p class="text-sm font-extrabold text-slate-800 line-clamp-2">
                                {{ $item->company ? $item->company->nama_perusahaan : 'APG' }}</p>
                        </div>
                        <div class="info-block">
                            <p class="text-[10px] md:text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">
                                Kategori</p>
                            <p class="text-sm font-extrabold text-slate-800 line-clamp-2">
                                {{ $item->category ? $item->category->nama_kategori : 'Umum' }}</p>
                        </div>

                        @auth
                            <div class="info-block col-span-2">
                                <p class="text-[10px] md:text-xs uppercase tracking-widest font-bold text-slate-400 mb-1">
                                    Intensitas Akses Publik</p>
                                <p class="text-sm font-extrabold text-indigo-600">{{ $item->views }} Kali Dipindai</p>
                            </div>
                        @endauth
                    </div>

                    <hr class="border-slate-100 mb-6">

                    <div class="space-y-5">
                        @if ($item->letterhead)
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800 mb-2">Atribut Kepala Surat</h3>
                                <div class="bg-slate-50 rounded-xl p-3 border border-slate-200 overflow-x-auto">
                                    <p class="text-slate-700 font-mono text-xs leading-relaxed whitespace-pre-line">
                                        {{ $item->letterhead }}</p>
                                </div>
                            </div>
                        @endif

                        @if ($item->deskripsi)
                            <div>
                                <h3 class="text-sm font-extrabold text-slate-800 mb-2">Uraian Ringkas</h3>
                                <p class="text-slate-600 text-sm leading-relaxed">{{ $item->deskripsi }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN (PREVIEW DOKUMEN) --}}
            {{-- Hanya Tampil Jika Admin & File Ada --}}
            @if (auth()->check())
                <div class="mt-6 lg:mt-0 lg:col-span-7 xl:col-span-8 animate__animated animate__fadeInRight">
                    <div
                        class="bg-slate-300/30 rounded-2xl md:rounded-[2rem] border border-slate-200/60 overflow-hidden shadow-inner h-[80vh] min-h-[600px] flex flex-col">

                        <!-- Toolbar Preview -->
                        <div class="bg-slate-800 text-white px-6 py-3 flex justify-between items-center shrink-0">
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <h3 class="text-sm font-bold tracking-wide">Pratinjau Dokumen Asli</h3>
                            </div>
                            <span
                                class="text-xs font-mono text-slate-400 bg-slate-900 px-2.5 py-1 rounded-md">{{ strtoupper($fileExtension) }}</span>
                        </div>

                        <!-- Area Preview -->
                        <div
                            class="preview-container flex-1 bg-[#525659] overflow-auto flex items-center justify-center p-4">
                            @if ($fileExists)
                                @if ($isPdf)
                                    <!-- Preview PDF -->
                                    <embed src="{{ $fileUrl }}#toolbar=1&navpanes=0" type="application/pdf"
                                        width="100%" height="100%" class="rounded shadow-2xl bg-white">
                                @elseif ($isImage)
                                    <!-- Preview Gambar -->
                                    <img src="{{ $fileUrl }}" alt="Preview Dokumen"
                                        class="max-w-full h-auto max-h-full object-contain rounded shadow-2xl bg-white">
                                @else
                                    <!-- Tipe File Lainnya -->
                                    <div class="bg-white p-8 rounded-2xl text-center shadow-lg">
                                        <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <h4 class="text-slate-800 font-bold mb-2">Pratinjau Tidak Tersedia</h4>
                                        <p class="text-sm text-slate-500 mb-4">Format file ini tidak mendukung pratinjau
                                            langsung di browser.</p>
                                        <a href="{{ $fileUrl }}" target="_blank"
                                            class="inline-block px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-bold hover:bg-indigo-700">
                                            Unduh Dokumen
                                        </a>
                                    </div>
                                @endif
                            @else
                                <div class="bg-white p-8 rounded-2xl text-center shadow-lg">
                                    <svg class="w-16 h-16 text-rose-300 mx-auto mb-4" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                            d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                                    </svg>
                                    <h4 class="text-slate-800 font-bold mb-2">Dokumen Fisik Tidak Ditemukan</h4>
                                    <p class="text-sm text-slate-500">File dokumen mungkin telah dihapus atau dipindahkan.
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
