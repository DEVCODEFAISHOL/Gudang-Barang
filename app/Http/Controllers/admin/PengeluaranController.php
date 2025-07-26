<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Pengeluaran;
use App\Models\Permintaan;
use App\Models\Stok;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PengeluaranController extends Controller
{
    public function index()
    {
        $pengeluarans = Pengeluaran::with(['user', 'permintaan'])->latest()->paginate(10);
        return view('admin.pengeluaran.index', compact('pengeluarans'));
    }

    // Buat pengeluaran dari permintaan yang sudah disetujui
    public function create(Request $request)
    {
        $permintaan = null;
        if ($request->has('permintaan_id')) {
            $permintaan = Permintaan::with('details.barang')
                ->where('status', 'approved')
                ->findOrFail($request->permintaan_id);
        }

        // Daftar permintaan yang sudah disetujui tapi belum diproses
        $approvedPermintaans = Permintaan::where('status', 'approved')
            ->whereDoesntHave('pengeluaran')
            ->get();

        return view('admin.pengeluaran.create', compact('permintaan', 'approvedPermintaans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'permintaan_id' => 'required|exists:permintaans,id',
            'tanggal_pengeluaran' => 'required|date',
            'penerima' => 'required|string',
            'details' => 'required|array',
            'details.*.barang_id' => 'required|exists:barangs,id',
            'details.*.jumlah_dikeluarkan' => 'required|integer|min:1',
        ]);

        $permintaan = Permintaan::findOrFail($request->permintaan_id);

        DB::transaction(function () use ($request, $permintaan) {
            $pengeluaran = Pengeluaran::create([
                'user_id' => Auth::id(),
                'permintaan_id' => $permintaan->id,
                'kode_pengeluaran' => 'OUT-' . Carbon::now()->format('YmdHis'),
                'tanggal_pengeluaran' => $request->tanggal_pengeluaran,
                'penerima' => $request->penerima,
            ]);

            foreach ($request->details as $item) {
                // Validasi stok cukup
                $stok = Stok::where('barang_id', $item['barang_id'])->first();
                if (!$stok || $stok->jumlah_stok < $item['jumlah_dikeluarkan']) {
                    // Batalkan transaksi dan kirim error
                    throw new \Exception('Stok untuk barang ' . $stok->barang->nama_barang . ' tidak mencukupi.');
                }

                $pengeluaran->details()->create([
                    'barang_id' => $item['barang_id'],
                    'jumlah_dikeluarkan' => $item['jumlah_dikeluarkan'],
                ]);

                // Kurangi stok
                $stok->decrement('jumlah_stok', $item['jumlah_dikeluarkan']);
            }

            // Update status permintaan menjadi completed
            $permintaan->update(['status' => 'completed']);
        });

        return redirect()->route('admin.pengeluaran.index')->with('success', 'Data pengeluaran berhasil disimpan.');
    }

    public function show(Pengeluaran $pengeluaran)
    {
        $pengeluaran->load(['user', 'permintaan', 'details.barang']);
        return view('admin.pengeluaran.show', compact('pengeluaran'));
    }
}
