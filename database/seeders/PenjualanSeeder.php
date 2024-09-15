<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PenjualanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [];

        for ($i = 1; $i <= 10; $i++) {
            $data[] = [
                'user_id' => rand(1, 3), // Asumsi ada 3 user dengan ID 1, 2, dan 3
                'pembeli' => 'Customer ' . $i, // Nama pembeli, contohnya Customer 1, Customer 2, dll.
                'penjualan_kode' => 'PJ' . str_pad($i, 4, '0', STR_PAD_LEFT), // Kode penjualan, PJ0001, PJ0002, dll.
                'penjualan_tanggal' => now()->subDays(rand(1, 30)), // Tanggal penjualan, acak dalam 30 hari terakhir
            ];
        }

        DB::table('t_penjualan')->insert($data);
    }
}
