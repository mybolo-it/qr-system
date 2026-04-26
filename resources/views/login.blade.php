@extends('layouts.app')

@section('title', 'Login Admin')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Poppins', sans-serif; }
    .glass-effect {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.2);
    }
    .bg-gradient-custom {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
</style>

<div class="min-h-[80vh] flex items-center justify-center px-4">
    <div class="max-w-md w-full animate__animated animate__fadeInUp">
        
        <div class="glass-effect rounded-2xl shadow-2xl overflow-hidden">
            
            <div class="bg-gradient-custom p-8 text-center">
                <div class="inline-flex items-center justify-center w-16 h-16 bg-white/20 rounded-full mb-4 animate__animated animate__pulse animate__infinite">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-white tracking-tight">Welcome Backk</h2>
                <p class="text-indigo-100 text-sm mt-2">Silahkan login ke panel admin</p>
            </div>

            <div class="p-8">
                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf
                    
                    <div class="relative group">
                        <label for="email" class="text-xs font-semibold text-gray-500 uppercase tracking-wider ml-1">Email Address</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 11-8 0 4 4 0 018 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"/></svg>
                            </span>
                            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus 
                                class="block w-full pl-10 pr-3 py-3 border-b-2 border-gray-200 focus:border-indigo-500 bg-transparent outline-none transition-all duration-300 @error('email') border-red-500 @enderror"
                                placeholder="admin@example.com">
                        </div>
                        @error('email')
                            <p class="text-red-500 text-xs italic mt-2 animate__animated animate__shakeX">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="relative group">
                        <label for="password" class="text-xs font-semibold text-gray-500 uppercase tracking-wider ml-1">Password</label>
                        <div class="relative mt-1">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400 group-focus-within:text-indigo-500 transition-colors">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                            </span>
                            <input type="password" name="password" id="password" required 
                                class="block w-full pl-10 pr-3 py-3 border-b-2 border-gray-200 focus:border-indigo-500 bg-transparent outline-none transition-all duration-300 @error('password') border-red-500 @enderror"
                                placeholder="••••••••">
                        </div>
                        @error('password')
                            <p class="text-red-500 text-xs italic mt-2 animate__animated animate__shakeX">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" 
                        class="w-full bg-gradient-custom text-white font-bold py-3 px-4 rounded-xl shadow-lg hover:shadow-indigo-500/50 transform hover:-translate-y-1 transition duration-300 focus:ring-4 focus:ring-indigo-300">
                        Masuk Sekarang
                    </button>
                </form>

                <div class="mt-8 text-center text-sm text-gray-400">
                    &copy; {{ date('Y') }} Admin Dashboard. All rights reserved.
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
