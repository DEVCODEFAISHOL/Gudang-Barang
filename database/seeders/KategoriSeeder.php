<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Elektronik',
                'deskripsi' => 'Barang-barang elektronik seperti komputer, handphone, televisi, dll'
            ],
            [
                'nama_kategori' => 'Furniture',
                'deskripsi' => 'Perabotan kantor dan rumah seperti meja, kursi, lemari, dll'
            ],
            [
                'nama_kategori' => 'Alat Tulis Kantor',
                'deskripsi' => 'Perlengkapan kantor seperti kertas, pulpen, pensil, dll'
            ],
            [
                'nama_kategori' => 'Peralatan Dapur',
                'deskripsi' => 'Peralatan masak dan dapur seperti panci, wajan, pisau, dll'
            ],
            [
                'nama_kategori' => 'Pakaian',
                'deskripsi' => 'Berbagai jenis pakaian dan aksesoris'
            ],
            [
                'nama_kategori' => 'Makanan & Minuman',
                'deskripsi' => 'Produk makanan dan minuman'
            ],
            [
                'nama_kategori' => 'Kesehatan & Kecantikan',
                'deskripsi' => 'Produk kesehatan, obat-obatan, dan kosmetik'
            ],
            [
                'nama_kategori' => 'Olahraga',
                'deskripsi' => 'Peralatan dan perlengkapan olahraga'
            ],
            [
                'nama_kategori' => 'Otomotif',
                'deskripsi' => 'Spare part dan aksesoris kendaraan'
            ],
            [
                'nama_kategori' => 'Bahan Bangunan',
                'deskripsi' => 'Material dan peralatan konstruksi'
            ],
            [
                'nama_kategori' => 'Mainan & Hobi',
                'deskripsi' => 'Mainan anak dan peralatan hobi'
            ],
            [
                'nama_kategori' => 'Buku & Media',
                'deskripsi' => 'Buku, majalah, CD, DVD, dan media lainnya'
            ]
        ];

        foreach ($kategoris as $kategori) {
            Kategori::firstOrCreate(
                ['nama_kategori' => $kategori['nama_kategori']],
                $kategori
            );
        }
    }
}
