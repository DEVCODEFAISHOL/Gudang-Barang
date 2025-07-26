<?php


namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use App\Models\Inventaris;
use App\Models\Pengeluaran;
use Illuminate\Http\Request;
use App\Models\Permintaan;
use App\Models\Stok;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class LaporanController extends Controller
{
    //
     public function index()
    {
        return view('manager.laporan.index');
    }

    public function stok()
    {
        $stoks = Stok::with('barang.kategori')->orderBy('id', 'desc')->get();
        return view('manager.laporan.stok', compact('stoks'));
    }

    public function barangMasuk(Request $request)
    {
        $query = Inventaris::with(['details.barang', 'user']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_inventaris', [$request->start_date, $request->end_date]);
        }

        $laporan = $query->latest()->get();
        return view('manager.laporan.masuk', compact('laporan'));
    }

    public function barangKeluar(Request $request)
    {
        $query = Pengeluaran::with(['details.barang', 'user', 'permintaan']);

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pengeluaran', [$request->start_date, $request->end_date]);
        }

        $laporan = $query->latest()->get();
        return view('manager.laporan.keluar', compact('laporan'));
    }
}
