<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PengeluaranRequest;
use App\Models\Barang;
use App\Models\Pengeluaran;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengeluaranController extends Controller
{
    public function index(Request $request)
    {
        $query = Pengeluaran::with(['user', 'details.barang']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_pengeluaran', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_pengeluaran', '<=', $request->tanggal_sampai);
        }

        // Search berdasarkan kode pengeluaran atau keterangan
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_pengeluaran', 'like', '%' . $request->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        $pengeluarans = $query->latest()->paginate(10);

        return view('admin.pengeluaran.index', compact('pengeluarans'));
    }


    public function create()
    {
        $barangs = Barang::with('stok')
                     ->whereHas('stok', function ($query) {
                         $query->where('jumlah_stok', '>', 0);
                     })
                     ->orderBy('nama_barang')
                     ->get();

        return view('admin.pengeluaran.create', compact('barangs'));
    }

    public function store(PengeluaranRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $pengeluaran = Pengeluaran::create([
                    'user_id' => Auth::id(),
                    'kode_pengeluaran' => 'OUT-' . Carbon::now()->format('YmdHis'),
                    'tanggal_pengeluaran' => $request->tanggal_pengeluaran,
                    'penerima' => $request->penerima,
                    'keterangan' => $request->keterangan,
                    'status' => 'draft',
                ]);

                foreach ($request->details as $item) {
                    // Validasi stok tersedia
                    $stok = Stok::where('barang_id', $item['barang_id'])->first();

                    if (!$stok || $stok->jumlah_stok < $item['jumlah_keluar']) {
                        throw new \Exception('Stok barang tidak mencukupi');
                    }

                    $pengeluaran->details()->create([
                        'barang_id' => $item['barang_id'],
                       'jumlah_dikeluarkan' => $item['jumlah_keluar'],
                        'keterangan_detail' => $item['keterangan_detail'] ?? null,
                    ]);
                }
            });

            return redirect()->route('admin.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat pengeluaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Pengeluaran $pengeluaran)
    {
        $pengeluaran->load(['user', 'details.barang']);
        return view('admin.pengeluaran.show', compact('pengeluaran'));
    }

    public function edit(Pengeluaran $pengeluaran)
    {
        // Hanya bisa edit jika status masih draft
        if ($pengeluaran->status !== 'draft') {
            return redirect()->route('admin.pengeluaran.index')
                ->with('error', 'Pengeluaran yang sudah diproses tidak dapat diedit.');
        }

        $barangs = Barang::whereHas('stok', function ($query) {
            $query->where('jumlah_stok', '>', 0);
        })->orderBy('nama_barang')->get();

        $pengeluaran->load('details.barang');

        return view('admin.pengeluaran.edit', compact('pengeluaran', 'barangs'));
    }

    public function update(PengeluaranRequest $request, Pengeluaran $pengeluaran)
    {
        // Hanya bisa update jika status masih draft
        if ($pengeluaran->status !== 'draft') {
            return redirect()->route('admin.pengeluaran.index')
                ->with('error', 'Pengeluaran yang sudah diproses tidak dapat diubah.');
        }

        try {
            DB::transaction(function () use ($request, $pengeluaran) {
                // Update data pengeluaran
                $pengeluaran->update([
                    'tanggal_pengeluaran' => $request->tanggal_pengeluaran,
                   'penerima' => $request->penerima,

                    'keterangan' => $request->keterangan,
                ]);

                // Hapus detail lama
                $pengeluaran->details()->delete();

                // Tambah detail baru
                foreach ($request->details as $item) {
                    // Validasi stok tersedia
                    $stok = Stok::where('barang_id', $item['barang_id'])->first();

                    if (!$stok || $stok->jumlah_stok < $item['jumlah_keluar']) {
                        throw new \Exception('Stok barang tidak mencukupi');
                    }

                    $pengeluaran->details()->create([
                        'barang_id' => $item['barang_id'],
                        'jumlah_dikeluarkan' => $item['jumlah_keluar'],
                        'keterangan_detail' => $item['keterangan_detail'] ?? null,
                    ]);
                }
            });

            return redirect()->route('admin.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui pengeluaran: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Pengeluaran $pengeluaran)
    {
        // Hanya bisa hapus jika status draft atau dibatalkan
        if (!in_array($pengeluaran->status, ['draft', 'dibatalkan'])) {
            return redirect()->route('admin.pengeluaran.index')
                ->with('error', 'Pengeluaran yang sudah diproses tidak dapat dihapus.');
        }

        try {
            DB::transaction(function () use ($pengeluaran) {
                // Hapus detail terlebih dahulu
                $pengeluaran->details()->delete();

                // Hapus pengeluaran
                $pengeluaran->delete();
            });

            return redirect()->route('admin.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengeluaran.index')
                ->with('error', 'Gagal menghapus pengeluaran: ' . $e->getMessage());
        }
    }

    public function approve(Pengeluaran $pengeluaran)
    {
        // Hanya bisa approve jika status draft
        if ($pengeluaran->status !== 'draft') {
            return redirect()->route('admin.pengeluaran.index')
                ->with('error', 'Pengeluaran ini tidak dapat diproses.');
        }

        try {
            DB::transaction(function () use ($pengeluaran) {
                // Update status pengeluaran
                $pengeluaran->update([
                    'status' => 'disetujui',
                    'tanggal_disetujui' => now(),
                    'disetujui_oleh' => Auth::id(),
                ]);

                // Kurangi stok untuk setiap detail
                foreach ($pengeluaran->details as $detail) {
                    $stok = Stok::where('barang_id', $detail->barang_id)->first();

                    if (!$stok || $stok->jumlah_stok < $detail->jumlah_keluar) {
                        throw new \Exception('Stok barang ' . $detail->barang->nama_barang . ' tidak mencukupi');
                    }

                    $stok->decrement('jumlah_stok', $detail->jumlah_keluar);

                    // Log pergerakan stok
                    $stok->pergerakan()->create([
                        'jenis_pergerakan' => 'keluar',
                        'jumlah' => $detail->jumlah_keluar,
                        'keterangan' => 'Pengeluaran - ' . $pengeluaran->kode_pengeluaran,
                        'user_id' => Auth::id(),
                    ]);
                }
            });

            return redirect()->route('admin.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil disetujui dan stok telah dikurangi.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengeluaran.index')
                ->with('error', 'Gagal menyetujui pengeluaran: ' . $e->getMessage());
        }
    }

    public function cancel(Pengeluaran $pengeluaran)
    {
        // Hanya bisa cancel jika status draft
        if ($pengeluaran->status !== 'draft') {
            return redirect()->route('admin.pengeluaran.index')
                ->with('error', 'Pengeluaran yang sudah diproses tidak dapat dibatalkan.');
        }

        try {
            $pengeluaran->update([
                'status' => 'dibatalkan',
                'tanggal_dibatalkan' => now(),
            ]);

            return redirect()->route('admin.pengeluaran.index')
                ->with('success', 'Pengeluaran berhasil dibatalkan.');
        } catch (\Exception $e) {
            return redirect()->route('admin.pengeluaran.index')
                ->with('error', 'Gagal membatalkan pengeluaran: ' . $e->getMessage());
        }
    }

    public function getStokBarang($barangId)
    {
        $stok = Stok::where('barang_id', $barangId)->first();

        return response()->json([
            'jumlah_stok' => $stok ? $stok->jumlah_stok : 0
        ]);
    }

    public function export(Request $request)
    {
        // Logic untuk export data pengeluaran ke Excel/PDF
        // Akan diimplementasikan sesuai kebutuhan
    }
}
