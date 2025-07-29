<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Permintaan;
use App\Models\Pengeluaran;
use App\Models\Inventaris;
use App\Models\User;
use App\Models\Kategori;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalBarang' => Barang::count(),
            'totalUser' => User::count(),
            'pendingPermintaan' => Permintaan::where('status', 'pending')->count(),
            'approvedPermintaan' => Permintaan::where('status', 'approved')->count(),
            'barangAktif' => Barang::has('stok')->count(), // Asumsi barang yang punya stok = aktif
            'barangTidakAktif' => Barang::doesntHave('stok')->count(),
            'stokRendah' => $this->getStokRendah(),
            'stokHabis' => $this->getStokHabis(),
            'totalKategori' => Kategori::count(),
            'monthlyStats' => $this->getMonthlyStatistics(),
            'categoryDistribution' => $this->getCategoryDistribution(),
            'recentActivities' => $this->getRecentActivities(),
            'alerts' => $this->getSystemAlerts(),
            'stockMovement' => $this->getStockMovement(),
            'topRequestedItems' => $this->getTopRequestedItems(),
            'lowStockItems' => $this->getLowStockItems(),
        ]);
    }

    private function getStokRendah()
    {
        return Stok::whereColumn('jumlah_stok', '<=', 'stok_aman')
                   ->where('jumlah_stok', '>', 0)
                   ->count();
    }

    private function getStokHabis()
    {
        return Stok::where('jumlah_stok', 0)->count();
    }

    private function getMonthlyStatistics()
    {
        $months = [];
        $permintaan = [];
        $pengeluaran = [];
        $inventaris = [];

        for ($i = 5; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $months[] = $date->format('M');

            $permintaan[] = Permintaan::whereYear('created_at', $date->year)
                                      ->whereMonth('created_at', $date->month)
                                      ->count();

            $pengeluaran[] = Pengeluaran::whereYear('created_at', $date->year)
                                        ->whereMonth('created_at', $date->month)
                                        ->count();

            $inventaris[] = Inventaris::whereYear('created_at', $date->year)
                                      ->whereMonth('created_at', $date->month)
                                      ->count();
        }

        return [
            'months' => $months,
            'permintaan' => $permintaan,
            'pengeluaran' => $pengeluaran,
            'inventaris' => $inventaris,
        ];
    }

    private function getCategoryDistribution()
    {
        $data = Kategori::withCount('barangs')->having('barangs_count', '>', 0)->get();

        return [
            'labels' => $data->pluck('nama_kategori'),
            'data' => $data->pluck('barangs_count'),
            'colors' => ['#3B82F6', '#10B981', '#F59E0B', '#8B5CF6', '#EF4444', '#06B6D4', '#84CC16', '#F97316']
        ];
    }

    private function getRecentActivities()
    {
        return collect([
            ...Barang::latest()->take(5)->get()->map(function ($barang) {
                return [
                    'type' => 'barang',
                    'title' => "Barang baru: {$barang->nama_barang}",
                    'time' => $barang->created_at,
                    'url' => route('admin.barang.show', $barang),
                ];
            }),
            ...Permintaan::latest()->take(5)->get()->map(function ($permintaan) {
                return [
                    'type' => 'permintaan',
                    'title' => "Permintaan {$permintaan->status}",
                    'time' => $permintaan->created_at,
                    'url' => route('admin.permintaan.show', $permintaan),
                ];
            }),
            ...Pengeluaran::latest()->take(3)->get()->map(function ($p) {
                return [
                    'type' => 'pengeluaran',
                    'title' => "Pengeluaran: {$p->kode_pengeluaran}",
                    'time' => $p->created_at,
                    'url' => route('admin.pengeluaran.show', $p),
                ];
            }),
            ...User::latest()->take(3)->get()->map(function ($u) {
                return [
                    'type' => 'user',
                    'title' => "User baru: {$u->name}",
                    'time' => $u->created_at,
                    'url' => '#',
                ];
            })
        ])->sortByDesc('time')->take(15);
    }

    private function getSystemAlerts()
    {
        $alerts = [];

        if ($this->getStokHabis()) {
            $alerts[] = [
                'type' => 'danger',
                'title' => 'Stok Habis',
                'message' => $this->getStokHabis() . ' barang stok 0',
                'priority' => 'high',
                'url' => route('admin.stok.index', ['filter' => 'empty']),
            ];
        }

        if ($this->getStokRendah()) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Stok Rendah',
                'message' => $this->getStokRendah() . ' barang stok rendah',
                'priority' => 'medium',
                'url' => route('admin.stok.index', ['filter' => 'low']),
            ];
        }

        if (Permintaan::where('status', 'pending')->count()) {
            $alerts[] = [
                'type' => 'info',
                'title' => 'Permintaan Pending',
                'message' => Permintaan::where('status', 'pending')->count() . ' permintaan menunggu review',
                'priority' => 'low',
                'url' => route('admin.permintaan.index', ['status' => 'pending']),
            ];
        }

        return collect($alerts)->sortBy('priority');
    }

    private function getStockMovement()
    {
        $days = [];
        $movements = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $days[] = Carbon::now()->subDays($i)->format('d M');

            $pengeluaran = Pengeluaran::whereDate('created_at', $date)
                ->with('details')
                ->get()
                ->sum(fn($p) => $p->details->sum('jumlah_dikeluarkan'));

            $inventaris = Inventaris::whereDate('created_at', $date)
                ->with('details')
                ->get()
                ->sum(fn($i) => $i->details->sum('stok_fisik'));

            $movements[] = $inventaris - $pengeluaran;
        }

        return [
            'days' => $days,
            'movements' => $movements,
        ];
    }

    private function getTopRequestedItems()
    {
        return DB::table('permintaan_details')
            ->join('barangs', 'permintaan_details.barang_id', '=', 'barangs.id')
            ->join('permintaans', 'permintaan_details.permintaan_id', '=', 'permintaans.id')
            ->where('permintaans.created_at', '>=', Carbon::now()->subDays(30))
            ->select('barangs.nama_barang', DB::raw('SUM(permintaan_details.jumlah_diminta) as total'))
            ->groupBy('barangs.nama_barang')
            ->orderByDesc('total')
            ->take(10)
            ->get();
    }

    private function getLowStockItems()
    {
        return Stok::with('barang')
            ->whereColumn('jumlah_stok', '<=', 'stok_aman')
            ->where('jumlah_stok', '>', 0)
            ->orderBy('jumlah_stok', 'asc')
            ->take(10)
            ->get();
    }
}
