<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = Category::latest();

        // Fitur Pencarian
        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', '%' . $request->search . '%');
        }

        // Pagination
        $categories = $query->paginate(10)->withQueryString();

        return view('admin.kategori', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori',
        ], [
            'nama_kategori.unique' => 'Nama kategori ini sudah ada, silakan gunakan nama lain.',
        ]);

        Category::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori baru berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255|unique:categories,nama_kategori,' . $id,
        ]);

        $category = Category::findOrFail($id);
        $category->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Nama kategori berhasil diperbarui.');
    }

    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
        } catch (\Exception $e) {
            // Biasanya gagal jika kategori sedang dipakai oleh dokumen (Foreign Key Constraint)
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori gagal dihapus karena masih digunakan oleh dokumen yang ada.');
        }
    }
}
