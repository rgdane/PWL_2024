<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StokSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        // Stok untuk 15 barang
        for ($i = 1; $i <= 15; $i++) {
            $data[] = [
                'barang_id' => $i,
                'user_id' => rand(1, 3), // Asumsi ada 3 user dengan ID 1, 2, dan 3
                'stok_tanggal' => now()->subDays(rand(1, 30)), // Stok ditambahkan dalam 30 hari terakhir
                'stok_jumlah' => rand(10, 100), // Jumlah stok acak antara 10 dan 100
            ];
        }

        DB::table('t_stok')->insert($data);
    }
}
