<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PergerakanStok extends Model
{
    protected $fillable = [
        'stok_id',
        'jenis_pergerakan',
        'jumlah',
        'keterangan',
        'user_id',
    ];

    public function stok()
    {
        return $this->belongsTo(Stok::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
