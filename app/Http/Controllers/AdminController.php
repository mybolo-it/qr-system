<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function showForm()
    {
        return view('admin.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'nomor_surat'   => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'category_id' => 'required|exists:categories,id',
            'company_id' => 'required|exists:companies,id',
            'status' => 'required|in:published,draft,revoked', // Validasi status
            'file' => 'required|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'deskripsi' => 'nullable|string',
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        do {
            $token = \Illuminate\Support\Str::random(32);
        } while (\App\Models\Item::where('token', $token)->exists());

        \App\Models\Item::create([
            'nama' => $request->nama,
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'category_id' => $request->category_id,
            'company_id' => $request->company_id,
            'status' => $request->status, // Simpan status ke database
            'deskripsi' => $request->deskripsi,
            'file_path' => $path,
            'letterhead' => $request->letterhead ?? null,
            'token' => $token,
            'views' => 0,
        ]);

        return redirect()->route('admin.arsip')->with('success', 'Dokumen berhasil diproses.');
    }
    // Opsional: halaman untuk admin melihat semua item (bisa ditambahkan)
    public function index()
    {
        $items = Item::latest()->get();
        return view('admin.index', compact('items'));
    }
}
