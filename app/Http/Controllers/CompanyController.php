<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {
        $query = Company::latest();

        // Fitur Pencarian berdasarkan nama atau kode perusahaan
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama_perusahaan', 'like', '%' . $request->search . '%')
                    ->orWhere('kode_perusahaan', 'like', '%' . $request->search . '%');
            });
        }

        $companies = $query->paginate(10)->withQueryString();

        return view('admin.perusahaan', compact('companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255|unique:companies,nama_perusahaan',
            'kode_perusahaan' => 'required|string|max:50|unique:companies,kode_perusahaan',
        ]);

        Company::create([
            'nama_perusahaan' => $request->nama_perusahaan,
            'kode_perusahaan' => strtoupper($request->kode_perusahaan),
        ]);

        return redirect()->route('admin.perusahaan.index')->with('success', 'Entitas Perusahaan baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_perusahaan' => 'required|string|max:255|unique:companies,nama_perusahaan,' . $id,
            'kode_perusahaan' => 'required|string|max:50|unique:companies,kode_perusahaan,' . $id,
        ]);

        $company = Company::findOrFail($id);
        $company->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'kode_perusahaan' => strtoupper($request->kode_perusahaan),
        ]);

        return redirect()->route('admin.perusahaan.index')->with('success', 'Data Entitas Perusahaan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $company = Company::findOrFail($id);
            $company->delete();

            return redirect()->route('admin.perusahaan.index')->with('success', 'Entitas Perusahaan berhasil dihapus.');
        } catch (\Exception $e) {
            // Tangkap error jika perusahaan ini masih terikat dengan data dokumen di database
            return redirect()->route('admin.perusahaan.index')->with('error', 'Gagal dihapus: Perusahaan ini masih digunakan pada arsip dokumen yang ada.');
        }
    }
}
