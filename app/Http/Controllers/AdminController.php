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
        'deskripsi' => 'nullable|string',
        'file' => 'required|file|mimes:jpg,jpeg,png,gif,bmp,webp,pdf,doc,docx,xls,xlsx,ppt,pptx,txt,csv,zip,rar|max:5120',
        'letterhead' => 'nullable|string|max:500', // teks kop surat
    ]);

    // Upload file dokumen
    $path = $request->file('file')->store('uploads', 'public');

    // Generate token unik
    do {
        $token = Str::random(32);
    } while (Item::where('token', $token)->exists());

    // Simpan ke database
    Item::create([
        'nama' => $request->nama,
        'deskripsi' => $request->deskripsi,
        'file_path' => $path,
        'letterhead' => $request->letterhead, // simpan teks
        'token' => $token,
        'views' => 0,
    ]);

    return redirect()->route('admin.form')->with('success', 'Data berhasil disimpan.');
}
    // Opsional: halaman untuk admin melihat semua item (bisa ditambahkan)
    public function index()
    {
        $items = Item::latest()->get();
        return view('admin.index', compact('items'));
    }
}