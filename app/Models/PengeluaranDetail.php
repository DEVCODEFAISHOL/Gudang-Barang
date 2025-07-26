<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PengeluaranDetail extends Model
{
    use HasFactory;

    protected $table = 'pengeluaran_details'; // Sesuai ERD

    protected $fillable = [
        'pengeluaran_id',
        'barang_id',
        'jumlah_dikeluarkan',
    ];

    public function pengeluaran(): BelongsTo
    {
        return $this->belongsTo(Pengeluaran::class, 'pengeluaran_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
