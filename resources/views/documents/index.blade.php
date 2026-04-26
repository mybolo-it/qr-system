@extends('layouts.app')

@section('title', 'Arsip Dokumen - APG Portal')

@section('content')
    <style>
        /* Mengikuti tema aplikasi utama */
        .glass-panel {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
        }

        .form-input-glass {
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }

        .form-input-glass:focus {
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        /* Animasi Tabel */
        .stagger-row {
            opacity: 0;
            animation: fadeInRow 0.4s ease forwards;
        }

        @keyframes fadeInRow {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stagger-row:nth-child(1) {
            animation-delay: 0.05s;
        }

        .stagger-row:nth-child(2) {
            animation-delay: 0.10s;
        }

        .stagger-row:nth-child(3) {
            animation-delay: 0.15s;
        }

        .stagger-row:nth-child(4) {
            animation-delay: 0.20s;
        }

        .stagger-row:nth-child(5) {
            animation-delay: 0.25s;
        }

        /* Responsive Table Mode untuk Mobile */
        @media (max-width: 768px) {
            .hide-on-mobile {
                display: none;
            }

            .table-responsive-stack thead {
                display: none;
            }

            .table-responsive-stack tr {
                display: block;
                margin-bottom: 1rem;
                border-radius: 1rem;
                background: white;
                padding: 1rem;
                border: 1px solid #f1f5f9;
            }

            .table-responsive-stack td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 0.75rem 0;
                border-bottom: 1px dashed #e2e8f0;
                text-align: right;
            }

            .table-responsive-stack td:last-child {
                border-bottom: none;
                justify-content: center;
                padding-top: 1rem;
            }

            .table-responsive-stack td::before {
                content: attr(data-label);
                font-weight: 700;
                color: #64748b;
                text-align: left;
                font-size: 0.75rem;
                text-transform: uppercase;
                letter-spacing: 0.05em;
            }
        }
    </style>

    <div class="w-full">
        <div class="mb-8 animate__animated animate__fadeInDown">
            <div
                class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-indigo-600 via-indigo-800 to-slate-900 shadow-xl shadow-indigo-900/20 px-6 py-8 md:px-10 md:py-10 flex flex-col md:flex-row md:items-center justify-between gap-6 border border-indigo-500/30">

                <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-10 pointer-events-none">
                    <svg width="300" height="300" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <polygon points="12 2 22 8.5 12 15 2 8.5 12 2"></polygon>
                        <polygon points="12 6 22 12.5 12 19 2 12.5 12 6"></polygon>
                        <polygon points="12 10 22 16.5 12 23 2 16.5 12 10"></polygon>
                    </svg>
                </div>

                <div class="relative z-10">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-indigo-100 text-xs font-bold uppercase tracking-wider mb-4 border border-white/10 shadow-sm">
                        <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        Database Internal
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        Manajemen <span class="text-indigo-300">Arsip Dokumen</span>
                    </h1>
                    <p class="text-indigo-100/80 text-sm md:text-base mt-2 max-w-2xl">
                        Pusat pengelolaan, pencarian, dan audit dokumen digital PT Agung Putra Group.
                    </p>
                </div>

                @if (auth()->user()->isAdmin() || auth()->user()->isGlobalHR())
                    <div class="relative z-10 shrink-0 mt-4 md:mt-0">
                        <a href="{{ route('admin.form') }}"
                            class="group flex items-center justify-between gap-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white pl-6 pr-2 py-2 rounded-2xl text-sm font-bold shadow-lg transition-all active:scale-95">
                            <span class="tracking-wide">Terbitkan Dokumen</span>
                            <div
                                class="bg-indigo-500/40 group-hover:bg-indigo-500/60 transition-colors p-3 rounded-xl border border-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-5 mb-8 animate__animated animate__fadeIn">
            <form action="{{ route('documents.index') }}" method="GET"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 items-end">

                <div class="lg:col-span-2">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pencarian</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama, deskripsi, atau token..."
                            class="w-full pl-10 pr-4 py-2.5 form-input-glass rounded-xl text-sm text-slate-700">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori</label>
                    <select name="category_id"
                        class="w-full px-4 py-2.5 form-input-glass rounded-xl text-sm text-slate-700 appearance-none">
                        <option value="">Semua Kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ request('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Entitas
                        Perusahaan</label>
                    <select name="company_id"
                        class="w-full px-4 py-2.5 form-input-glass rounded-xl text-sm text-slate-700 appearance-none">
                        <option value="">Semua Perusahaan</option>
                        @foreach ($companies as $company)
                            <option value="{{ $company->id }}"
                                {{ request('company_id') == $company->id ? 'selected' : '' }}>
                                {{ $company->nama_perusahaan }} ({{ $company->kode_perusahaan }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <div class="w-full">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Tanggal</label>
                        <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                            class="w-full px-3 py-2.5 form-input-glass rounded-xl text-sm text-slate-700">
                    </div>
                    <div class="flex items-end gap-1">
                        <button type="submit"
                            class="p-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md transition-colors"
                            title="Terapkan Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                            </svg>
                        </button>
                        @if (request()->anyFilled(['search', 'category_id', 'company_id', 'tanggal']))
                            <a href="{{ route('documents.index') }}"
                                class="p-2.5 bg-slate-200 hover:bg-slate-300 text-slate-600 rounded-xl transition-colors"
                                title="Reset Filter">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </a>
                        @endif
                    </div>
                </div>
            </form>
        </div>

        <div
            class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden animate__animated animate__fadeInUp">
            <div class="overflow-x-auto">
                <table class="min-w-full table-responsive-stack text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 hide-on-mobile">
                        <tr>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest w-16">ID
                            </th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">Detail
                                Dokumen</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">Entitas &
                                Kategori</th>
                            <th
                                class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-center">
                                Status</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">Terbit
                            </th>
                            <th
                                class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-center w-28">
                                Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($items as $index => $item)
                            <tr class="stagger-row hover:bg-slate-50/80 transition-colors">

                                <td data-label="ID" class="px-6 py-4 text-sm font-bold text-slate-400">
                                    #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                </td>

                                <td data-label="Dokumen" class="px-6 py-4">
                                    <div class="flex flex-col">
                                        <span
                                            class="font-bold text-slate-800 text-sm md:text-base">{{ $item->nama }}</span>
                                        <span
                                            class="text-xs text-slate-500 mt-1 line-clamp-1 max-w-md">{{ $item->deskripsi }}</span>
                                        <div class="mt-2 flex items-center gap-2">
                                            <span
                                                class="inline-flex items-center gap-1 px-2 py-1 rounded bg-slate-100 text-[10px] font-mono text-slate-600 border border-slate-200">
                                                <svg class="w-3 h-3 text-slate-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 11c0 3.517-1.009 6.799-2.753 9.571m-3.44-2.04l.054-.09A13.916 13.916 0 008 11a4 4 0 118 0c0 1.017-.07 2.019-.203 3m-2.118 6.844A21.88 21.88 0 0015.171 17m3.839 1.132c.645-2.266.99-4.659.99-7.132A8 8 0 008 4.07M3 15.364c.64-1.319 1-2.8 1-4.364 0-1.457.39-2.823 1.07-4" />
                                                </svg>
                                                {{ substr($item->token, 0, 8) }}...
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td data-label="Klasifikasi" class="px-6 py-4">
                                    <div class="flex flex-col gap-1.5 items-start">
                                        <span
                                            class="px-2 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded uppercase tracking-wider">
                                            {{ $item->company ? $item->company->nama_perusahaan : 'ALL' }}
                                        </span>
                                        <span class="text-xs font-semibold text-slate-500">
                                            {{ $item->category ? $item->category->nama_kategori : 'Tanpa Kategori' }}
                                        </span>
                                    </div>
                                </td>

                                <td data-label="Status" class="px-6 py-4 text-center">
                                    @if ($item->status == 'published')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold">
                                            <span class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Valid
                                        </span>
                                    @elseif($item->status == 'draft')
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold">
                                            <span class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Draft
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold">
                                            <span class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Cabut
                                        </span>
                                    @endif
                                </td>

                                <td data-label="Waktu" class="px-6 py-4 text-sm font-medium text-slate-500">
                                    {{ $item->created_at->format('d M Y') }}
                                </td>

                                <td data-label="Opsi" class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ $item->file_url }}" target="_blank"
                                            class="p-2 bg-slate-100 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                            title="Lihat Lampiran">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                            </svg>
                                        </a>
                                        <a href="{{ route('item.show', $item->token) }}"
                                            class="p-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg shadow-sm hover:shadow transition-all"
                                            title="Verifikasi QR">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                            </svg>
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        <p class="text-slate-500 font-bold">Data Tidak Ditemukan</p>
                                        <p class="text-slate-400 text-sm mt-1">Coba sesuaikan kata kunci atau filter yang
                                            Anda gunakan.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($items->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    {{ $items->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
