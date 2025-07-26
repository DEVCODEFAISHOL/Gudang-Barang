<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Http\Requests\PermintaanRequest;
use App\Models\Barang;
use App\Models\Permintaan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermintaanController extends Controller
{
    public function index()
    {
        $permintaans = Permintaan::with('user')->latest()->paginate(10);
        return view('admin.permintaan.index', compact('permintaans'));
    }

    public function create()
    {
        $barangs = Barang::orderBy('nama_barang')->get();
        return view('admin.permintaan.create', compact('barangs'));
    }

    public function store(PermintaanRequest $request)
    {
        DB::transaction(function () use ($request) {
            $permintaan = Permintaan::create([
                'user_id' => Auth::id(),
                'kode_permintaan' => 'PRM-' . Carbon::now()->format('YmdHis'),
                'tanggal_permintaan' => $request->tanggal_permintaan,
                'status' => 'pending',
                'keterangan' => $request->keterangan,
            ]);

            foreach ($request->details as $item) {
                $permintaan->details()->create([
                    'barang_id' => $item['barang_id'],
                    'jumlah_diminta' => $item['jumlah_diminta'],
                ]);
            }
        });

        return redirect()->route('admin.permintaan.index')->with('success', 'Permintaan berhasil dibuat.');
    }

    public function show(Permintaan $permintaan)
    {
        $permintaan->load(['user', 'details.barang', 'persetujuan.user']);
        return view('admin.permintaan.show', compact('permintaan'));
    }
}
