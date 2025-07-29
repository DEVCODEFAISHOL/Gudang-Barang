<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PermintaanRequest;
use App\Models\Barang;
use App\Models\Permintaan;
use Illuminate\Http\Request; // Tambahkan ini untuk method index
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PermintaanController extends Controller
{
    // Method index dari contoh sebelumnya yang lebih lengkap, gunakan ini
    public function index(Request $request)
    {
        $query = Permintaan::with(['user', 'details']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where('kode_permintaan', 'like', '%' . $request->search . '%');
        }

        $permintaans = $query->latest()->paginate(10)->withQueryString();
        return view('admin.permintaan.index', compact('permintaans'));
    }

    public function create()
    {
        // --- MULAI PERBAIKAN ---
        // Eager load relasi 'stok' untuk setiap barang agar efisien dan data tersedia
        $barangs = Barang::with('stok')
                         ->where('status', 'aktif')
                         ->orderBy('nama_barang')
                         ->get();
        // --- SELESAI PERBAIKAN ---
        return view('admin.permintaan.create', compact('barangs'));
    }

    public function store(PermintaanRequest $request)
    {
        // Pastikan 'details' tidak kosong sebelum loop
        if (empty($request->details)) {
            return back()->with('error', 'Anda harus menambahkan setidaknya satu barang.')->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $permintaan = Permintaan::create([
                    'user_id' => Auth::id(),
                    'kode_permintaan' => 'PRM-' . Carbon::now()->format('YmdHis'),
                    'tanggal_permintaan' => $request->tanggal_permintaan,
                    'status' => 'pending',
                    'keterangan' => $request->keterangan,
                ]);

                foreach ($request->details as $item) {
                    // Validasi tambahan jika perlu (misal: jumlah tidak boleh 0)
                    if (empty($item['barang_id']) || empty($item['jumlah_diminta'])) continue;

                    $permintaan->details()->create([
                        'barang_id' => $item['barang_id'],
                        'jumlah_diminta' => $item['jumlah_diminta'],
                    ]);
                }
            });

            return redirect()->route('admin.permintaan.index')->with('success', 'Permintaan berhasil dibuat.');
        } catch (\Exception $e) {
            // Berikan pesan error yang lebih informatif untuk debugging
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    public function show(Permintaan $permintaan)
    {
        $permintaan->load(['user', 'details.barang', 'persetujuan.user']);
        return view('admin.permintaan.show', compact('permintaan'));
    }
}
