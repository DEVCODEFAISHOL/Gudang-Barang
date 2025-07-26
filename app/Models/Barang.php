<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barangs'; // Sesuai ERD

    protected $fillable = [
        'kategori_id',
        'kode_barang',
        'nama_barang',
        'satuan',
    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    // Sebuah barang memiliki satu entri stok (jika unik per barang)
    public function stok(): HasOne
    {
        return $this->hasOne(Stok::class, 'barang_id');
    }

    public function permintaanDetails(): HasMany
    {
        return $this->hasMany(PermintaanDetail::class, 'barang_id');
    }

    public function pengeluaranDetails(): HasMany
    {
        return $this->hasMany(PengeluaranDetail::class, 'barang_id');
    }

    public function inventarisDetails(): HasMany
    {
        return $this->hasMany(InventarisDetail::class, 'barang_id');
    }
}
