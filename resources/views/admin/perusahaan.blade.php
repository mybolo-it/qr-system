@extends('layouts.app')

@section('title', 'Manajemen Perusahaan - APG Portal')

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
        editId: '',
        editNama: '',
        editKode: ''
    }">

        @if (session('success'))
            <div
                class="mb-4 px-4 py-3 bg-emerald-100 border border-emerald-300 text-emerald-800 rounded-xl font-medium animate__animated animate__fadeInDown">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-4 px-4 py-3 bg-red-100 border border-red-300 text-red-800 rounded-xl font-medium animate__animated animate__fadeInDown">
                {{ session('error') }}
            </div>
        @endif

        <div class="mb-8 animate__animated animate__fadeInDown">
            <div
                class="relative overflow-hidden rounded-[2rem] bg-gradient-to-r from-indigo-600 via-indigo-800 to-slate-900 shadow-xl shadow-indigo-900/20 px-6 py-8 md:px-10 md:py-10 flex flex-col md:flex-row md:items-center justify-between gap-6 border border-indigo-500/30">
                <div class="absolute right-0 top-1/2 -translate-y-1/2 translate-x-1/4 opacity-10 pointer-events-none">
                    <svg width="300" height="300" viewBox="0 0 24 24" fill="currentColor" class="text-white">
                        <path
                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
                <div class="relative z-10">
                    <div
                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-md text-indigo-100 text-xs font-bold uppercase tracking-wider mb-4 border border-white/10 shadow-sm">
                        <svg class="w-4 h-4 text-indigo-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Struktur Organisasi
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        Entitas <span class="text-indigo-300">Perusahaan</span>
                    </h1>
                    <p class="text-indigo-100/80 text-sm md:text-base mt-2 max-w-2xl">
                        Kelola daftar nama dan kode perusahaan yang tergabung dalam grup.
                    </p>
                </div>

                <div class="relative z-10 shrink-0 mt-4 md:mt-0">
                    <button type="button" @click="activeModal = 'create'"
                        class="group flex items-center justify-between gap-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white pl-6 pr-2 py-2 rounded-2xl text-sm font-bold shadow-lg transition-all active:scale-95 w-full md:w-auto">
                        <span class="tracking-wide">Tambah Entitas Baru</span>
                        <div
                            class="bg-indigo-500/40 group-hover:bg-indigo-500/60 transition-colors p-3 rounded-xl border border-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M12 4v16m8-8H4" />
                            </svg>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <div class="glass-panel rounded-2xl p-5 mb-8 animate__animated animate__fadeIn">
            <form action="{{ route('admin.perusahaan.index') }}" method="GET"
                class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 w-full">
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Cari Entitas</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Masukkan nama atau kode perusahaan..."
                            class="w-full pl-10 pr-4 py-2.5 form-input-glass rounded-xl text-sm text-slate-700">
                    </div>
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="p-2.5 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl shadow-md transition-colors"
                        title="Cari">
                        <span class="md:hidden px-2">Cari</span>
                        <svg class="w-5 h-5 hidden md:block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    @if (request()->filled('search'))
                        <a href="{{ route('admin.perusahaan.index') }}"
                            class="p-2.5 bg-slate-200 hover:bg-slate-300 text-slate-600 rounded-xl transition-colors"
                            title="Reset Filter">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div
            class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden animate__animated animate__fadeInUp">
            <div class="overflow-x-auto">
                <table class="min-w-full table-responsive-stack text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 hide-on-mobile">
                        <tr>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest w-20">ID
                            </th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">Nama
                                Perusahaan</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">Kode</th>
                            <th
                                class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-center w-32">
                                Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($companies as $company)
                            <tr class="stagger-row hover:bg-slate-50/80 transition-colors">
                                <td data-label="ID" class="px-6 py-4 text-sm font-bold text-slate-400">
                                    #{{ str_pad($company->id, 3, '0', STR_PAD_LEFT) }}
                                </td>
                                <td data-label="Nama" class="px-6 py-4 font-bold text-slate-800">
                                    {{ $company->nama_perusahaan }}
                                </td>
                                <td data-label="Kode" class="px-6 py-4">
                                    <span
                                        class="inline-flex items-center px-2.5 py-1 rounded-md bg-indigo-50 text-indigo-700 text-xs font-bold border border-indigo-100 uppercase tracking-wider">
                                        {{ $company->kode_perusahaan }}
                                    </span>
                                </td>
                                <td data-label="Opsi" class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button"
                                            @click="activeModal = 'edit'; editId = '{{ $company->id }}'; editNama = '{{ addslashes($company->nama_perusahaan) }}'; editKode = '{{ $company->kode_perusahaan }}'"
                                            class="p-2 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-lg shadow-sm hover:shadow transition-all"
                                            title="Edit Entitas">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>

                                        <form action="{{ route('admin.perusahaan.destroy', $company->id) }}"
                                            method="POST" class="inline-block"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus perusahaan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="p-2 bg-rose-50 text-rose-600 hover:bg-rose-600 hover:text-white rounded-lg shadow-sm hover:shadow transition-all"
                                                title="Hapus Entitas">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                        </svg>
                                        <p class="text-slate-500 font-bold">Data Perusahaan Tidak Ditemukan</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($companies->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    {{ $companies->links() }}
                </div>
            @endif
        </div>

        <div x-show="activeModal === 'create'" x-cloak class="relative z-[100]" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div x-show="activeModal === 'create'" x-transition.opacity
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="activeModal === 'create'" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                        class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200">
                        <form action="{{ route('admin.perusahaan.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="_modal" value="create">
                            <div class="bg-white px-6 pb-4 pt-6 sm:p-8">
                                <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                                    <h3 class="text-xl font-extrabold text-slate-800">Tambah Entitas Baru</h3>
                                    <button type="button" @click="activeModal = ''"
                                        class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Perusahaan <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="nama_perusahaan"
                                            value="{{ old('nama_perusahaan') }}" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800"
                                            placeholder="Contoh: PT Agung Putra Group">
                                        @if (old('_modal') == 'create')
                                            @error('nama_perusahaan')
                                                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Kode Perusahaan <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="kode_perusahaan"
                                            value="{{ old('kode_perusahaan') }}" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800 uppercase"
                                            placeholder="Contoh: APG">
                                        @if (old('_modal') == 'create')
                                            @error('kode_perusahaan')
                                                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-indigo-700 sm:ml-3 sm:w-auto transition-all">Simpan
                                    Entitas</button>
                                <button type="button" @click="activeModal = ''"
                                    class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="activeModal === 'edit'" x-cloak class="relative z-[100]" aria-labelledby="modal-title"
            role="dialog" aria-modal="true">
            <div x-show="activeModal === 'edit'" x-transition.opacity
                class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>
            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                    <div x-show="activeModal === 'edit'" x-transition:enter="ease-out duration-300"
                        x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95"
                        class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg border border-slate-200">
                        <form x-bind:action="`{{ url('/admin/perusahaan') }}/${editId}`" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="_modal" value="edit">
                            <div class="bg-white px-6 pb-4 pt-6 sm:p-8">
                                <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                                    <h3 class="text-xl font-extrabold text-slate-800">Edit Entitas</h3>
                                    <button type="button" @click="activeModal = ''"
                                        class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                                <div class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Nama Perusahaan <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="nama_perusahaan" x-model="editNama" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                        @if (old('_modal') == 'edit')
                                            @error('nama_perusahaan')
                                                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>
                                    <div>
                                        <label class="block text-sm font-bold text-slate-700 mb-2">Kode Perusahaan <span
                                                class="text-red-500">*</span></label>
                                        <input type="text" name="kode_perusahaan" x-model="editKode" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800 uppercase">
                                        @if (old('_modal') == 'edit')
                                            @error('kode_perusahaan')
                                                <p class="text-red-500 text-xs font-semibold mt-1">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-xl bg-amber-500 px-6 py-3 text-sm font-bold text-white shadow-md hover:bg-amber-600 sm:ml-3 sm:w-auto transition-all">Update
                                    Entitas</button>
                                <button type="button" @click="activeModal = ''"
                                    class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">Batal</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection
