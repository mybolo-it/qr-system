<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'role' => 'required|in:admin,superadmin',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Alamat email tidak boleh kosong.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.required' => 'Password wajib diisi.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'password.min' => 'Password minimal harus 6 karakter.',
            'role.required' => 'Silakan pilih role pengguna.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('users.index')->with('success', 'User baru berhasil ditambahkan.');
    }

    public function edit($encryptedId)
    {
        // Pastikan hanya superadmin yang bisa mengakses
        if (auth()->user()->role !== 'superadmin') {
            abort(403, 'Anda tidak memiliki izin.');
        }
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (DecryptException $e) {
            abort(404, 'ID tidak valid.');
        }
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, $encryptedId)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (DecryptException $e) {
            abort(404);
        }
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'role' => 'required|in:admin,superadmin',
            'password' => 'nullable|min:6|confirmed',
        ], [
            'name.required' => 'Nama wajib diisi.',
            'email.unique' => 'Email sudah digunakan oleh user lain.',
            'role.required' => 'Role wajib dipilih.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
            'password.min' => 'Password minimal harus 6 karakter.',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Data user berhasil diperbarui.');
    }

    public function destroy($encryptedId)
    {
        if (auth()->user()->role !== 'superadmin') {
            abort(403);
        }
        try {
            $id = Crypt::decrypt($encryptedId);
        } catch (DecryptException $e) {
            abort(404);
        }
        $user = User::findOrFail($id);

        if ($user->id === auth()->id()) {
            return redirect()->route('users.index')->with('error', 'Anda tidak dapat menghapus akun sendiri.');
        }
        $user->delete();
        return redirect()->route('users.index')->with('success', 'User berhasil dihapus.');
    }
}