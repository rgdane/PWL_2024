<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($penjualan_id = 1; $penjualan_id <= 10; $penjualan_id++) {
            // Mengambil 3 barang secara acak untuk setiap penjualan_id
            $barang_ids = DB::table('m_barang')->pluck('barang_id')->shuffle()->take(3);

            foreach ($barang_ids as $barang_id) {
                $data[] = [
                    'penjualan_id' => $penjualan_id,
                    'barang_id' => $barang_id,
                    'harga' => DB::table('m_barang')->where('barang_id', $barang_id)->value('harga_jual'),
                    'jumlah' => rand(1, 5), // Jumlah barang, acak antara 1 dan 5
                ];
            }
        }

        DB::table('t_penjualan_detail')->insert($data);
    }
}
