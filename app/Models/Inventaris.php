<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Inventaris extends Model
{
    use HasFactory;

    protected $table = 'inventaris'; // Sesuai ERD

    protected $fillable = [
        'user_id',
        'kode_inventaris',
        'tanggal_inventaris',
        'status',
        'catatan',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function details(): HasMany
    {
        return $this->hasMany(InventarisDetail::class, 'inventaris_id');
    }

    // Berdasarkan ERD, inventaris juga bisa memiliki persetujuan
    public function persetujuan(): MorphOne
    {
        return $this->morphOne(Persetujuan::class, 'persetujuanable');
    }
}
