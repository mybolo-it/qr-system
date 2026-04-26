@extends('layouts.app')

@section('title', 'Dashboard Publik')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

<style>
    body { font-family: 'Poppins', sans-serif; background: #f8fafc; }
    .glass-card {
        background: rgba(255, 255, 255, 0.8);
        backdrop-filter: blur(12px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    .glass-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .bg-gradient-header {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    .qr-container {
        background: white;
        padding: 10px;
        border-radius: 1rem;
        box-shadow: inset 0 2px 4px 0 rgba(0, 0, 0, 0.06);
    }
</style>

<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row md:items-center justify-between mb-10 animate__animated animate__fadeIn">
        <div>
            <h1 class="text-4xl font-extrabold text-gray-800 tracking-tight">
                Informasi
            </h1>
            <p class="text-gray-500 mt-2">Temukan informasi data publik.</p>
        </div>
        @guest
        <a href="{{ route('login') }}" class="mt-4 md:mt-0 inline-flex items-center px-6 py-3 bg-gradient-header text-white font-semibold rounded-xl shadow-lg hover:opacity-90 transition transform hover:scale-105">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h12m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
            Admin Login
        </a>
        @endguest
    </div>

    @if($items->count() > 0)
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach($items as $index => $item)
        <div class="glass-card rounded-3xl overflow-hidden animate__animated animate__fadeInUp" style="animation-delay: {{ $index * 0.1 }}s">
            <div class="h-2 bg-gradient-header"></div>
            
            <div class="p-8">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="font-bold text-2xl text-gray-800 leading-tight group-hover:text-indigo-600 transition">
                        {{ $item->nama }}
                    </h3>
                    <span class="bg-indigo-100 text-indigo-600 text-[10px] font-bold px-2 py-1 rounded-full uppercase tracking-wider">
                        Public Data
                    </span>
                </div>

                <p class="text-gray-600 mb-6 text-sm leading-relaxed">
                    {{ Str::limit($item->deskripsi, 110) }}
                </p>

                <div class="flex justify-center mb-6 group">
                    <div class="qr-container border-2 border-dashed border-indigo-100 group-hover:border-indigo-400 transition-colors">
                        {!! QrCode::size(140)->margin(1)->generate($item->detail_url) !!}
                    </div>
                </div>

                <div class="flex justify-between items-center py-4 border-t border-gray-100 text-xs font-medium text-gray-400">
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        {{ $item->created_at->format('d M Y') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-indigo-400" fill="currentColor" viewBox="0 0 20 20"><path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/></svg>
                        {{ $item->views }} views
                    </div>
                </div>

                <a href="{{ route('item.show', $item->token) }}" 
                   class="mt-4 block w-full text-center py-3 px-4 bg-gray-50 text-indigo-600 font-bold rounded-xl hover:bg-indigo-600 hover:text-white transition duration-300 transform active:scale-95 shadow-sm">
                    Detail Selengkapnya
                </a>
            </div>
        </div>
        @endforeach
    </div>

    @else
    <div class="text-center py-20 animate__animated animate__fadeIn">
        <div class="inline-flex items-center justify-center w-24 h-24 bg-yellow-100 text-yellow-500 rounded-full mb-6">
            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
        </div>
        <h3 class="text-2xl font-bold text-gray-800">Ups! Data Kosong</h3>
        <p class="text-gray-500 max-w-sm mx-auto mt-2">Belum ada data yang bisa ditampilkan saat ini. Silahkan kembali lagi nanti.</p>
    </div>
    @endif
</div>
@endsection