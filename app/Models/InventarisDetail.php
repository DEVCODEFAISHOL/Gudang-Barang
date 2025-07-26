<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InventarisDetail extends Model
{
    use HasFactory;

    protected $table = 'inventaris_details'; // Sesuai ERD

    protected $fillable = [
        'inventaris_id',
        'barang_id',
        'stok_sistem',
        'stok_fisik',
        'selisih',
        'keterangan',
    ];

    public function inventaris(): BelongsTo
    {
        return $this->belongsTo(Inventaris::class, 'inventaris_id');
    }

    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }
}
