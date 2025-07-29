<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\InventarisRequest;
use App\Models\Barang;
use App\Models\Inventaris;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventarisController extends Controller
{
    public function index(Request $request)
    {
        $query = Inventaris::with(['user', 'details.barang']);

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_dari')) {
            $query->whereDate('tanggal_inventaris', '>=', $request->tanggal_dari);
        }

        if ($request->filled('tanggal_sampai')) {
            $query->whereDate('tanggal_inventaris', '<=', $request->tanggal_sampai);
        }

        // Search berdasarkan kode opname atau keterangan
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('kode_inventaris', 'like', '%' . $request->search . '%')
                    ->orWhere('keterangan', 'like', '%' . $request->search . '%');
            });
        }

        $inventaris = $query->latest()->paginate(10);

        return view('admin.inventaris.index', compact('inventaris'));
    }


    public function create()
    {
        $barangs = Barang::with('stok')->where('status', 'aktif')->orderBy('nama_barang')->get();
        return view('admin.inventaris.create', compact('barangs'));
    }

    public function store(InventarisRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $inventaris = Inventaris::create([
                    'user_id' => Auth::id(),
                    'kode_inventaris' => 'SO-' . Carbon::now()->format('YmdHis'),
                    'tanggal_inventaris' => $request->tanggal_inventaris,
                    'keterangan' => $request->keterangan,
                    'status' => 'berlangsung',
                ]);

                foreach ($request->details as $item) {
                    // Ambil stok sistem saat ini
                    $stok = Stok::where('barang_id', $item['barang_id'])->first();
                    $stok_sistem = $stok ? $stok->jumlah_stok : 0;

                    $inventaris->details()->create([
                        'barang_id' => $item['barang_id'],
                        'stok_sistem' => $stok_sistem,
                        'stok_fisik' => $item['stok_fisik'],
                        'selisih' => $item['stok_fisik'] - $stok_sistem,
                        'keterangan_detail' => $item['keterangan_detail'] ?? null,
                    ]);
                }
            });

            return redirect()->route('admin.inventaris.index')
                ->with('success', 'Stok Opname berhasil dibuat.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal membuat stok opname: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Inventaris $inventaris)
    {
        $inventaris->load(['user', 'details.barang']);
        return view('admin.inventaris.show', compact('inventaris'));
    }

    public function edit(Inventaris $inventaris)
    {
        // Hanya bisa edit jika status masih berlangsung
        if ($inventaris->status !== 'berlangsung') {
            return redirect()->route('admin.inventaris.index')
                ->with('error', 'Stok Opname yang sudah diproses tidak dapat diedit.');
        }

        $barangs = Barang::with('stok')->where('status', 'aktif')->orderBy('nama_barang')->get();
        $inventaris->load('details.barang');

        return view('admin.inventaris.edit', compact('inventaris', 'barangs'));
    }

    public function update(InventarisRequest $request, Inventaris $inventaris)
    {
        // Hanya bisa update jika status masih berlangsung
        if ($inventaris->status !== 'berlangsung') {
            return redirect()->route('admin.inventaris.index')
                ->with('error', 'Stok Opname yang sudah diproses tidak dapat diubah.');
        }

        try {
            DB::transaction(function () use ($request, $inventaris) {
                // Update data inventaris
                $inventaris->update([
                    'tanggal_inventaris' => $request->tanggal_inventaris,
                    'keterangan' => $request->keterangan,
                ]);

                // Hapus detail lama
                $inventaris->details()->delete();

                // Tambah detail baru
                foreach ($request->details as $item) {
                    // Ambil stok sistem saat ini
                    $stok = Stok::where('barang_id', $item['barang_id'])->first();
                    $stok_sistem = $stok ? $stok->jumlah_stok : 0;

                    $inventaris->details()->create([
                        'barang_id' => $item['barang_id'],
                        'stok_sistem' => $stok_sistem,
                        'stok_fisik' => $item['stok_fisik'],
                        'selisih' => $item['stok_fisik'] - $stok_sistem,
                        'keterangan_detail' => $item['keterangan_detail'] ?? null,
                    ]);
                }
            });

            return redirect()->route('admin.inventaris.index')
                ->with('success', 'Stok Opname berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Gagal memperbarui stok opname: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy(Inventaris $inventaris)
    {
        // Hanya bisa hapus jika status berlangsung atau dibatalkan
        if (!in_array($inventaris->status, ['berlangsung', 'dibatalkan'])) {
            return redirect()->route('admin.inventaris.index')
                ->with('error', 'Stok Opname yang sudah diproses tidak dapat dihapus.');
        }

        try {
            DB::transaction(function () use ($inventaris) {
                // Hapus detail terlebih dahulu
                $inventaris->details()->delete();

                // Hapus inventaris
                $inventaris->delete();
            });

            return redirect()->route('admin.inventaris.index')
                ->with('success', 'Stok Opname berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('admin.inventaris.index')
                ->with('error', 'Gagal menghapus stok opname: ' . $e->getMessage());
        }
    }

        public function approve(Inventaris $inventaris)
        {
            // Hanya bisa approve jika status berlangsung
            if ($inventaris->status !== 'berlangsung') {
                return redirect()->route('admin.inventaris.index')
                    ->with('error', 'Stok Opname ini tidak dapat diproses.');
            }

            try {
                DB::transaction(function () use ($inventaris) {
                    // Update status inventaris
                    $inventaris->update([
                        'status' => 'selesai',
                        'tanggal_disetujui' => now(),
                        'disetujui_oleh' => Auth::id(),
                    ]);

                    // Update stok berdasarkan hasil opname
                    foreach ($inventaris->details as $detail) {
                        if ($detail->selisih != 0) {
                            $stok = Stok::where('barang_id', $detail->barang_id)->first();

                            if ($stok) {
                                // Update stok dengan nilai fisik
                                $stok->update(['jumlah_stok' => $detail->stok_fisik]);

                                // Log pergerakan stok
                                $jenis_pergerakan = $detail->selisih > 0 ? 'masuk' : 'keluar';
                                $jumlah = abs($detail->selisih);

                                $stok->pergerakan()->create([
                                    'jenis_pergerakan' => $jenis_pergerakan,
                                    'jumlah' => $jumlah,
                                    'keterangan' => 'Stok Opname - ' . $inventaris->kode_inventaris .
                                        ' (Selisih: ' . $detail->selisih . ')',
                                    'user_id' => Auth::id(),
                                ]);
                            }
                        }
                    }
                });

    return redirect()->route('admin.inventaris.index')
                    // DIUBAH: Pesan disesuaikan
                    ->with('success', 'Stok Opname berhasil diselesaikan dan stok telah disesuaikan.');
            } catch (\Exception $e) {
                return redirect()->route('admin.inventaris.index')
                    ->with('error', 'Gagal menyelesaikan stok opname. ' . $e->getMessage());
            }
        }

}
