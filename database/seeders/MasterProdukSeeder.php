<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MasterProduk;
use Faker\Factory as Faker;

class MasterProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        $produkData = [
            [
                'produk' => 'Kecap Manis',
                'stok' => 50,
                'harga' => 10000,
            ],
            [
                'produk' => 'Mie Instan',
                'stok' => 100,
                'harga' => 3000,
            ],
            [
                'produk' => 'Minyak Goreng',
                'stok' => 30,
                'harga' => 25000,
            ],
            [
                'produk' => 'Gula Pasir',
                'stok' => 40,
                'harga' => 15000,
            ],
            [
                'produk' => 'Telur Ayam',
                'stok' => 200,
                'harga' => 2000,
            ],
        ];

      

        foreach ($produkData as $produk) {
            MasterProduk::create($produk);
        }

    }
}