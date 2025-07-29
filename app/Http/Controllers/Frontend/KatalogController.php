<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;

// Sebaiknya ganti nama file dan class menjadi BarangController
class KatalogController extends Controller
{
    /**
     * Menampilkan halaman daftar semua barang inventaris dengan paginasi,
     * pencarian, dan filter.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Query builder untuk barang
        $query = Barang::with(['kategori', 'stok'])->latest();

        // Fitur Pencarian berdasarkan nama atau kode barang
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_barang', 'like', "%{$searchTerm}%")
                  ->orWhere('kode_barang', 'like', "%{$searchTerm}%");
            });
        }

        // Fitur Filter berdasarkan Kategori
        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->input('kategori_id'));
        }

        // Ambil data dengan paginasi
        // withQueryString() agar parameter filter & search tetap ada saat pindah halaman
        $semuaBarang = $query->paginate(12)->withQueryString();

        // Ambil semua kategori untuk ditampilkan di dropdown filter
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        return view('frontend.katalog.index', [
            'semuaBarang' => $semuaBarang,
            'kategoris' => $kategoris,
        ]);
    }

    /**
     * Menampilkan detail satu barang.
     *
     * @param  \App\Models\Barang  $barang
     * @return \Illuminate\View\View
     */
    public function show(Barang $barang)
    {
        // Load relasi yang dibutuhkan untuk halaman detail
        $barang->load(['kategori', 'stok', 'permintaanDetails.permintaan.user', 'pengeluaranDetails.pengeluaran.user']);

        return view('frontend.katalog.show', [
            'barang' => $barang
        ]);
    }
}
