<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BarangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            // Barang untuk Supplier 1
            ['kategori_id' => 1, 'barang_kode' => 'BRG001', 'barang_nama' => 'Smartphone Samsung Galaxy', 'harga_beli' => 4000000, 'harga_jual' => 5000000],
            ['kategori_id' => 1, 'barang_kode' => 'BRG002', 'barang_nama' => 'Laptop ASUS VivoBook', 'harga_beli' => 7000000, 'harga_jual' => 9000000],
            ['kategori_id' => 1, 'barang_kode' => 'BRG003', 'barang_nama' => 'Headphone Sony WH-1000XM4', 'harga_beli' => 3000000, 'harga_jual' => 4000000],
            ['kategori_id' => 1, 'barang_kode' => 'BRG004', 'barang_nama' => 'Smartwatch Apple Watch Series 6', 'harga_beli' => 5000000, 'harga_jual' => 6500000],
            ['kategori_id' => 1, 'barang_kode' => 'BRG005', 'barang_nama' => 'Camera Canon EOS M50', 'harga_beli' => 8000000, 'harga_jual' => 10000000],

            // Barang untuk Supplier 2
            ['kategori_id' => 2, 'barang_kode' => 'BRG006', 'barang_nama' => 'T-Shirt Polos', 'harga_beli' => 50000, 'harga_jual' => 75000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG007', 'barang_nama' => 'Jacket Kulit', 'harga_beli' => 300000, 'harga_jual' => 400000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG008', 'barang_nama' => 'Jeans Blue', 'harga_beli' => 150000, 'harga_jual' => 200000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG009', 'barang_nama' => 'Sepatu Sneakers', 'harga_beli' => 250000, 'harga_jual' => 325000],
            ['kategori_id' => 2, 'barang_kode' => 'BRG010', 'barang_nama' => 'Sweater Hangat', 'harga_beli' => 120000, 'harga_jual' => 150000],

            // Barang untuk Supplier 3
            ['kategori_id' => 3, 'barang_kode' => 'BRG011', 'barang_nama' => 'Biskuit Oreo', 'harga_beli' => 20000, 'harga_jual' => 25000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG012', 'barang_nama' => 'Coklat Cadbury Dairy Milk', 'harga_beli' => 30000, 'harga_jual' => 40000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG013', 'barang_nama' => 'Kopi Nescafe', 'harga_beli' => 50000, 'harga_jual' => 65000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG014', 'barang_nama' => 'Mie Instan Indomie', 'harga_beli' => 15000, 'harga_jual' => 20000],
            ['kategori_id' => 3, 'barang_kode' => 'BRG015', 'barang_nama' => 'Susu Ultra Milk', 'harga_beli' => 25000, 'harga_jual' => 30000],
        ];

        DB::table('m_barang')->insert($data);
    }
}
