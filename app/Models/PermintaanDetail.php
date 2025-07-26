<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PermintaanDetail extends Model
{
    use HasFactory;

    protected $table = 'permintaan_details'; // Sesuai ERD

    protected $fillable = [
        'permintaan_id',
        'barang_id',
        'jumlah_diminta',
        'jumlah_disetujui',
    ];

    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class, 'permintaan_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
