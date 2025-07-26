<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Persetujuan extends Model
{
    use HasFactory;

    protected $table = 'persetujuans'; // Sesuai ERD

    protected $fillable = [
        'user_id',
        'persetujuanable_id',
        'persetujuanable_type',
        'status',
        'catatan',
        'tanggal_persetujuan',
    ];

    /**
     * Relasi untuk mendapatkan model induk yang disetujui
     * (bisa berupa Permintaan atau Inventaris).
     */
    public function persetujuanable(): MorphTo
    {
        return $this->morphTo();
    }

    /**
     * Relasi untuk mengetahui user siapa yang melakukan persetujuan.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
