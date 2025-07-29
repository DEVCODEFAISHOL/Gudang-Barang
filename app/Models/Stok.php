<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stoks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'barang_id',
        'jumlah_stok',
        'stok_aman',
        'lokasi_penyimpanan', // <-- TAMBAHKAN INI
    ];

    /**
     * Relasi ke Barang: Setiap entri stok pasti milik satu barang.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }
    // App\Models\Stok.php
public function pergerakan()
{
    return $this->hasMany(PergerakanStok::class, 'stok_id');
}

}
