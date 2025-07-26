<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Permintaan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalUser = User::count();
        $pendingPermintaan = Permintaan::where('status', 'pending')->count();
        $approvedPermintaan = Permintaan::where('status', 'approved')->count();

        return view('admin.dashboard', compact(
            'totalBarang',
            'totalUser',
            'pendingPermintaan',
            'approvedPermintaan'
        ));
    }
}
