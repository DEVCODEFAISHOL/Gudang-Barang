<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pengeluaran extends Model
{
    use HasFactory;

    protected $table = 'pengeluarans'; // Sesuai ERD

    protected $fillable = [
        'user_id',
        'permintaan_id', // Bisa null
        'kode_pengeluaran',
        'tanggal_pengeluaran',
        'penerima',
        'keterangan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Pengeluaran ini bisa jadi berasal dari sebuah permintaan
    public function permintaan(): BelongsTo
    {
        return $this->belongsTo(Permintaan::class, 'permintaan_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PengeluaranDetail::class, 'pengeluaran_id');
    }
}
