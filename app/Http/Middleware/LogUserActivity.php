<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class LogUserActivity
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }

    public function terminate(Request $request, $response)
    {
        // 1. Abaikan request untuk assets statis
        if (preg_match('/\.(css|js|jpg|jpeg|png|gif|ico|svg|woff|woff2|ttf|eot)$/i', $request->path())) {
            return;
        }

        // 2. Identifikasi User
        $user = Auth::check() ? Auth::user()->name . ' (Role: ' . Auth::user()->role . ')' : 'Guest / Akses Publik';

        $method = $request->method();
        $ip = $request->ip();

        // 3. Terjemahkan Method agar mudah dipahami
        $tindakan = match ($method) {
            'GET' => 'Membuka halaman / Melihat data',
            'POST' => 'Menyimpan data baru / Mengirim form',
            'PUT', 'PATCH' => 'Memperbarui data',
            'DELETE' => 'Menghapus data',
            default => $method
        };

        // 4. Terjemahkan URL berdasarkan Nama Route Laravel QR System
        $routeName = $request->route() ? $request->route()->getName() : null;
        $aktivitas = $this->terjemahkanRoute($routeName, $request->path());

        // 5. Susun Pesan
        $message = "Log Aktivitas E-Office\n";
        $message .= "User: {$user}\n";
        $message .= "Aksi: {$tindakan}\n";
        $message .= "Aktivitas: {$aktivitas}\n";
        $message .= "IP Address: {$ip}\n";

        // 6. Tangkap payload hanya jika ada data yang dikirim (selain GET)
        if (in_array($method, ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            $payload = $request->except(['password', 'password_confirmation', '_token']);

            if (!empty($payload)) {
                $dataString = json_encode($payload, JSON_PRETTY_PRINT);

                if (strlen($dataString) > 500) {
                    $dataString = substr($dataString, 0, 500) . "\n... [teks dipotong]";
                }

                $message .= "\nData yang dikirim:\n```json\n{$dataString}\n```";
            }
        }

        $this->sendToTelegram($message);
    }

    /**
     * Kamus untuk mengubah Nama Route QR System menjadi kalimat yang mudah dibaca
     */
    private function terjemahkanRoute($routeName, $path)
    {
        if (!$routeName) return "Path URL: /" . $path;

        $kamus = [
            // Publik & Auth
            'item.show' => 'Melihat Detail Item (Scan QR Publik)',
            'document.file' => 'Melihat / Download File Dokumen',
            'login' => 'Halaman Login E-Office',
            'logout' => 'Melakukan Logout',
            'home' => 'Dashboard Utama E-Office',

            // Area Admin - Arsip & Dokumen
            'admin.form' => 'Halaman Form Penerbitan Dokumen',
            'admin.store' => 'Menyimpan Penerbitan Dokumen Baru',
            'admin.items' => 'Melihat Daftar Item Dokumen',
            'admin.arsip' => 'Halaman Arsip Dokumen',
            'admin.arsip.download-qr' => 'Mendownload QR Code Dokumen',
            'admin.arsip.bulk-destroy' => 'Menghapus Massal Arsip Dokumen',
            'admin.arsip.update' => 'Memperbarui Data Arsip Dokumen',
            'admin.arsip.destroy' => 'Menghapus Arsip Dokumen',

            // Area Admin - Kategori
            'admin.kategori.index' => 'Halaman Daftar Kategori Dokumen',
            'admin.kategori.store' => 'Menambah Kategori Dokumen Baru',
            'admin.kategori.update' => 'Memperbarui Data Kategori Dokumen',
            'admin.kategori.destroy' => 'Menghapus Kategori Dokumen',

            // Area Admin - Perusahaan
            'admin.perusahaan.index' => 'Halaman Manajemen Perusahaan',
            'admin.perusahaan.store' => 'Menambah Data Perusahaan Baru',
            'admin.perusahaan.update' => 'Memperbarui Data Perusahaan',
            'admin.perusahaan.destroy' => 'Menghapus Data Perusahaan',

            // Manajemen User (Superadmin)
            'users.index' => 'Halaman Daftar Pengguna (Users)',
            'users.store' => 'Menambahkan Pengguna Baru',
            'users.update' => 'Memperbarui Data Pengguna',
            'users.destroy' => 'Menghapus Pengguna',
            'users.show' => 'Melihat Detail Pengguna',

            // Profil User
            'profile.edit' => 'Halaman Pengaturan Profil User',
            'profile.update' => 'Menyimpan Pembaruan Profil',
        ];

        return $kamus[$routeName] ?? "Aktivitas pada: " . str_replace(['.', '_', '-'], ' ', title_case($routeName));
    }

    private function sendToTelegram($message)
    {
        $token = env('TELEGRAM_ADMIN_BOT_TOKEN');
        $chatId = env('TELEGRAM_ADMIN_CHAT_ID');

        if (!$token || !$chatId) return;

        try {
            Http::timeout(3)->post("https://api.telegram.org/bot{$token}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $message,
                'parse_mode' => 'Markdown'
            ]);
        } catch (\Exception $e) {
            // Abaikan error agar sistem QR web tetap berjalan lancar
        }
    }
}
