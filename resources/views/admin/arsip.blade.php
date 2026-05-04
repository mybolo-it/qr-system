@extends('layouts.app')

@section('title', 'Arsip Dokumen - APG Portal')

@section('content')
    <style>
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

        /* Checkbox styling */
        .custom-checkbox {
            width: 1.25rem;
            height: 1.25rem;
            border-radius: 0.375rem;
            border: 2px solid #cbd5e1;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .custom-checkbox:checked {
            background-color: #4f46e5;
            border-color: #4f46e5;
        }

        .custom-checkbox:focus {
            outline: none;
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.2);
        }

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

    <div class="w-full" x-data="{
        activeModal: '{{ old('_modal', '') }}',
        showSuccessModal: {{ session('new_item') ? 'true' : 'false' }},
        selectedItems: [],
        toggleAll() {
            if (this.selectedItems.length === {{ count($items) }}) {
                this.selectedItems = [];
            } else {
                this.selectedItems = {{ json_encode($items->pluck('id')) }}.map(String);
            }
        }
    }">

        <!-- Notifikasi Sukses -->
        @if (session('success') && !session('new_item'))
            <div
                class="mb-4 p-4 bg-emerald-50 text-emerald-700 rounded-xl border border-emerald-200 text-sm font-bold flex items-center gap-3 animate__animated animate__fadeIn">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ session('success') }}
            </div>
        @endif

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
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">Manajemen <span
                            class="text-indigo-300">Arsip Dokumen</span></h1>
                    <p class="text-indigo-100/80 text-sm md:text-base mt-2 max-w-2xl">Pusat pengelolaan, pencarian, dan
                        audit dokumen digital PT Agung Putra Group.</p>
                </div>

                @if (auth()->user()->role === 'superadmin' ||
                        auth()->user()->role === 'hr_global' ||
                        auth()->user()->role === 'company_admin')
                    <div class="relative z-10 shrink-0 mt-4 md:mt-0">
                        <button type="button" @click="activeModal = 'create'"
                            class="group flex items-center justify-between gap-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white pl-6 pr-2 py-2 rounded-2xl text-sm font-bold shadow-lg transition-all active:scale-95 w-full md:w-auto">
                            <span class="tracking-wide">Terbitkan Dokumen</span>
                            <div
                                class="bg-indigo-500/40 group-hover:bg-indigo-500/60 transition-colors p-3 rounded-xl border border-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 4v16m8-8H4" />
                                </svg>
                            </div>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-5 mb-8 animate__animated animate__fadeIn">
            <form action="{{ route('admin.arsip') }}" method="GET"
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
                            placeholder="Cari nama, nomor, atau token..."
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
                @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'hr_global')
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
                @endif
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
                            <a href="{{ route('admin.arsip') }}"
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

        <!-- FORM HAPUS MASSAL -->
        <form action="{{ route('admin.arsip.bulk-destroy') }}" method="POST" id="bulk-delete-form">
            @csrf
            @method('DELETE')

            <div x-show="selectedItems.length > 0" x-transition.opacity
                class="mb-4 p-3 bg-white border border-rose-200 rounded-2xl shadow-sm flex items-center justify-between"
                style="display: none;">
                <span class="text-sm font-bold text-slate-600 pl-2">
                    <span x-text="selectedItems.length" class="text-rose-600"></span> Dokumen terpilih
                </span>
                <button type="submit"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white text-sm font-bold rounded-xl transition-colors shadow-sm"
                    onclick="return confirm('Anda yakin ingin menghapus semua dokumen yang dipilih secara permanen?');">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Hapus Dokumen
                </button>
            </div>

            <div
                class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden animate__animated animate__fadeInUp">
                <div class="overflow-x-auto">
                    <table class="min-w-full table-responsive-stack text-left">
                        <thead class="bg-slate-50 border-b border-slate-200 hide-on-mobile">
                            <tr>
                                <th class="px-6 py-4 w-12 text-center">
                                    <input type="checkbox" @change="toggleAll()"
                                        :checked="selectedItems.length === {{ count($items) }} && {{ count($items) }} > 0"
                                        class="custom-checkbox">
                                </th>
                                <th class="px-2 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest w-16">
                                    ID</th>
                                <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">
                                    Detail Dokumen</th>
                                @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'hr_global')
                                    <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">
                                        Entitas & Kategori</th>
                                @else
                                    <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">
                                        Kategori</th>
                                @endif
                                <th
                                    class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-center">
                                    Status</th>
                                <th
                                    class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-center">
                                    Tanggal Dibuat</th>
                                <th
                                    class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-center">
                                    Tanggal Update</th>
                                <th
                                    class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-center w-40">
                                    Opsi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse($items as $index => $item)
                                <tr class="stagger-row hover:bg-slate-50/80 transition-colors">
                                    <td data-label="Pilih" class="px-6 py-4 text-center">
                                        <input type="checkbox" name="ids[]" value="{{ $item->id }}"
                                            x-model="selectedItems" class="custom-checkbox">
                                    </td>
                                    <td data-label="ID" class="px-2 py-4 text-sm font-bold text-slate-400">
                                        #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}
                                    </td>
                                    <td data-label="Dokumen" class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span
                                                class="font-bold text-slate-800 text-sm md:text-base">{{ $item->nama }}</span>
                                            <span class="text-xs font-bold text-indigo-600 mt-0.5">No:
                                                {{ $item->nomor_surat ?? 'Belum ada nomor' }}</span>
                                            <span
                                                class="text-xs text-slate-500 mt-1 line-clamp-1 max-w-md">{{ $item->deskripsi }}</span>
                                        </div>
                                    </td>
                                    <td data-label="Klasifikasi" class="px-6 py-4">
                                        <div class="flex flex-col gap-1.5 items-start">
                                            @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'hr_global')
                                                <span
                                                    class="px-2 py-1 bg-indigo-50 text-indigo-700 text-[10px] font-bold rounded uppercase tracking-wider">
                                                    {{ $item->company ? $item->company->nama_perusahaan : 'ALL' }}
                                                </span>
                                            @endif
                                            <span class="text-xs font-semibold text-slate-500">
                                                {{ $item->category ? $item->category->nama_kategori : 'Tanpa Kategori' }}
                                            </span>
                                        </div>
                                    </td>
                                    <td data-label="Status" class="px-6 py-4 text-center">
                                        @if ($item->status == 'published')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-emerald-100 text-emerald-700 text-xs font-bold"><span
                                                    class="w-1.5 h-1.5 bg-emerald-500 rounded-full"></span> Valid</span>
                                        @elseif($item->status == 'draft')
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-amber-100 text-amber-700 text-xs font-bold"><span
                                                    class="w-1.5 h-1.5 bg-amber-500 rounded-full"></span> Draft</span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-red-100 text-red-700 text-xs font-bold"><span
                                                    class="w-1.5 h-1.5 bg-red-500 rounded-full"></span> Cabut</span>
                                        @endif
                                    </td>
                                    <td data-label="Tanggal Dibuat" class="px-6 py-4 text-center">
                                        <span
                                            class="text-sm font-bold text-slate-700">{{ $item->created_at ? $item->created_at->format('d M Y') : '-' }}</span>
                                        <span
                                            class="block text-xs text-slate-500">{{ $item->created_at ? $item->created_at->format('H:i') : '-' }}</span>
                                    </td>
                                    <td data-label="Tanggal Update" class="px-6 py-4 text-center">
                                        <span
                                            class="text-sm font-bold text-slate-700">{{ $item->updated_at ? $item->updated_at->format('d M Y') : '-' }}</span>
                                        <span
                                            class="block text-xs text-slate-500">{{ $item->updated_at ? $item->updated_at->format('H:i') : '-' }}</span>
                                    </td>
                                    <td data-label="Opsi" class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Tombol Edit -->
                                            <button type="button" @click="activeModal = 'edit-{{ $item->id }}'"
                                                class="p-2 bg-amber-100 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg shadow-sm hover:shadow transition-all"
                                                title="Edit Dokumen">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                                </svg>
                                            </button>

                                            <a href="{{ route('item.show', $item->token) }}" target="_blank"
                                                class="p-2 bg-indigo-600 text-white hover:bg-indigo-700 rounded-lg shadow-sm hover:shadow transition-all"
                                                title="Verifikasi QR">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z" />
                                                </svg>
                                            </a>
                                            <a href="{{ route('admin.arsip.download-qr', $item->id) }}"
                                                class="p-2 bg-emerald-100 text-emerald-600 hover:bg-emerald-600 hover:text-white rounded-lg shadow-sm hover:shadow transition-all"
                                                title="Unduh QR Code (SVG)">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                                </svg>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-16 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <svg class="w-12 h-12 text-slate-300 mb-3" fill="none"
                                                stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                            <p class="text-slate-500 font-bold">Data Tidak Ditemukan</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                @if ($items->hasPages())
                    <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">{{ $items->links() }}</div>
                @endif
            </div>
        </form>

        <!-- MODAL FORM CREATE -->
        <div x-show="activeModal === 'create'" x-cloak class="relative z-[100]" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div x-show="activeModal === 'create'" x-transition.opacity
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="activeModal === 'create'" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl border border-slate-200">
                        <form action="{{ route('admin.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="_modal" value="create">
                            <div class="bg-white px-6 pb-4 pt-6 sm:p-8">
                                <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                                    <div>
                                        <h3 class="text-xl font-extrabold text-slate-800">Terbitkan Dokumen Baru</h3>
                                        <p class="text-sm text-slate-500 mt-1">Unggah dokumen ke dalam arsip sistem dan
                                            buat QR otomatis.</p>
                                    </div>
                                    <button type="button" @click="activeModal = ''"
                                        class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition-colors"><svg
                                            class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg></button>
                                </div>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="block text-sm font-bold text-slate-700">Nama Dokumen <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="nama" value="{{ old('nama') }}" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800"
                                            placeholder="Contoh: SK Direksi 2024">
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="block text-sm font-bold text-slate-700">Nomor Surat <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="nomor_surat" value="{{ old('nomor_surat') }}"
                                            required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="block text-sm font-bold text-slate-700">Tanggal Surat <span
                                                class="text-red-500">*</span></label>
                                        <input type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}"
                                            required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                    </div>
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-slate-700">Kategori <span
                                                class="text-red-500">*</span></label>
                                        <select name="category_id" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                            <option value="" disabled selected>-- Pilih Kategori --</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'hr_global')
                                        <div class="space-y-2">
                                            <label class="block text-sm font-bold text-slate-700">Entitas Perusahaan <span
                                                    class="text-red-500">*</span></label>
                                            <select name="company_id" required
                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                                <option value="" disabled selected>-- Pilih Entitas --</option>
                                                @foreach ($companies as $company)
                                                    <option value="{{ $company->id }}">{{ $company->nama_perusahaan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="block text-sm font-bold text-slate-700">Status <span
                                                class="text-red-500">*</span></label>
                                        <select name="status" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                            <option value="published">Terbitkan (Valid)</option>
                                            <option value="draft">Draft</option>
                                        </select>
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="block text-sm font-bold text-slate-700">Lampiran Surat
                                            (Opsional)</label>
                                        <input type="file" name="file"
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-600">
                                    </div>
                                    <div class="space-y-2 md:col-span-2">
                                        <label class="block text-sm font-bold text-slate-700">Deskripsi</label>
                                        <textarea name="deskripsi" class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                <button type="submit"
                                    class="inline-flex w-full justify-center items-center gap-2 rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-indigo-700 sm:ml-3 sm:w-auto">Terbitkan
                                    & Generate QR</button>
                                <button type="button" @click="activeModal = ''"
                                    class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- LOOPING MODAL FORM EDIT -->
        @foreach ($items as $item)
            <div x-show="activeModal === 'edit-{{ $item->id }}'" x-cloak class="relative z-[100]"
                aria-labelledby="modal-title" role="dialog" aria-modal="true">
                <div x-show="activeModal === 'edit-{{ $item->id }}'" x-transition.opacity
                    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        <div x-show="activeModal === 'edit-{{ $item->id }}'"
                            x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-3xl border border-slate-200">

                            <form action="{{ route('admin.arsip.update', $item->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="_modal" value="edit-{{ $item->id }}">

                                <div class="bg-white px-6 pb-4 pt-6 sm:p-8">
                                    <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                                        <div>
                                            <h3 class="text-xl font-extrabold text-slate-800">Edit Dokumen
                                                #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</h3>
                                            <p class="text-sm text-slate-500 mt-1">Ubah rincian, status, atau perbarui
                                                lampiran file.</p>
                                        </div>
                                        <button type="button" @click="activeModal = ''"
                                            class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition-colors"><svg
                                                class="h-5 w-5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M6 18L18 6M6 6l12 12" />
                                            </svg></button>
                                    </div>
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="block text-sm font-bold text-slate-700">Nama Dokumen <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text" name="nama" value="{{ old('nama', $item->nama) }}"
                                                required
                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                        </div>
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="block text-sm font-bold text-slate-700">Nomor Surat <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text" name="nomor_surat"
                                                value="{{ old('nomor_surat', $item->nomor_surat) }}" required
                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                        </div>
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="block text-sm font-bold text-slate-700">Tanggal Surat <span
                                                    class="text-red-500">*</span></label>
                                            <input type="date" name="tanggal_surat"
                                                value="{{ old('tanggal_surat', $item->tanggal_surat ? \Carbon\Carbon::parse($item->tanggal_surat)->format('Y-m-d') : '') }}"
                                                required
                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                        </div>
                                        <div class="space-y-2">
                                            <label class="block text-sm font-bold text-slate-700">Kategori <span
                                                    class="text-red-500">*</span></label>
                                            <select name="category_id" required
                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $item->category_id == $category->id ? 'selected' : '' }}>
                                                        {{ $category->nama_kategori }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @if (auth()->user()->role === 'superadmin' || auth()->user()->role === 'hr_global')
                                            <div class="space-y-2">
                                                <label class="block text-sm font-bold text-slate-700">Entitas Perusahaan
                                                    <span class="text-red-500">*</span></label>
                                                <select name="company_id" required
                                                    class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                                    @foreach ($companies as $company)
                                                        <option value="{{ $company->id }}"
                                                            {{ $item->company_id == $company->id ? 'selected' : '' }}>
                                                            {{ $company->nama_perusahaan }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endif
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="block text-sm font-bold text-slate-700">Status <span
                                                    class="text-red-500">*</span></label>
                                            <select name="status" required
                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                                <option value="published"
                                                    {{ $item->status == 'published' ? 'selected' : '' }}>Terbitkan (Valid)
                                                </option>
                                                <option value="draft" {{ $item->status == 'draft' ? 'selected' : '' }}>
                                                    Draft</option>
                                                <option value="revoked"
                                                    {{ $item->status == 'revoked' ? 'selected' : '' }}>Cabut / Tidak Sah
                                                </option>
                                            </select>
                                        </div>
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="block text-sm font-bold text-slate-700">Ganti Lampiran File <span
                                                    class="text-xs font-normal text-slate-400 ml-2">(Biarkan kosong jika
                                                    tidak diganti)</span></label>
                                            <input type="file" name="file"
                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-600">
                                        </div>
                                        <div class="space-y-2 md:col-span-2">
                                            <label class="block text-sm font-bold text-slate-700">Deskripsi</label>
                                            <textarea name="deskripsi" class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">{{ old('deskripsi', $item->deskripsi) }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                    <button type="submit"
                                        class="inline-flex w-full justify-center items-center gap-2 rounded-xl bg-amber-600 px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-amber-700 sm:ml-3 sm:w-auto">Simpan
                                        Perubahan</button>
                                    <button type="button" @click="activeModal = ''"
                                        class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto">Batal</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- MODAL SUKSES & TAMPIL QR CODE -->
        @if (session('new_item'))
            <div x-show="showSuccessModal" x-cloak class="relative z-[150]" aria-labelledby="modal-title" role="dialog"
                aria-modal="true">
                <div x-show="showSuccessModal" x-transition.opacity
                    class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm transition-opacity"></div>
                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                        <div x-show="showSuccessModal" x-transition:enter="ease-out duration-300"
                            x-transition:enter-start="opacity-0 translate-y-8 sm:translate-y-0 sm:scale-95"
                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                            class="relative transform overflow-hidden rounded-[2rem] bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-md border border-slate-200">
                            <div
                                class="bg-gradient-to-br from-indigo-600 to-indigo-800 px-6 py-8 text-center text-white relative overflow-hidden">
                                <div class="absolute -right-10 -top-10 opacity-20"><svg width="150" height="150"
                                        viewBox="0 0 24 24" fill="currentColor">
                                        <polygon points="12 2 22 8.5 12 15 2 8.5 12 2"></polygon>
                                    </svg></div>
                                <div
                                    class="w-16 h-16 bg-white/20 rounded-full flex items-center justify-center mx-auto mb-4 backdrop-blur-md border border-white/30">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-extrabold mb-1">Terbit Sukses!</h3>
                                <p class="text-indigo-100 text-sm font-medium">Dokumen terdaftar resmi di dalam sistem</p>
                            </div>
                            <div class="px-6 py-8 text-center">
                                <div
                                    class="bg-slate-50 p-4 rounded-2xl border border-slate-100 inline-block mb-6 shadow-sm">
                                    <img src="data:image/svg+xml;base64,{{ session('new_item.qr_base64') }}"
                                        alt="QR Code Validasi" class="w-40 h-40 mx-auto">
                                </div>
                                <h4 class="text-lg font-bold text-slate-800 mb-1">{{ session('new_item.nama') }}</h4>
                                <p class="text-sm font-bold text-indigo-600 mb-4">{{ session('new_item.nomor_surat') }}
                                </p>
                                <div
                                    class="bg-indigo-50 text-indigo-700 text-sm p-4 rounded-xl text-left border border-indigo-100 mb-6 leading-relaxed">
                                    <strong class="font-bold">Pernyataan:</strong> Surat ini telah dienkripsi dan memiliki
                                    keabsahan sistem. Silakan letakkan/cetak QR Code ini pada dokumen fisik Anda. Pemindaian
                                    pada QR Code ini akan mengarahkan pihak terkait untuk memverifikasi keaslian dokumen
                                    secara langsung (Validasi Digital).
                                </div>
                                <div class="flex flex-col gap-3">
                                    <a href="{{ route('admin.arsip.download-qr', session('new_item.id')) }}"
                                        class="w-full flex items-center justify-center gap-2 bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition-all active:scale-95">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                        </svg>
                                        Unduh QR Code (SVG)
                                    </a>
                                    <button type="button" @click="showSuccessModal = false"
                                        class="w-full py-3.5 px-4 bg-white text-slate-600 hover:bg-slate-50 font-bold border border-slate-200 rounded-xl transition-all">
                                        Tutup Peringatan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
