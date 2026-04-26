@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div class="max-w-3xl mx-auto px-4 py-10 animate__animated animate__fadeIn">
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-gray-800">
            Edit <span class="text-indigo-600">Profil</span>
        </h1>
        <p class="text-gray-500 text-sm mt-1">Perbarui informasi akun Anda dengan aman.</p>
    </div>

    <div class="glass-card rounded-[2.5rem] shadow-2xl overflow-hidden border border-white">
        <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
        
        <form action="{{ route('profile.update') }}" method="POST" class="p-8 md:p-12 space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-2 col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" 
                        class="w-full px-5 py-4 rounded-2xl border transition-all duration-300 focus:ring-4 focus:ring-indigo-100 outline-none
                        {{ $errors->has('name') ? 'border-red-500 bg-red-50' : 'border-gray-200 focus:border-indigo-500 bg-white/50' }}" 
                        placeholder="Masukkan nama Anda">
                    @error('name') 
                        <p class="text-red-500 text-xs font-semibold mt-1 ml-2 animate__animated animate__headShake">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="space-y-2 col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-400 ml-1 flex items-center">
                        Email 
                        <svg class="w-3 h-3 ml-2" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"/></svg>
                    </label>
                    <input type="email" value="{{ $user->email }}" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-100 bg-gray-100/50 text-gray-400 cursor-not-allowed outline-none font-medium" 
                        readonly title="Email tidak dapat diubah">
                    <p class="text-[10px] text-gray-400 ml-2 italic">*Hubungi admin untuk ganti email.</p>
                </div>

                <div class="col-span-2 border-t border-gray-100 my-2"></div>

                <div class="space-y-2 col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 ml-1 text-indigo-600">Password Baru</label>
                    <input type="password" name="password" 
                        class="w-full px-5 py-4 rounded-2xl border transition-all duration-300 focus:ring-4 focus:ring-indigo-100 outline-none
                        {{ $errors->has('password') ? 'border-red-500 bg-red-50' : 'border-gray-200 focus:border-indigo-500 bg-white/50' }}"
                        placeholder="••••••••">
                    @error('password') 
                        <p class="text-red-500 text-xs font-semibold mt-1 ml-2 animate__animated animate__headShake">{{ $message }}</p> 
                    @enderror
                </div>

                <div class="space-y-2 col-span-2 md:col-span-1">
                    <label class="block text-sm font-bold text-gray-700 ml-1">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" 
                        class="w-full px-5 py-4 rounded-2xl border border-gray-200 focus:border-indigo-500 focus:ring-4 focus:ring-indigo-100 bg-white/50 outline-none transition-all duration-300"
                        placeholder="••••••••">
                </div>
            </div>

            <div class="pt-6 flex flex-col md:flex-row items-center gap-4">
                <button type="submit" 
                    class="w-full md:w-auto bg-indigo-600 hover:bg-indigo-700 text-white px-10 py-4 rounded-2xl font-bold shadow-xl shadow-indigo-200 hover:scale-[1.02] active:scale-95 transition-all duration-300">
                    Simpan Perubahan
                </button>
                <a href="{{ route('home') }}" 
                    class="w-full md:w-auto text-center px-10 py-4 rounded-2xl font-bold text-gray-500 hover:bg-gray-100 transition-all">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<style>
    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
    }
</style>
@endsection