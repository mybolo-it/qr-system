@extends('layouts.app')

@section('title', 'Edit User')

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

    /* Efek getar jika error */
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
            Kembali ke List User
        </a>
        <h1 class="text-3xl font-extrabold text-gray-800">Edit <span class="text-indigo-600">Profil User</span></h1>
        <p class="text-gray-500 text-sm mt-1">Perbarui informasi akun atau hak akses pengguna.</p>
    </div>

    <div class="glass-card rounded-[2.5rem] shadow-2xl overflow-hidden border border-white animate__animated animate__fadeInUp">
        <div class="h-2.5 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-500"></div>
        
        <form action="{{ route('users.update', $user) }}" method="POST" class="p-8 md:p-12">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                        class="form-input w-full px-5 py-3 rounded-2xl border @error('name') input-error @else border-gray-200 @enderror bg-white/50"
                        placeholder="Masukkan nama">
                    @error('name')
                        <p class="text-red-500 text-xs font-semibold mt-1 ml-1 animate__animated animate__headShake">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Alamat Email</label>
                    <input type="email" name="email" value="{{ old('email', $user->email) }}"
                        class="form-input w-full px-5 py-3 rounded-2xl border @error('email') input-error @else border-gray-200 @enderror bg-white/50"
                        placeholder="email@contoh.com">
                    @error('email')
                        <p class="text-red-500 text-xs font-semibold mt-1 ml-1 animate__animated animate__headShake">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Hak Akses</label>
                    <div class="relative">
                        <select name="role" class="form-input w-full px-5 py-3 rounded-2xl border @error('role') input-error @else border-gray-200 @enderror bg-white/50 appearance-none cursor-pointer">
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Pengelola Data)</option>
                            <option value="superadmin" {{ old('role', $user->role) == 'superadmin' ? 'selected' : '' }}>Superadmin (Akses Penuh)</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400">
                            <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </div>
                    </div>
                </div>

                <div class="md:col-span-2 pt-4">
                    <div class="bg-indigo-50/50 rounded-2xl p-4 border border-indigo-100/50">
                        <p class="text-indigo-700 text-xs font-bold uppercase tracking-wider mb-1">Ganti Password</p>
                        <p class="text-gray-500 text-xs italic">Kosongkan kolom di bawah ini jika Anda tidak ingin mengubah password user.</p>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Password Baru</label>
                    <input type="password" name="password" 
                        class="form-input w-full px-5 py-3 rounded-2xl border @error('password') input-error @else border-gray-200 @enderror bg-white/50"
                        placeholder="••••••••">
                    @error('password')
                        <p class="text-red-500 text-xs font-semibold mt-1 ml-1 animate__animated animate__headShake">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" 
                        class="form-input w-full px-5 py-3 rounded-2xl border border-gray-200 bg-white/50"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="mt-12 flex items-center justify-end space-x-4">
                <a href="{{ route('users.index') }}" class="px-6 py-3 text-sm font-bold text-gray-400 hover:text-gray-600 transition">Batal</a>
                <button type="submit" 
                    class="bg-gradient-to-r from-indigo-600 to-purple-600 text-white px-10 py-3.5 rounded-2xl font-bold shadow-xl shadow-indigo-100 hover:shadow-indigo-300 hover:-translate-y-1 transition-all active:scale-95">
                    Update Data
                </button>
            </div>
        </form>
    </div>
</div>
@endsection