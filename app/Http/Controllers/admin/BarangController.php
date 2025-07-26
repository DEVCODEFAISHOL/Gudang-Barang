<?php


namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBarangRequest;
use App\Http\Requests\UpdateBarangRequest;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BarangController extends Controller
{
    public function index()
    {
        $barangs = Barang::with(['kategori', 'stok'])->latest()->paginate(10);
        return view('admin.barang.index', compact('barangs'));
    }

    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.barang.create', compact('kategoris'));
    }

    public function store(StoreBarangRequest $request)
    {
        DB::transaction(function () use ($request) {
            $barang = Barang::create($request->validated());
            // Otomatis buat entri stok baru untuk barang ini
            Stok::create([
                'barang_id' => $barang->id,
                'jumlah_stok' => 0, // Stok awal
                'stok_aman' => 10, // Default stok aman
            ]);
        });

        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil ditambahkan.');
    }

    public function show(Barang $barang)
    {
        $barang->load(['kategori', 'stok', 'permintaanDetails', 'pengeluaranDetails', 'inventarisDetails']);
        return view('admin.barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $kategoris = Kategori::all();
        return view('admin.barang.edit', compact('barang', 'kategoris'));
    }

    public function update(UpdateBarangRequest $request, Barang $barang)
    {
        $barang->update($request->validated());
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil diperbarui.');
    }

    public function destroy(Barang $barang)
    {
        // Tambahkan validasi, misal: tidak bisa hapus jika stok masih ada atau ada di transaksi
        if ($barang->stok && $barang->stok->jumlah_stok > 0) {
            return back()->with('error', 'Tidak bisa menghapus barang yang masih memiliki stok.');
        }

        $barang->delete();
        return redirect()->route('admin.barang.index')->with('success', 'Barang berhasil dihapus.');
    }
}
