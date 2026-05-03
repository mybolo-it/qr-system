<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
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

    public function downloadQr($id)
    {
        $item = Item::findOrFail($id);

        // URL publik yang akan dimuat di dalam QR Code
        $url = route('item.show', $item->token);

        // Ubah format menjadi 'svg'. Ini TIDAK butuh ekstensi Imagick atau GD sama sekali.
        $qrImage = QrCode::format('svg')->size(300)->margin(1)->generate($url);

        // Memformat string nama agar tidak mengandung spasi dan simbol
        $cleanName = preg_replace('/[^A-Za-z0-9]/', '', strtolower($item->nama));

        // Ubah ekstensi file menjadi .svg
        $fileName = 'qr_' . $cleanName . '.svg';

        return response($qrImage)
            // Pastikan Content-type disesuaikan menjadi MIME type milik SVG
            ->header('Content-type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
