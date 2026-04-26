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
    public function show($token, Request $request)
    {
        $item = Item::where('token', $token)->firstOrFail();

        // Keamanan: Cegah publik melihat dokumen yang sedang draft/dicabut meski punya URL-nya
        if ($item->status !== 'published') {
            abort(404, 'Dokumen tidak ditemukan atau tidak lagi berlaku.');
        }

        // Catat riwayat scan/verifikasi ke tabel item_scan_logs yang sudah kita buat
        $item->scanLogs()->create([
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // Increment total views (statistik ringan)
        $item->increment('views');

        return view('public.show', compact('item'));
    }
}
