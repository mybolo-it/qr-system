@extends('layouts.app')

@section('title', 'List Dokumen')

@section('content')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;800&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Poppins', sans-serif;
        background: #f4f7fe;
    }

    .glass-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
    }

    /* Animasi Staggered menggunakan CSS Murni untuk menghindari ParseError */
    .stagger-item {
        opacity: 0;
        animation: fadeInUp 0.5s ease forwards;
    }

    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Manual Stagger Delay untuk 5 item pertama */
    .stagger-item:nth-child(1) { animation-delay: 0.1s; }
    .stagger-item:nth-child(2) { animation-delay: 0.2s; }
    .stagger-item:nth-child(3) { animation-delay: 0.3s; }
    .stagger-item:nth-child(4) { animation-delay: 0.4s; }
    .stagger-item:nth-child(5) { animation-delay: 0.5s; }

    /* Responsive Card Mode untuk HP */
    @media (max-width: 768px) {
        .hide-on-mobile { display: none; }
        .table-responsive-stack thead { display: none; }
        .table-responsive-stack tr {
            display: block;
            margin-bottom: 1.5rem;
            border-radius: 1.5rem;
            background: white;
            padding: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.05);
        }
        .table-responsive-stack td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem 0.5rem;
            border-bottom: 1px solid #f3f4f6;
            width: 100%;
            text-align: right;
        }
        .table-responsive-stack td:last-child { border-bottom: none; }
        .table-responsive-stack td::before {
            content: attr(data-label);
            font-weight: 700;
            color: #6366f1;
            text-align: left;
            font-size: 0.75rem;
            text-transform: uppercase;
        }
    }
</style>

<div class="max-w-7xl mx-auto px-4 py-6 md:py-10">
    <div class="mb-8 animate__animated animate__fadeInDown">
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-800">
                    <span class="text-indigo-600">Arsip</span> Dokumen
                </h1>
                <p class="text-gray-500 text-sm mt-1">Kelola data digital Anda dalam satu dashboard.</p>
            </div>
        </div>
    </div>

    <div class="glass-card rounded-[2rem] shadow-2xl overflow-hidden border border-white">
        <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-emerald-500"></div>

        <div class="p-4 md:p-6">
            <div class="overflow-x-auto">
                <table class="min-w-full table-responsive-stack">
                    <thead class="hide-on-mobile">
                        <tr class="border-b border-gray-100">
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">No</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Nama</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Deskripsi</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">File</th>
                            <th class="px-6 py-5 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Tanggal</th>
                            <th class="px-6 py-5 text-center text-xs font-bold text-gray-400 uppercase tracking-widest">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse($items as $index => $item)
                        <tr class="stagger-item group hover:bg-indigo-50/30 transition-all duration-300">
                            <td data-label="No" class="px-6 py-4 md:py-6 text-sm text-gray-400 font-medium">
                                {{ $items->firstItem() + $index }}
                            </td>
                            <td data-label="Nama" class="px-6 py-4 md:py-6">
                                <span class="font-bold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ $item->nama }}</span>
                            </td>
                            <td data-label="Deskripsi" class="px-6 py-4 md:py-6 text-sm text-gray-500 italic">
                                {{ Str::limit($item->deskripsi, 30) }}
                            </td>
                            <td data-label="Lampiran" class="px-6 py-4 md:py-6">
                                <a href="{{ $item->file_url }}" target="_blank" class="text-indigo-500 hover:text-indigo-700 font-semibold inline-flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    Review
                                </a>
                            </td>
                            <td data-label="Waktu" class="px-6 py-4 md:py-6 text-xs text-gray-400">
                                {{ $item->created_at->format('d/m/Y') }}
                            </td>
                            <td data-label="Opsi" class="px-6 py-4 md:py-6 text-center">
                                <a href="{{ route('item.show', $item->token) }}" class="inline-block bg-indigo-600 text-white px-5 py-2 rounded-xl text-xs font-bold shadow-lg shadow-indigo-200 hover:scale-105 transition-transform">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-400">Data tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection