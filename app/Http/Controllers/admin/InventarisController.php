<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\InventarisRequest;
use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Stok;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventarisController extends Controller
{
      public function index()
    {
        $inventaris = Inventaris::with('user')->latest()->paginate(10);
        return view('admin.inventaris.index', compact('inventaris'));
    }

    public function create()
    {
        $barangs = Barang::with('stok')->orderBy('nama_barang')->get();
        return view('admin.inventaris.create', compact('barangs'));
    }

    public function store(InventarisRequest $request)
    {
        DB::transaction(function () use ($request) {
            $inventaris = Inventaris::create([
                'user_id' => Auth::id(),
                'kode_inventaris' => 'INV-' . Carbon::now()->format('YmdHis'),
                'tanggal_inventaris' => $request->tanggal_inventaris,
                'status' => 'completed', // Langsung completed karena ini opname
                'catatan' => $request->catatan,
            ]);

            foreach ($request->details as $item) {
                $stok = Stok::where('barang_id', $item['barang_id'])->firstOrFail();
                $stokSistem = $stok->jumlah_stok;
                $stokFisik = $item['stok_fisik'];

                $inventaris->details()->create([
                    'barang_id'   => $item['barang_id'],
                    'stok_sistem' => $stokSistem,
                    'stok_fisik'  => $stokFisik,
                    'selisih'     => $stokFisik - $stokSistem,
                    'keterangan'  => $item['keterangan'],
                ]);

                // Update stok di tabel stoks sesuai hasil fisik
                $stok->update(['jumlah_stok' => $stokFisik]);
            }
        });

        return redirect()->route('admin.inventaris.index')->with('success', 'Stok opname berhasil disimpan.');
    }

    public function show(Inventaris $inventari) // Nama variabel diubah agar tidak konflik
    {
        $inventari->load(['user', 'details.barang']);
        return view('admin.inventaris.show', compact('inventari'));
    }
}
