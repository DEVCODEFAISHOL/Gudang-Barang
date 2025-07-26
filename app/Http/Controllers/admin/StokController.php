<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateStokRequest;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class StokController extends Controller
{
    /**
     * Display a listing of the resource.
     */
      public function index(Request $request)
    {
        //
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


    public function edit(Stok $stok)
    {
        // Load relasi barang agar namanya bisa ditampilkan di view
        $stok->load('barang');

        return view('admin.stok.edit', compact('stok'));
    }

    /**
     * Memperbarui data 'stok_aman' di dalam database.
     *
     * @param UpdateStokRequest $request
     * @param Stok $stok
     * @return RedirectResponse
     */
    public function update(UpdateStokRequest $request, Stok $stok): RedirectResponse
    {
        // Update model Stok dengan data yang sudah divalidasi
        $stok->update($request->validated());

        return redirect()
            ->route('admin.stok.index')
            ->with('success', 'Batas stok aman untuk barang "' . $stok->barang->nama_barang . '" berhasil diperbarui.');
    }
}
