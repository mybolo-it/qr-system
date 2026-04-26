<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

   public function update(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        // Email dihapus dari validasi update agar tidak bisa dimanipulasi via inspect element
        'password' => 'nullable|min:6|confirmed',
    ], [
        // Custom Pesan Error Bahasa Indonesia
        'name.required' => 'Nama wajib diisi!',
        'password.min' => 'Password minimal harus 6 karakter.',
        'password.confirmed' => 'Konfirmasi password tidak cocok.',
    ]);

    $user->name = $request->name;
    // Email tidak di-update untuk keamanan

    if ($request->filled('password')) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('profile.edit')->with('success', 'Profil berhasil diperbarui.');
}
}