<?php

use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\KatalogController;
use App\Http\Controllers\manager\LaporanController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminInventarisController;

use App\Http\Controllers\ManagerLaporanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\manager\DashboardController;
use App\Http\Controllers\manager\PersetujuanController;


use App\Http\Controllers\Admin;
use App\Http\Controllers\admin\BarangController;
use App\Http\Controllers\admin\InventarisController;
use App\Http\Controllers\admin\PengeluaranController;
use App\Http\Controllers\admin\PermintaanController;
use App\Http\Controllers\admin\StokController;
use App\Http\Controllers\AdminBarangController;
use App\Http\Controllers\AdminPengeluaranController;
use App\Http\Controllers\AdminPermintaanController;
use App\Http\Controllers\AdminStokController;
use App\Http\Controllers\Manager;

// Halaman utama
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/katalog', [KatalogController::class, 'index'])->name('katalog.index');
Route::get('/katalog/{barang:slug}', [KatalogController::class, 'show'])->name('katalog.show');
Route::get('/kontak', [ContactController::class, 'index'])->name('contact'); // Ubah dari contact.index ke contact
Route::post('/kontak', [ContactController::class, 'store'])->name('contact.store');
Route::get('/about', function () {
    return view('about');
})->name('about');

// Dashboard umum (fallback)
Route::get('/dashboard', function () {
    // Redirect ke dashboard yang sesuai berdasarkan role
    if (auth()->user()->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }
    if (Auth::user()->hasRole('manager')) {
        return redirect()->route('manager.dashboard');
    }
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Rute umum untuk user yang sudah login
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ---- RUTE UNTUK ADMIN ----
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [Admin\DashboardController::class, 'index'])->name('dashboard'); // Anda perlu membuat Admin\DashboardController

    Route::resource('barang', BarangController::class);
    Route::resource('stok', StokController::class)->only(['index', 'edit', 'update']); // Stok biasanya tidak dibuat/dihapus manual
    Route::resource('permintaan', PermintaanController::class)->only(['index', 'create', 'store', 'show']);
    Route::resource('pengeluaran', PengeluaranController::class)->only(['index', 'create', 'store', 'show']);
     // =================== INVENTARIS (STOK OPNAME) ROUTES ===================
    Route::prefix('inventaris')->name('inventaris.')->group(function () {
        Route::get('/', [InventarisController::class, 'index'])->name('index');
        Route::get('/create', [InventarisController::class, 'create'])->name('create');
        Route::post('/', [InventarisController::class, 'store'])->name('store');
        Route::get('/{inventaris}', [InventarisController::class, 'show'])->name('show');
        Route::get('/{inventaris}/edit', [InventarisController::class, 'edit'])->name('edit');
        Route::put('/{inventaris}', [InventarisController::class, 'update'])->name('update');
        Route::delete('/{inventaris}', [InventarisController::class, 'destroy'])->name('destroy');

        // Additional actions
        Route::patch('/{inventaris}/approve', [InventarisController::class, 'approve'])->name('approve');
        Route::patch('/{inventaris}/cancel', [InventarisController::class, 'cancel'])->name('cancel');
        Route::get('/{inventaris}/report', [InventarisController::class, 'generateReport'])->name('report');
        Route::get('/barang/{barang}/stok-sistem', [InventarisController::class, 'getStokSistem'])->name('stok-sistem');
        Route::get('/export', [InventarisController::class, 'export'])->name('export');

        // Bulk opname routes
        Route::get('/bulk/create', [InventarisController::class, 'bulkOpname'])->name('bulk.create');
        Route::post('/bulk', [InventarisController::class, 'storeBulkOpname'])->name('bulk.store');
    });
});

// ---- RUTE UNTUK MANAGER ----
Route::middleware(['auth', 'role:manager'])->prefix('manager')->name('manager.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Persetujuan
    Route::get('persetujuan', [PersetujuanController::class, 'index'])->name('persetujuan.index');
    Route::get('persetujuan/{permintaan}', [PersetujuanController::class, 'show'])->name('persetujuan.show');
    Route::post('persetujuan/{permintaan}', [PersetujuanController::class, 'proses'])->name('persetujuan.proses');

    // Laporan
    Route::get('laporan', [LaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/stok', [LaporanController::class, 'stok'])->name('laporan.stok');
    Route::get('laporan/barang-masuk', [LaporanController::class, 'barangMasuk'])->name('laporan.masuk');
    Route::get('laporan/barang-keluar', [LaporanController::class, 'barangKeluar'])->name('laporan.keluar');
});


require __DIR__.'/auth.php';
