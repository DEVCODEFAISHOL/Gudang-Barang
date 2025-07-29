<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateStokRequest;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Query dasar dengan eager loading untuk efisiensi
        $query = Stok::with(['barang.kategori']);

        // Jika ada parameter pencarian, filter berdasarkan nama atau kode barang
        if ($search = $request->input('search')) {
            $query->whereHas('barang', function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhere('kode_barang', 'like', "%{$search}%");
            });
        }

        // Ambil data dengan paginasi
        $stoks = $query->latest('updated_at')->paginate(15)->withQueryString();

        return view('admin.stok.index', compact('stoks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Stok $stok)
    {
        // Load relasi barang agar namanya bisa ditampilkan di view
        $stok->load('barang');

        return view('admin.stok.edit', compact('stok'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateStokRequest $request, Stok $stok): RedirectResponse
    {
        try {
            // Mulai database transaction untuk memastikan konsistensi data
            DB::beginTransaction();

            // Ambil data yang sudah divalidasi dari request
            $validated = $request->validated();

            // Log untuk debugging (opsional, bisa dihapus di production)
            Log::info('Updating stock safety limit', [
                'stok_id' => $stok->id,
                'old_stok_aman' => $stok->stok_aman,
                'new_stok_aman' => $validated['stok_aman'],
                'barang_nama' => $stok->barang->nama_barang
            ]);

            // Update data stok
            $stok->update([
                   'jumlah_stok' => $validated['jumlah_stok'],
                'stok_aman' => $validated['stok_aman'],
                'lokasi_penyimpanan' => $validated['lokasi_penyimpanan'] ?? $stok->lokasi_penyimpanan,
            ]);

            // Refresh model untuk memastikan data terbaru
            $stok->refresh();

            // Commit transaction
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()
                ->route('admin.stok.index')
                ->with('success', 'Batas stok aman untuk barang "' . $stok->barang->nama_barang . '" berhasil diperbarui menjadi ' . number_format($stok->stok_aman) . '.');

        } catch (\Exception $e) {
            // Rollback transaction jika ada error
            DB::rollBack();

            // Log error
            Log::error('Error updating stock safety limit', [
                'stok_id' => $stok->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Redirect kembali dengan pesan error
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui data stok. Silakan coba lagi.');
        }
    }
}
