<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    /**
     * Dashboard publik menampilkan daftar item dengan fitur pencarian
     */
    public function dashboard(Request $request)
    {
        $items = Item::query()
            // Keamanan: Pastikan hanya dokumen dengan status 'published' yang tampil di publik
            ->where('status', 'published')

            // Logika Pencarian
            ->when($request->search, function ($query, $search) {
                // Dibungkus closure agar 'OR' tidak mengganggu kondisi 'status = published'
                $query->where(function ($q) use ($search) {
                    $q->where('nama', 'like', "%{$search}%")
                        ->orWhere('deskripsi', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('public.dashboard', compact('items'));
    }

    /**
     * Halaman detail item berdasarkan token (hasil scan QR)
     */
    /**
     * Halaman detail item berdasarkan token (hasil scan QR)
     */
    public function show($token, Request $request)
    {
        // Tambahkan relasi agar load data entitas & kategori lebih optimal
        $item = Item::with(['company', 'category'])->where('token', $token)->firstOrFail();

        // Cek apakah pengunjung sedang login (Admin/HR)
        $isAdmin = auth()->check();

        // Logika Keamanan Smart Routing:
        // Jika publik (guest), mereka HANYA boleh melihat dokumen 'published'
        if (!$isAdmin && $item->status !== 'published') {
            abort(404, 'Dokumen tidak ditemukan atau statusnya sudah dicabut/tidak berlaku.');
        }

        // Catat statistik HANYA jika yang men-scan adalah publik 
        // (Agar view count tidak membengkak saat admin sedang mengecek/testing QR)
        if (!$isAdmin) {
            $item->scanLogs()->create([
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
            $item->increment('views');
        }

        // Lempar data ke view beserta status pengunjungnya
        return view('public.show', compact('item', 'isAdmin'));
    }
}
