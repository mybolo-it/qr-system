<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['nama_kategori' => 'Surat Keputusan (SK)', 'deskripsi' => 'Dokumen ketetapan perusahaan'],
            ['nama_kategori' => 'Sertifikat', 'deskripsi' => 'Sertifikat pelatihan atau penghargaan'],
            ['nama_kategori' => 'Memo Internal', 'deskripsi' => 'Pemberitahuan antar divisi'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
