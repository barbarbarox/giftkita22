<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['nama_kategori' => 'Hampers Ulang Tahun', 'deskripsi' => 'Kado spesial untuk perayaan ulang tahun'],
            ['nama_kategori' => 'Hampers Lebaran', 'deskripsi' => 'Paket bingkisan Lebaran istimewa'],
            ['nama_kategori' => 'Hampers Romantis', 'deskripsi' => 'Kado untuk pasangan atau momen istimewa'],
            ['nama_kategori' => 'Hampers Bayi', 'deskripsi' => 'Perlengkapan bayi untuk hadiah kelahiran'],
        ];

        foreach ($data as $item) {
            Kategori::create($item);
        }
    }
}
