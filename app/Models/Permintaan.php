<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Permintaan extends Model
{
    use HasFactory;

    protected $table = 'permintaans'; // Sesuai ERD

    protected $fillable = [
        'user_id',
        'kode_permintaan',
        'tanggal_permintaan',
        'status',
        'keterangan', // Sesuai ERD
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(PermintaanDetail::class, 'permintaan_id');
    }

    public function persetujuan(): MorphOne
    {
        return $this->morphOne(Persetujuan::class, 'persetujuanable');
    }
    public function pengeluaran()
{
    return $this->hasMany(Pengeluaran::class, 'permintaan_id');
}

}
