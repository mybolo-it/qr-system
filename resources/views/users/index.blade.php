@extends('layouts.app')

@section('title', 'Manajemen Pengguna Akses - APG Portal')

@section('content')
    @php use Illuminate\Support\Facades\Crypt; @endphp
    <style>
        /* Styling mengikuti standar Dokumen Arsip */
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

        /* Responsive Mobile */
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

    <div class="w-full" x-data="{ activeModal: '{{ old('_modal', '') }}' }">

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
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                        </svg>
                        Hak Akses Sistem
                    </div>
                    <h1 class="text-3xl md:text-4xl font-extrabold text-white tracking-tight">
                        Pengguna <span class="text-indigo-300">Akses</span>
                    </h1>
                    <p class="text-indigo-100/80 text-sm md:text-base mt-2 max-w-2xl">
                        Kelola pendaftaran, hak akses, dan kontrol pengguna portal E-Office.
                    </p>
                </div>

                @if (auth()->user()->role === 'superadmin')
                    <div class="relative z-10 shrink-0 mt-4 md:mt-0">
                        <button type="button" @click="activeModal = 'create'"
                            class="group flex items-center justify-between gap-4 bg-white/10 hover:bg-white/20 backdrop-blur-md border border-white/20 text-white pl-6 pr-2 py-2 rounded-2xl text-sm font-bold shadow-lg transition-all active:scale-95 w-full md:w-auto">
                            <span class="tracking-wide">Tambah Pengguna Baru</span>
                            <div
                                class="bg-indigo-500/40 group-hover:bg-indigo-500/60 transition-colors p-3 rounded-xl border border-white/10 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                </svg>
                            </div>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div
            class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden animate__animated animate__fadeInUp">
            <div class="overflow-x-auto">
                <table class="min-w-full table-responsive-stack text-left">
                    <thead class="bg-slate-50 border-b border-slate-200 hide-on-mobile">
                        <tr>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest w-16">No
                            </th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">Detail
                                Pengguna</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">Kontak &
                                Email</th>
                            <th class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest">Peran
                                (Role)</th>
                            <th
                                class="px-6 py-4 text-xs font-extrabold text-slate-500 uppercase tracking-widest text-center w-32">
                                Opsi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($users as $index => $user)
                            @php $encryptedId = Crypt::encrypt($user->id); @endphp
                            <tr class="stagger-row hover:bg-slate-50/80 transition-colors">

                                <td data-label="No" class="px-6 py-4 text-sm font-bold text-slate-400">
                                    {{ $users->firstItem() + $index }}
                                </td>

                                <td data-label="Pengguna" class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 text-indigo-700 flex items-center justify-center font-extrabold text-sm border border-indigo-200/50 shadow-sm">
                                            {{ strtoupper(substr($user->name, 0, 1)) }}
                                        </div>
                                        <div class="flex flex-col">
                                            <span class="font-bold text-slate-800">{{ $user->name }}</span>
                                            @if ($user->id === auth()->id())
                                                <span
                                                    class="text-[10px] text-emerald-600 font-bold uppercase tracking-wider">Anda
                                                    Sendiri</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>

                                <td data-label="Kontak" class="px-6 py-4">
                                    <span class="text-sm font-medium text-slate-500">{{ $user->email }}</span>
                                </td>

                                <td data-label="Peran" class="px-6 py-4">
                                    @if ($user->role == 'superadmin')
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-rose-50 text-rose-700 text-xs font-extrabold uppercase tracking-wider border border-rose-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Super Admin
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded bg-indigo-50 text-indigo-700 text-xs font-extrabold uppercase tracking-wider border border-indigo-100">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Company Admin
                                        </span>
                                    @endif
                                </td>

                                <td data-label="Opsi" class="px-6 py-4 text-center">
                                    @if (auth()->user()->role === 'superadmin')
                                        <div class="flex justify-center items-center gap-2">
                                            <button type="button" @click="activeModal = 'edit-{{ $user->id }}'"
                                                class="p-2 bg-slate-100 text-slate-600 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors"
                                                title="Edit Pengguna">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>
                                            </button>

                                            @if ($user->id !== auth()->id())
                                                <form id="delete-form-{{ $user->id }}"
                                                    action="{{ route('users.destroy', $encryptedId) }}" method="POST"
                                                    class="hidden">
                                                    @csrf
                                                    @method('DELETE')
                                                </form>
                                                <button type="button"
                                                    onclick="confirmDelete('{{ $user->id }}', '{{ $user->name }}')"
                                                    class="p-2 bg-slate-100 text-slate-600 hover:text-rose-600 hover:bg-rose-50 rounded-lg transition-colors"
                                                    title="Hapus Pengguna">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    @else
                                        <span class="text-xs text-slate-400 italic">No Access</span>
                                    @endif
                                </td>
                            </tr>

                            <div x-show="activeModal === 'edit-{{ $user->id }}'" x-cloak class="relative z-[100]"
                                aria-labelledby="modal-title" role="dialog" aria-modal="true">
                                <div x-show="activeModal === 'edit-{{ $user->id }}'" x-transition.opacity
                                    class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity"></div>

                                <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                                    <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
                                        <div x-show="activeModal === 'edit-{{ $user->id }}'"
                                            x-transition:enter="ease-out duration-300"
                                            x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave="ease-in duration-200"
                                            x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                                            x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                                            class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-200">

                                            <form action="{{ route('users.update', $encryptedId) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="_modal" value="edit-{{ $user->id }}">

                                                <div class="bg-white px-6 pb-4 pt-6 sm:p-8">
                                                    <div class="flex justify-between items-center mb-6">
                                                        <div>
                                                            <h3 class="text-xl font-extrabold text-slate-800"
                                                                id="modal-title">Edit Data Pengguna</h3>
                                                            <p class="text-sm text-slate-500 mt-1">Perbarui informasi untuk
                                                                akun {{ $user->name }}.</p>
                                                        </div>
                                                        <button type="button" @click="activeModal = ''"
                                                            class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition-colors">
                                                            <svg class="h-5 w-5" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>

                                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                        <div class="space-y-2">
                                                            <label class="block text-sm font-bold text-slate-700">Nama
                                                                Lengkap</label>
                                                            <input type="text" name="name"
                                                                value="{{ old('name', $user->name) }}" required
                                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                                            @if (old('_modal') == 'edit-' . $user->id)
                                                                @error('name')
                                                                    <p class="text-red-500 text-xs font-semibold">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            @endif
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label class="block text-sm font-bold text-slate-700">Alamat
                                                                Email</label>
                                                            <input type="email" name="email"
                                                                value="{{ old('email', $user->email) }}" required
                                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800">
                                                            @if (old('_modal') == 'edit-' . $user->id)
                                                                @error('email')
                                                                    <p class="text-red-500 text-xs font-semibold">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            @endif
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label class="block text-sm font-bold text-slate-700">Peran
                                                                Akses (Role)</label>
                                                            <select name="role" required
                                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800 appearance-none">
                                                                <option value="company_admin"
                                                                    {{ old('role', $user->role) == 'company_admin' ? 'selected' : '' }}>
                                                                    Company Admin</option>
                                                                <option value="superadmin"
                                                                    {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>
                                                                    Super Admin</option>
                                                            </select>
                                                            @if (old('_modal') == 'edit-' . $user->id)
                                                                @error('role')
                                                                    <p class="text-red-500 text-xs font-semibold">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            @endif
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label class="block text-sm font-bold text-slate-700">Entitas
                                                                Perusahaan</label>
                                                            <select name="company_id"
                                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800 appearance-none">
                                                                <option value="">-- Tanpa Perusahaan --</option>
                                                                @foreach ($companies as $company)
                                                                    <option value="{{ $company->id }}"
                                                                        {{ old('company_id', $user->company_id) == $company->id ? 'selected' : '' }}>
                                                                        {{ $company->kode_perusahaan }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @if (old('_modal') == 'edit-' . $user->id)
                                                                @error('company_id')
                                                                    <p class="text-red-500 text-xs font-semibold">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            @endif
                                                        </div>

                                                        <div class="md:col-span-2 pt-4 border-t border-slate-100">
                                                            <p
                                                                class="text-xs font-bold text-amber-600 mb-4 bg-amber-50 p-3 rounded-lg border border-amber-100">
                                                                * Kosongkan kolom password di bawah ini jika Anda tidak
                                                                ingin mengubah sandi pengguna.
                                                            </p>
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label class="block text-sm font-bold text-slate-700">Password
                                                                Baru</label>
                                                            <input type="password" name="password"
                                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800"
                                                                placeholder="••••••••">
                                                            @if (old('_modal') == 'edit-' . $user->id)
                                                                @error('password')
                                                                    <p class="text-red-500 text-xs font-semibold">
                                                                        {{ $message }}</p>
                                                                @enderror
                                                            @endif
                                                        </div>

                                                        <div class="space-y-2">
                                                            <label class="block text-sm font-bold text-slate-700">Ulangi
                                                                Password Baru</label>
                                                            <input type="password" name="password_confirmation"
                                                                class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800"
                                                                placeholder="••••••••">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div
                                                    class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                                    <button type="submit"
                                                        class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto transition-colors">
                                                        Simpan Perubahan
                                                    </button>
                                                    <button type="button" @click="activeModal = ''"
                                                        class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">
                                                        Batal
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-16 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <svg class="w-12 h-12 text-slate-300 mb-3" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                        </svg>
                                        <p class="text-slate-500 font-bold">Data Pengguna Kosong</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($users->hasPages())
                <div class="px-6 py-4 bg-slate-50 border-t border-slate-100">
                    {{ $users->links() }}
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
                        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave="ease-in duration-200"
                        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
                        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                        class="relative transform overflow-hidden rounded-3xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-2xl border border-slate-200">

                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="_modal" value="create">

                            <div class="bg-white px-6 pb-4 pt-6 sm:p-8">
                                <div class="flex justify-between items-center mb-6">
                                    <div>
                                        <h3 class="text-xl font-extrabold text-slate-800" id="modal-title">Tambah Pengguna
                                            Baru</h3>
                                        <p class="text-sm text-slate-500 mt-1">Daftarkan akun untuk staf atau administrator
                                            baru.</p>
                                    </div>
                                    <button type="button" @click="activeModal = ''"
                                        class="text-slate-400 hover:text-slate-600 bg-slate-100 hover:bg-slate-200 p-2 rounded-full transition-colors">
                                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-slate-700">Nama Lengkap</label>
                                        <input type="text" name="name" value="{{ old('name') }}" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800"
                                            placeholder="Contoh: Dimas Suhendra">
                                        @if (old('_modal') == 'create')
                                            @error('name')
                                                <p class="text-red-500 text-xs font-semibold">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-slate-700">Alamat Email</label>
                                        <input type="email" name="email" value="{{ old('email') }}" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800"
                                            placeholder="nama@perusahaan.com">
                                        @if (old('_modal') == 'create')
                                            @error('email')
                                                <p class="text-red-500 text-xs font-semibold">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-slate-700">Peran Akses (Role)</label>
                                        <select name="role" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800 appearance-none">
                                            <option value="" disabled selected>-- Pilih Peran --</option>
                                            <option value="company_admin"
                                                {{ old('role') == 'company_admin' ? 'selected' : '' }}>Company Admin
                                            </option>
                                            <option value="superadmin"
                                                {{ old('role') == 'superadmin' ? 'selected' : '' }}>Super Admin</option>
                                        </select>
                                        @if (old('_modal') == 'create')
                                            @error('role')
                                                <p class="text-red-500 text-xs font-semibold">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-slate-700">Entitas Perusahaan</label>
                                        <select name="company_id"
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800 appearance-none">
                                            <option value="">-- Tanpa Perusahaan --</option>
                                            @foreach ($companies as $company)
                                                <option value="{{ $company->id }}"
                                                    {{ old('company_id') == $company->id ? 'selected' : '' }}>
                                                    {{ $company->kode_perusahaan }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @if (old('_modal') == 'create')
                                            @error('company_id')
                                                <p class="text-red-500 text-xs font-semibold">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-slate-700">Password</label>
                                        <input type="password" name="password" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800"
                                            placeholder="Minimal 6 karakter">
                                        @if (old('_modal') == 'create')
                                            @error('password')
                                                <p class="text-red-500 text-xs font-semibold">{{ $message }}</p>
                                            @enderror
                                        @endif
                                    </div>

                                    <div class="space-y-2">
                                        <label class="block text-sm font-bold text-slate-700">Ulangi Password</label>
                                        <input type="password" name="password_confirmation" required
                                            class="w-full px-4 py-3 form-input-glass rounded-xl text-sm text-slate-800"
                                            placeholder="Minimal 6 karakter">
                                    </div>
                                </div>
                            </div>
                            <div class="bg-slate-50 px-6 py-4 sm:flex sm:flex-row-reverse border-t border-slate-100">
                                <button type="submit"
                                    class="inline-flex w-full justify-center rounded-xl bg-indigo-600 px-6 py-3 text-sm font-bold text-white shadow-sm hover:bg-indigo-700 sm:ml-3 sm:w-auto transition-colors">
                                    Daftarkan Akun
                                </button>
                                <button type="button" @click="activeModal = ''"
                                    class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-6 py-3 text-sm font-bold text-slate-700 shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 sm:mt-0 sm:w-auto transition-colors">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@endsection

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(userId, userName) {
        Swal.fire({
            title: 'Hapus Akses?',
            html: `Anda akan menghapus akun <b>${userName}</b> secara permanen.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e11d48', // Rose 600
            cancelButtonColor: '#f1f5f9', // Slate 100
            confirmButtonText: 'Ya, Hapus Permanen!',
            cancelButtonText: '<span style="color: #475569;">Batal</span>', // Slate 600
            customClass: {
                popup: 'rounded-3xl border border-slate-200 shadow-2xl',
                title: 'font-extrabold text-slate-800',
                htmlContainer: 'text-sm text-slate-500 font-medium',
                confirmButton: 'rounded-xl px-6 py-3 font-bold shadow-md hover:shadow-lg transition-all',
                cancelButton: 'rounded-xl px-6 py-3 font-bold shadow-sm ring-1 ring-inset ring-slate-300 hover:bg-slate-50 transition-all'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + userId).submit();
            }
        })
    }
</script>
