@extends('layouts.app')

@section('title', 'Portal Informasi Publik')

@section('content')
    <style>
        /* Jika ingin background dashboard ini sedikit berbeda dari app.blade.php */
        .dashboard-wrapper {
            background-color: transparent;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.65);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.8);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .glass-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 30px -5px rgba(99, 102, 241, 0.15), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            border-color: rgba(99, 102, 241, 0.3);
        }

        .qr-wrapper {
            background: white;
            padding: 12px;
            border-radius: 1.25rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), inset 0 2px 4px rgba(0, 0, 0, 0.02);
            transition: transform 0.3s ease;
        }

        .glass-card:hover .qr-wrapper {
            transform: scale(1.05);
        }
    </style>

    <div class="w-full px-4 sm:px-8 lg:px-12 dashboard-wrapper">

        <div
            class="flex flex-col lg:flex-row justify-between items-start lg:items-end gap-6 mb-12 animate__animated animate__fadeInDown">
            <div class="max-w-2xl">
                <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 tracking-tight leading-tight">
                    Portal Verifikasi Publik
                </h1>
                <p class="text-slate-500 mt-3 text-sm md:text-base leading-relaxed">
                    Akses pusat informasi dan verifikasi keaslian dokumen terpadu. Pindai QR Code untuk memvalidasi dokumen
                    fisik Anda.
                </p>
            </div>

            <div class="w-full lg:w-auto flex-shrink-0">
                <form action="{{ url()->current() }}" method="GET" class="relative group">
                    <div
                        class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-indigo-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama dokumen..."
                        class="w-full lg:w-80 pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl text-slate-800 focus:outline-none focus:ring-4 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm placeholder:text-slate-400 font-medium">
                </form>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12 animate__animated animate__fadeInUp">
            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center gap-5">
                <div class="p-4 bg-blue-50 text-blue-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500">Total Dokumen</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $items->count() }} <span
                            class="text-sm font-medium text-slate-400">Berkas</span></h3>
                </div>
            </div>

            <div class="bg-white rounded-2xl p-6 border border-slate-200 shadow-sm flex items-center gap-5">
                <div class="p-4 bg-emerald-50 text-emerald-600 rounded-xl">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-semibold text-slate-500">Total Pemindaian</p>
                    <h3 class="text-2xl font-bold text-slate-800">{{ $items->sum('views') }} <span
                            class="text-sm font-medium text-slate-400">Kali</span></h3>
                </div>
            </div>

            <div
                class="bg-gradient-to-br from-indigo-600 to-slate-800 rounded-2xl p-6 shadow-md flex items-center justify-between overflow-hidden relative group">
                <div
                    class="absolute right-0 top-0 opacity-10 transform translate-x-4 -translate-y-4 group-hover:rotate-12 transition-transform duration-500">
                    <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" />
                    </svg>
                </div>
                <div class="relative z-10 text-white">
                    <p class="text-sm font-medium text-indigo-200 mb-1">Akses Sistem</p>
                    <h3 class="text-lg font-bold leading-tight">Masuk sebagai Admin?</h3>
                </div>
                <a href="{{ route('login') }}"
                    class="relative z-10 p-3 bg-white/20 hover:bg-white text-white hover:text-indigo-600 rounded-xl backdrop-blur-md transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                    </svg>
                </a>
            </div>
        </div>

        @if ($items->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-8">
                @foreach ($items as $index => $item)
                    <div class="glass-card rounded-3xl overflow-hidden flex flex-col animate__animated animate__fadeInUp"
                        style="animation-delay: {{ $index * 0.1 }}s">

                        <div class="p-6 flex-grow">
                            <div class="flex justify-between items-start mb-4">
                                <span
                                    class="px-3 py-1.5 bg-slate-100 text-slate-600 text-[11px] font-extrabold rounded-lg tracking-wider">
                                    DOKUMEN #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                </span>
                                <span
                                    class="flex items-center gap-1 text-xs font-bold text-emerald-600 bg-emerald-50 px-2 py-1 rounded-md">
                                    <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Valid
                                </span>
                            </div>

                            <h3 class="font-extrabold text-xl text-slate-800 leading-snug mb-3 line-clamp-2">
                                {{ $item->nama }}
                            </h3>

                            <p class="text-slate-500 text-sm leading-relaxed mb-6 line-clamp-3">
                                {{ $item->deskripsi ?: 'Tidak ada deskripsi tersedia untuk dokumen ini.' }}
                            </p>

                            <div
                                class="flex items-center justify-between bg-slate-50/50 rounded-2xl p-4 border border-slate-100">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Pindai QR</p>
                                    <p class="text-sm font-semibold text-slate-700">Gunakan kamera ponsel</p>
                                </div>
                                <div class="qr-wrapper">
                                    {!! QrCode::size(80)->style('round')->margin(0)->generate($item->detail_url) !!}
                                </div>
                            </div>
                        </div>

                        <div class="px-6 py-5 bg-white border-t border-slate-100 flex flex-col gap-4">
                            <div class="flex justify-between items-center text-xs font-bold text-slate-400">
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-slate-300" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $item->created_at->format('d M Y') }}
                                </div>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-indigo-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    {{ $item->views }} views
                                </div>
                            </div>

                            <a href="{{ route('item.show', $item->token) }}"
                                class="w-full flex items-center justify-center gap-2 py-3 bg-slate-800 text-white text-sm font-bold rounded-xl hover:bg-indigo-600 transition-colors focus:ring-4 focus:ring-indigo-100">
                                Lihat Detail
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </a>
                        </div>

                    </div>
                @endforeach
            </div>
        @else
            <div
                class="text-center py-24 bg-white rounded-3xl border border-slate-200 shadow-sm animate__animated animate__fadeIn">
                <div
                    class="inline-flex items-center justify-center w-24 h-24 bg-slate-50 text-slate-300 rounded-full mb-6 border-4 border-white shadow-md">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                @if (request('search'))
                    <h3 class="text-2xl font-extrabold text-slate-800">Dokumen Tidak Ditemukan</h3>
                    <p class="text-slate-500 mt-2 font-medium">Tidak ada dokumen yang cocok dengan kata kunci
                        "{{ request('search') }}".</p>
                    <a href="{{ route('home') }}"
                        class="mt-6 inline-block text-indigo-600 font-bold hover:underline">Hapus Pencarian</a>
                @else
                    <h3 class="text-2xl font-extrabold text-slate-800">Belum Ada Dokumen Terpublikasi</h3>
                    <p class="text-slate-500 mt-2 font-medium">Data dokumen yang diterbitkan akan otomatis muncul di
                        halaman ini.</p>
                @endif
            </div>
        @endif
    </div>
@endsection
