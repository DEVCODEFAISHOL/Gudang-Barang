<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stok extends Model
{
    use HasFactory;

    protected $table = 'stoks';

    protected $fillable = [
        'barang_id',
        'jumlah_stok',
        'stok_aman',
    ];

    /**
     * Relasi ke Barang: Setiap entri stok pasti milik satu barang.
     */
    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }


}
