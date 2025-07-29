<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\PermintaanDetail;

class HomeController extends Controller
{
    public function index()
    {
        // Statistik utama untuk dashboard
        $stats = [
            'total_items' => Barang::count(),
            'total_categories' => Kategori::count(),
            'low_stock_items' => Barang::whereHas('stok', function ($query) {
                $query->where('jumlah_stok', '<=', 10); // Fix kolom stok
            })->count(),
            'total_requests' => PermintaanDetail::count(),
        ];

        // Items dengan stok rendah (perlu perhatian)
        $lowStockItems = Barang::with(['kategori', 'stok'])
            ->whereHas('stok', function ($query) {
                $query->where('jumlah_stok', '<=', 10); // Fix kolom stok
            })
            ->orderBy(
                \App\Models\Stok::select('jumlah_stok')
                    ->whereColumn('barang_id', 'barangs.id')
            )
            ->take(6)
            ->get();

        // Items terbaru yang ditambahkan ke inventory
        $recentItems = Barang::with(['kategori', 'stok'])
            ->latest()
            ->take(8)
            ->get();

        // Kategori dengan jumlah items
        $categories = Kategori::withCount('barangs')
            ->having('barangs_count', '>', 0)
            ->take(6)
            ->get();

        // Chart data untuk inventory overview (stok per kategori)
        $inventoryByCategory = Kategori::with(['barangs.stok'])
            ->get()
            ->map(function ($kategori) {
                return [
                    'name' => $kategori->nama_kategori,
                    'total_items' => $kategori->barangs->count(),
                    'total_stock' => $kategori->barangs->sum(function ($barang) {
                        return optional($barang->stok)->jumlah_stok ?? 0;
                    }),
                ];
            })
            ->filter(function ($item) {
                return $item['total_items'] > 0;
            });

        return view('frontend.home', compact(
            'stats',
            'lowStockItems',
            'recentItems',
            'categories',
            'inventoryByCategory'
        ));
    }
}
