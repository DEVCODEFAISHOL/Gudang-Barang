<?php

namespace App\Http\Controllers\manager;
use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Permintaan;
use App\Models\Stok;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
     public function index()
    {
         $pendingPermintaans = Permintaan::where('status', 'pending')->count();
    $stokMenipis = Stok::whereColumn('jumlah_stok', '<=', 'stok_aman')->count();
    $barangs = Barang::with(['kategori', 'stok'])->paginate(10); // atau sesuai kebutuhan

    return view('manager.dashboard', compact('pendingPermintaans', 'stokMenipis', 'barangs'));
    }
}
