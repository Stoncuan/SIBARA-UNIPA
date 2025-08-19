<?php

namespace Database\Seeders;

use App\Models\Barang;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $barang = new Barang([
            'nama_barang' => 'Delll',
            'penjelasan_barang' => 'Laptop bagus',
            'gambar_barang' => 'test',
            'total_barang' => 20,
            'barang_tersedia' => 15
        ]);

        $barang->save();
    }
}
