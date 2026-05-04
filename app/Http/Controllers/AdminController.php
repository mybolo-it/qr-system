<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Item;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function arsip(Request $request)
    {
        $user = auth()->user();

        // 1. Inisiasi Query Dasar
        $query = Item::with(['company', 'category']);

        // 2. LOGIKA OTORISASI MUTLAK (Pemisahan Superadmin vs Company Admin)
        if ($user->role === 'superadmin' || $user->role === 'hr_global') {
            // Superadmin/HR Global bisa lihat semua. 
            // Filter company_id dari dropdown pencarian hanya berlaku untuk mereka.
            if ($request->filled('company_id')) {
                $query->where('company_id', $request->company_id);
            }
            $companies = Company::orderBy('nama_perusahaan', 'asc')->get();
        } else {
            // COMPANY ADMIN & STAFF: PAKSA HANYA DATA MILIK PERUSAHAANNYA!
            // Query ini akan menimpa/mengunci data secara permanen di level database.
            $query->where('company_id', $user->company_id);

            // Batasi juga data dropdown (walaupun disembunyikan di view, amankan di backend)
            $companies = Company::where('id', $user->company_id)->get();
        }

        // 3. Filter Pencarian Universal (Berlaku untuk semua role)
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                    ->orWhere('token', 'like', '%' . $request->search . '%')
                    ->orWhere('nomor_surat', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('tanggal')) {
            $query->whereDate('tanggal_surat', $request->tanggal);
        }

        // 4. Eksekusi Query
        $items = $query->latest()->paginate(10);
        $categories = Category::all();

        return view('admin.arsip', compact('items', 'companies', 'categories'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();

        // Pengamanan company_id
        if ($user->role !== 'superadmin' && $user->role !== 'hr_global') {
            $request->merge([
                'company_id' => $user->company_id
            ]);
        }

        $request->validate([
            'nama'          => 'required|string|max:255',
            'nomor_surat'   => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'category_id'   => 'required|exists:categories,id',
            'company_id'    => 'required|exists:companies,id',
            'status'        => 'required|in:published,draft,revoked',
            'file'          => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'deskripsi'     => 'nullable|string',
        ]);

        $path = $request->file('file') ? $request->file('file')->store('uploads', 'public') : null;

        do {
            $token = Str::random(32);
        } while (Item::where('token', $token)->exists());

        $item = Item::create([
            'nama'          => $request->nama,
            'nomor_surat'   => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'category_id'   => $request->category_id,
            'company_id'    => $request->company_id,
            'status'        => $request->status,
            'deskripsi'     => $request->deskripsi,
            'file_path'     => $path,
            'letterhead'    => $request->letterhead ?? null,
            'token'         => $token,
            'views'         => 0,
        ]);

        // Generate QR SVG (Base64) khusus untuk ditampilkan di Modal Sukses
        $qrUrl = route('item.show', $item->token);
        $qrSvg = QrCode::format('svg')->size(200)->margin(0)->generate($qrUrl);
        $qrBase64 = base64_encode($qrSvg);

        // Flash data ke session untuk memicu Modal Sukses
        $newDocumentData = [
            'id' => $item->id,
            'nama' => $item->nama,
            'nomor_surat' => $item->nomor_surat,
            'qr_base64' => $qrBase64
        ];

        return redirect()->route('admin.arsip')
            ->with('success', 'Dokumen berhasil diproses.')
            ->with('new_item', $newDocumentData);
    }

    // FUNGSI BARU: UPDATE DOKUMEN
    public function update(Request $request, $id)
    {
        $user = auth()->user();
        $item = Item::findOrFail($id);

        // Cek otorisasi
        if ($user->role !== 'superadmin' && $user->role !== 'hr_global' && $item->company_id !== $user->company_id) {
            abort(403, 'Akses ditolak.');
        }

        // Pengamanan company_id untuk update
        if ($user->role !== 'superadmin' && $user->role !== 'hr_global') {
            $request->merge([
                'company_id' => $user->company_id
            ]);
        }

        $request->validate([
            'nama'          => 'required|string|max:255',
            'nomor_surat'   => 'required|string|max:255',
            'tanggal_surat' => 'required|date',
            'category_id'   => 'required|exists:categories,id',
            'company_id'    => 'required|exists:companies,id',
            'status'        => 'required|in:published,draft,revoked',
            'file'          => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:5120',
            'deskripsi'     => 'nullable|string',
        ]);

        // Cek jika ada file baru yang diunggah
        if ($request->hasFile('file')) {
            // Hapus file lama jika ada
            if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
                Storage::disk('public')->delete($item->file_path);
            }
            // Simpan file baru
            $item->file_path = $request->file('file')->store('uploads', 'public');
        }

        // Update data text
        $item->nama = $request->nama;
        $item->nomor_surat = $request->nomor_surat;
        $item->tanggal_surat = $request->tanggal_surat;
        $item->category_id = $request->category_id;
        $item->company_id = $request->company_id;
        $item->status = $request->status;
        $item->deskripsi = $request->deskripsi;

        $item->save();

        return redirect()->route('admin.arsip')->with('success', 'Arsip dokumen berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $user = auth()->user();
        $item = Item::findOrFail($id);

        if ($user->role !== 'superadmin' && $user->role !== 'hr_global' && $item->company_id !== $user->company_id) {
            abort(403, 'Akses ditolak. Anda tidak berhak menghapus arsip perusahaan lain.');
        }

        if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
            Storage::disk('public')->delete($item->file_path);
        }

        $item->delete();

        return redirect()->back()->with('success', 'Arsip dokumen berhasil dihapus permanen.');
    }

    public function bulkDestroy(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:items,id'
        ]);

        $items = Item::whereIn('id', $request->ids)->get();

        foreach ($items as $item) {
            if ($user->role !== 'superadmin' && $user->role !== 'hr_global' && $item->company_id !== $user->company_id) {
                continue;
            }

            if ($item->file_path && Storage::disk('public')->exists($item->file_path)) {
                Storage::disk('public')->delete($item->file_path);
            }
            $item->delete();
        }

        return redirect()->back()->with('success', count($request->ids) . ' dokumen terpilih berhasil dihapus.');
    }

    public function downloadQr($id)
    {
        $item = Item::findOrFail($id);
        $user = auth()->user();

        if ($user->role !== 'superadmin' && $user->role !== 'hr_global' && $item->company_id !== $user->company_id) {
            abort(403, 'Akses ditolak.');
        }

        $url = route('item.show', $item->token);
        $qrImage = QrCode::format('svg')->size(300)->margin(1)->generate($url);
        $cleanName = preg_replace('/[^A-Za-z0-9]/', '', strtolower($item->nama));
        $fileName = 'qr_' . $cleanName . '.svg';

        return response($qrImage)
            ->header('Content-type', 'image/svg+xml')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }
}
