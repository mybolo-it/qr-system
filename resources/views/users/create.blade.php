@extends('layouts.app')

@section('title', 'Tambah User')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

<style>
    body { background: #f4f7fe !important; }
    
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    .form-input {
        transition: all 0.3s ease;
    }

    .form-input:focus {
        border-color: #6366f1;
        box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
    }

    .input-error {
        border-color: #ef4444 !important;
        animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
    }

    @keyframes shake {
        10%, 90% { transform: translate3d(-1px, 0, 0); }
        20%, 80% { transform: translate3d(2px, 0, 0); }
        30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
        40%, 60% { transform: translate3d(4px, 0, 0); }
    }
</style>

<div class="max-w-3xl mx-auto px-4 py-10">
    <div class="mb-8 animate__animated animate__fadeInDown">
        <a href="{{ route('users.index') }}" class="text-indigo-600 flex items-center text-sm font-semibold mb-2 hover:text-indigo-800 transition">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Kembali ke Manajemen User
        </a>
        <h1 class="text-3xl font-extrabold text-gray-800">Tambah <span class="text-indigo-600">User Baru</span></h1>
    </div>

    <div class="glass-card rounded-[2rem] shadow-2xl overflow-hidden border border-white animate__animated animate__fadeInUp">
        <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-500"></div>
        
        <form action="{{ route('users.store') }}" method="POST" class="p-8 md:p-12">
            @csrf
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name') }}" 
                        class="form-input w-full px-5 py-3 rounded-xl border @error('name') input-error @else border-gray-200 @enderror bg-white/50"
                        placeholder="Masukkan nama pengguna">
                    @error('name')
                        <p class="text-red-500 text-xs font-semibold mt-1 ml-1 animate__animated animate__fadeIn">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="form-input w-full px-5 py-3 rounded-xl border @error('email') input-error @else border-gray-200 @enderror bg-white/50"
                        placeholder="email@contoh.com">
                    @error('email')
                        <p class="text-red-500 text-xs font-semibold mt-1 ml-1 animate__animated animate__fadeIn">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Hak Akses (Role)</label>
                    <select name="role" class="form-input w-full px-5 py-3 rounded-xl border @error('role') input-error @else border-gray-200 @enderror bg-white/50 appearance-none">
                        <option value="" disabled selected>Pilih Role...</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin (Pengelola Data)</option>
                        <option value="superadmin" {{ old('role') == 'superadmin' ? 'selected' : '' }}>Superadmin (Akses Penuh)</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-xs font-semibold mt-1 ml-1 animate__animated animate__fadeIn">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Password</label>
                    <input type="password" name="password" 
                        class="form-input w-full px-5 py-3 rounded-xl border @error('password') input-error @else border-gray-200 @enderror bg-white/50"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs font-semibold mt-1 ml-1 animate__animated animate__fadeIn">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" 
                        class="form-input w-full px-5 py-3 rounded-xl border @error('password') border-red-300 @else border-gray-200 @enderror bg-white/50"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="mt-10 flex items-center justify-end space-x-4">
                <a href="{{ route('users.index') }}" class="px-6 py-3 text-sm font-bold text-gray-500 hover:text-gray-700 transition">Batal</a>
                <button type="submit" 
                    class="bg-indigo-600 text-white px-8 py-3 rounded-2xl font-bold shadow-lg shadow-indigo-200 hover:bg-indigo-700 hover:-translate-y-1 transition-all active:scale-95">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection