<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Dokumen PT Teknologi Arindama Andra (Company 1)
            [
                'nama' => 'SK Pengangkatan Karyawan Tetap',
                'deskripsi' => 'Surat Keputusan pengangkatan atas nama Budi Santoso.',
                'file_path' => 'documents/sk-budi.pdf',
                'token' => Str::random(16),
                'company_id' => 1,
                'category_id' => 1, // Surat Keputusan
                'status' => 'published',
                'views' => 12,
            ],
            [
                'nama' => 'Sertifikat Pelatihan K3',
                'deskripsi' => 'Sertifikat pelatihan keselamatan kerja angkatan 2026.',
                'file_path' => 'documents/sertifikat-k3.pdf',
                'token' => Str::random(16),
                'company_id' => 1,
                'category_id' => 2, // Sertifikat
                'status' => 'published',
                'views' => 45,
            ],

            // Dokumen PT Lancar Anja Kuwaga (Company 2)
            [
                'nama' => 'Memo Perubahan Jam Kerja Shift',
                'deskripsi' => 'Penyesuaian jam kerja lapangan selama periode akhir tahun.',
                'file_path' => 'documents/memo-shift.pdf',
                'token' => Str::random(16),
                'company_id' => 2,
                'category_id' => 3, // Memo Internal
                'status' => 'published',
                'views' => 100,
            ],

            // Dokumen PT Kirana Baskara Kuwara (Company 3)
            [
                'nama' => 'Draft SK Direksi 001',
                'deskripsi' => 'Draft awal pembentukan cabang baru (Belum Valid/Belum Publish).',
                'file_path' => 'documents/draft-sk.pdf',
                'token' => Str::random(16),
                'company_id' => 3,
                'category_id' => 1,
                'status' => 'draft', // Statusnya draft, jika discan akan ditolak
                'views' => 0,
            ],
        ];

        foreach ($items as $item) {
            Item::create($item);
        }
    }
}
