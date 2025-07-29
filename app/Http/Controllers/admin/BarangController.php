<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Barang::with(['kategori', 'stok']);

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_barang', 'like', '%' . $search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $search . '%')
                  ->orWhereHas('kategori', function($kategoriQuery) use ($search) {
                      $kategoriQuery->where('nama_kategori', 'like', '%' . $search . '%');
                  });
            });
        }

        // Status filter
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Stock filter
        if ($request->has('stok_filter') && $request->stok_filter != '') {
            switch ($request->stok_filter) {
                case 'habis':
                    $query->whereHas('stok', function($stokQuery) {
                        $stokQuery->where('jumlah_stok', 0);
                    });
                    break;
                case 'rendah':
                    $query->whereHas('stok', function($stokQuery) {
                        $stokQuery->whereColumn('jumlah_stok', '<=', 'stok_aman')
                                 ->where('jumlah_stok', '>', 0);
                    });
                    break;
                case 'aman':
                    $query->whereHas('stok', function($stokQuery) {
                        $stokQuery->whereColumn('jumlah_stok', '>', 'stok_aman');
                    });
                    break;
            }
        }

        // Category filter
        if ($request->has('kategori_id') && $request->kategori_id != '') {
            $query->where('kategori_id', $request->kategori_id);
        }

        // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');

        $allowedSorts = ['nama_barang', 'kode_barang', 'created_at', 'updated_at'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortOrder);
        } else {
            $query->latest();
        }

        $barangs = $query->paginate(15)->withQueryString();

        // Statistics for dashboard cards
        $totalBarang = Barang::count();
        $barangAktif = Barang::where('status', 'aktif')->count();
        $stokRendah = Barang::whereHas('stok', function($q) {
            $q->whereColumn('jumlah_stok', '<=', 'stok_aman')
              ->where('jumlah_stok', '>', 0);
        })->count();
        $stokHabis = Barang::whereHas('stok', function($q) {
            $q->where('jumlah_stok', 0);
        })->count();

        $kategoris = Kategori::all(); // For filter dropdown

        return view('admin.barang.index', compact(
            'barangs',
            'totalBarang',
            'barangAktif',
            'stokRendah',
            'stokHabis',
            'kategoris'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();

        // Generate suggested kode_barang
        $lastBarang = Barang::latest('id')->first();
        $suggestedKode = 'BRG' . str_pad(($lastBarang ? $lastBarang->id + 1 : 1), 4, '0', STR_PAD_LEFT);

        return view('admin.barang.create', compact('kategoris', 'suggestedKode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBarangRequest $request)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();

            // Ensure kode_barang is unique
            $kodeBarang = $validatedData['kode_barang'];
            $counter = 1;
            while (Barang::where('kode_barang', $kodeBarang)->exists()) {
                $kodeBarang = $validatedData['kode_barang'] . '-' . $counter;
                $counter++;
            }
            $validatedData['kode_barang'] = $kodeBarang;

            // Set default status if not provided
            if (!isset($validatedData['status'])) {
                $validatedData['status'] = 'aktif';
            }

            // Create barang
            $barang = Barang::create($validatedData);

            // Auto create stock entry
            Stok::create([
                'barang_id' => $barang->id,
                'jumlah_stok' => $request->get('jumlah_stok_awal', 0),
                'stok_aman' => $request->get('stok_aman', 10),
                'lokasi_penyimpanan' => $request->get('lokasi_penyimpanan', 'Gudang Utama'),
            ]);

            DB::commit();

            Log::info('Barang baru ditambahkan: ' . $barang->nama_barang, [
                'barang_id' => $barang->id,
                'user_id' => auth()->id()
            ]);

            return redirect()
                ->route('admin.barang.index')
                ->with('success', 'Barang "' . $barang->nama_barang . '" berhasil ditambahkan.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating barang: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menambahkan barang. Silakan coba lagi.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Barang $barang)
    {
        $barang->load([
            'kategori',
            'stok',
            'permintaanDetails.permintaan:id,nomor_permintaan,tanggal_permintaan,created_at',
            'pengeluaranDetails.pengeluaran:id,nomor_pengeluaran,tanggal_pengeluaran,created_at',
            'inventarisDetails.inventaris:id,nomor_inventaris,tanggal_inventaris,created_at'
        ]);

        // Get recent activities (last 30 days)
        $recentActivities = collect();

        // Add permintaan activities
        foreach ($barang->permintaanDetails()->whereHas('permintaan', function($q) {
            $q->where('created_at', '>=', now()->subDays(30));
        })->with('permintaan')->latest()->get() as $detail) {
            $recentActivities->push([
                'type' => 'permintaan',
                'date' => $detail->permintaan->created_at,
                'description' => 'Permintaan ' . $detail->jumlah_diminta . ' unit',
                'amount' => $detail->jumlah_diminta,
                'reference' => $detail->permintaan->nomor_permintaan
            ]);
        }

        // Add pengeluaran activities
        foreach ($barang->pengeluaranDetails()->whereHas('pengeluaran', function($q) {
            $q->where('created_at', '>=', now()->subDays(30));
        })->with('pengeluaran')->latest()->get() as $detail) {
            $recentActivities->push([
                'type' => 'pengeluaran',
                'date' => $detail->pengeluaran->created_at,
                'description' => 'Pengeluaran ' . $detail->jumlah_keluar . ' unit',
                'amount' => -$detail->jumlah_keluar,
                'reference' => $detail->pengeluaran->nomor_pengeluaran
            ]);
        }

        // Add inventaris activities
        foreach ($barang->inventarisDetails()->whereHas('inventaris', function($q) {
            $q->where('created_at', '>=', now()->subDays(30));
        })->with('inventaris')->latest()->get() as $detail) {
            $recentActivities->push([
                'type' => 'inventaris',
                'date' => $detail->inventaris->created_at,
                'description' => 'Inventaris ' . $detail->jumlah_fisik . ' unit',
                'amount' => $detail->jumlah_fisik,
                'reference' => $detail->inventaris->nomor_inventaris
            ]);
        }

        // Sort activities by date
        $recentActivities = $recentActivities->sortByDesc('date')->take(10);

        // Generate stock movement data for chart (last 30 days)
        $stockMovement = $this->generateStockMovementData($barang);

        return view('admin.barang.show', compact('barang', 'recentActivities', 'stockMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Barang $barang)
    {
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        $barang->load('stok');

        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        try {
            DB::beginTransaction();

            $validatedData = $request->validated();

            // Check if kode_barang is unique (excluding current barang)
            if (isset($validatedData['kode_barang'])) {
                $kodeExists = Barang::where('kode_barang', $validatedData['kode_barang'])
                                   ->where('id', '!=', $barang->id)
                                   ->exists();

                if ($kodeExists) {
                    return back()
                        ->withInput()
                        ->withErrors(['kode_barang' => 'Kode barang sudah digunakan.']);
                }
            }

            $oldData = $barang->toArray();
            $barang->update($validatedData);

            DB::commit();

            Log::info('Barang diperbarui: ' . $barang->nama_barang, [
                'barang_id' => $barang->id,
                'old_data' => $oldData,
                'new_data' => $validatedData,
                'user_id' => auth()->id()
            ]);

            return redirect()
                ->route('admin.barang.index')
                ->with('success', 'Barang "' . $barang->nama_barang . '" berhasil diperbarui.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating barang: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui barang. Silakan coba lagi.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang)
    {
        try {
            // Validation checks
            $validationErrors = [];

            // Check if has stock
            if ($barang->stok && $barang->stok->jumlah_stok > 0) {
                $validationErrors[] = 'Barang masih memiliki stok sebanyak ' . $barang->stok->jumlah_stok . ' unit.';
            }

            // Check if used in transactions
            if ($barang->permintaanDetails()->count() > 0) {
                $validationErrors[] = 'Barang telah digunakan dalam ' . $barang->permintaanDetails()->count() . ' permintaan.';
            }

            if ($barang->pengeluaranDetails()->count() > 0) {
                $validationErrors[] = 'Barang telah digunakan dalam ' . $barang->pengeluaranDetails()->count() . ' pengeluaran.';
            }

            if ($barang->inventarisDetails()->count() > 0) {
                $validationErrors[] = 'Barang telah digunakan dalam ' . $barang->inventarisDetails()->count() . ' inventaris.';
            }

            if (!empty($validationErrors)) {
                return back()->with('error', 'Tidak bisa menghapus barang: ' . implode(' ', $validationErrors));
            }

            DB::beginTransaction();

            $namaBarang = $barang->nama_barang;

            // Delete related stock first
            if ($barang->stok) {
                $barang->stok->delete();
            }

            // Delete the barang
            $barang->delete();

            DB::commit();

            Log::info('Barang dihapus: ' . $namaBarang, [
                'barang_id' => $barang->id,
                'user_id' => auth()->id()
            ]);

            return redirect()
                ->route('admin.barang.index')
                ->with('success', 'Barang "' . $namaBarang . '" berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error deleting barang: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat menghapus barang. Silakan coba lagi.');
        }
    }

    /**
     * Check if kode_barang is unique
     */
    public function checkKodeBarang(Request $request)
    {
        $kode = $request->get('kode_barang');
        $barangId = $request->get('barang_id');

        $query = Barang::where('kode_barang', $kode);

        if ($barangId) {
            $query->where('id', '!=', $barangId);
        }

        $exists = $query->exists();

        return response()->json([
            'available' => !$exists,
            'message' => $exists ? 'Kode barang sudah digunakan' : 'Kode barang tersedia'
        ]);
    }

    /**
     * Export barang data
     */
    public function export(Request $request)
    {
        // Implementation for export functionality
        // Could be Excel, PDF, or CSV export
        return response()->json(['message' => 'Export functionality to be implemented']);
    }

    /**
     * Bulk operations
     */
    public function bulkAction(Request $request)
    {
        $action = $request->get('action');
        $barangIds = $request->get('barang_ids', []);

        if (empty($barangIds)) {
            return back()->with('error', 'Tidak ada barang yang dipilih.');
        }

        try {
            DB::beginTransaction();

            switch ($action) {
                case 'activate':
                    Barang::whereIn('id', $barangIds)->update(['status' => 'aktif']);
                    $message = count($barangIds) . ' barang berhasil diaktifkan.';
                    break;

                case 'deactivate':
                    Barang::whereIn('id', $barangIds)->update(['status' => 'tidak_aktif']);
                    $message = count($barangIds) . ' barang berhasil dinonaktifkan.';
                    break;

                default:
                    return back()->with('error', 'Aksi tidak valid.');
            }

            DB::commit();

            return back()->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in bulk action: ' . $e->getMessage());

            return back()->with('error', 'Terjadi kesalahan saat melakukan aksi bulk.');
        }
    }

    /**
     * Generate stock movement data for chart
     */
    private function generateStockMovementData(Barang $barang)
    {
        $dates = [];
        $stockLevels = [];

        // Generate last 30 days
        for ($i = 29; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dates[] = $date->format('M d');

            // For now, use current stock level
            // In real implementation, you would calculate historical stock levels
            $stockLevels[] = $barang->stok ? $barang->stok->jumlah_stok : 0;
        }

        return [
            'dates' => $dates,
            'stockLevels' => $stockLevels,
            'stokAman' => $barang->stok ? $barang->stok->stok_aman : 0
        ];
    }
}
