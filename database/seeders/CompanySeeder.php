<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Company;

class CompanySeeder extends Seeder
{
    public function run(): void
    {
        $companies = [
            [
                'nama_perusahaan' => 'PT Teknologi Arindama Andra',
                'kode_perusahaan' => 'TAA',
                'alamat' => 'Jalan Ikan Kakap No. 64, Pesawahan',
            ],
            [
                'nama_perusahaan' => 'PT Lancar Anja Kuwaga',
                'kode_perusahaan' => 'LAK',
                'alamat' => 'Jalan Ikan Kakap No. 64, Pesawahan',
            ],
            [
                'nama_perusahaan' => 'PT Kirana Baskara Kuwara',
                'kode_perusahaan' => 'KBK',
                'alamat' => 'Jalan Ikan Kakap No. 64, Pesawahan',
            ],
        ];

        foreach ($companies as $company) {
            Company::create($company);
        }
    }
}