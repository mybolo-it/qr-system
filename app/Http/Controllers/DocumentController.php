<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\Company;
use Illuminate\Http\Request;

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

        return view('documents.index', compact('items', 'categories', 'companies'));
    }
}
