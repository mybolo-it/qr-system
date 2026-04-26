<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class PublicController extends Controller
{
    // Dashboard publik menampilkan semua item
    public function dashboard()
    {
        $items = Item::latest()->get();
        return view('public.dashboard', compact('items'));
    }

    // Halaman detail item berdasarkan token (hasil scan QR)
    public function show($token)
    {
        $item = Item::where('token', $token)->firstOrFail();
        
        // Increment views (opsional, untuk statistik)
        $item->increment('views');

        return view('public.show', compact('item'));
    }
}