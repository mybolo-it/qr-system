<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
class DocumentController extends Controller
{
    public function index(Request $request)
    {
        // Mulai Query dengan Relasi
        $query = Item::with(['category', 'company'])->latest();

        // Filter 1: Pencarian Teks (Nama, Deskripsi, atau Token)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('deskripsi', 'like', '%' . $request->search . '%')
                    ->orWhere('token', 'like', '%' . $request->search . '%');
            });
        }

        // Filter 2: Kategori
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Filter 3: Perusahaan
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Filter 4: Tanggal Terbit
        if ($request->filled('tanggal')) {
            $query->whereDate('created_at', $request->tanggal);
        }

        // Eksekusi Query dengan Pagination (tambahkan withQueryString agar filter tidak hilang saat pindah halaman)
        $items = $query->paginate(10)->withQueryString();

        // Ambil data master untuk Dropdown Filter
        $categories = Category::all();
        $companies = Company::all();

        return view('admin.arsip', compact('items', 'categories', 'companies'));
    }

    public function destroy($id)
    {
        try {
            $item = \App\Models\Item::findOrFail($id);

            // Hapus file dari server
            if ($item->file_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($item->file_path)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($item->file_path);
            }

            // Hapus dari database
            $item->delete();

            return redirect()->route('admin.arsip')->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            // Jika gagal, tangkap errornya dan tampilkan di layar
            return redirect()
                ->route('admin.arsip')
                ->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }
}
