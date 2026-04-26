<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company; // Pastikan ini ditambahkan
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index()
    {
        // Ambil data user beserta relasinya jika ada (opsional tapi disarankan)
        $users = User::with('company')->latest()->paginate(10);

        // Ambil data master perusahaan untuk mengisi dropdown
        $companies = Company::all();

        return view('users.index', compact('users', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,company_admin,superadmin', // Disesuaikan dengan opsi di form
            'company_id' => 'nullable|exists:companies,id', // Validasi company_id
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Alamat email tidak boleh kosong.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'role.required' => 'Silakan pilih peran pengguna.',
            'company_id.exists' => 'Perusahaan yang dipilih tidak valid.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'company_id' => $request->company_id, // Simpan company_id
        ]);

        return redirect()->route('users.index')->with('success', 'Pengguna baru berhasil ditambahkan.');
    }

    public function update(Request $request, $encryptedId)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Anda tidak memiliki izin.');
        }

        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (DecryptException $e) {
            abort(404, 'ID tidak valid.');
        }

        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,company_admin,superadmin',
            'company_id' => 'nullable|exists:companies,id',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.unique' => 'Email sudah digunakan oleh pengguna lain.',
            'role.required' => 'Peran wajib dipilih.',
            'company_id.exists' => 'Perusahaan yang dipilih tidak valid.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'company_id' => $request->company_id, // Update company_id
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data pengguna berhasil diperbarui.');
    }

    public function destroy($encryptedId)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Anda tidak memiliki izin.');
        }

        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (DecryptException $e) {
            abort(404, 'ID tidak valid.');
        }

        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('users.index')->with('success', 'Pengguna berhasil dihapus dari sistem.');
    }
}
