<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

use Spatie\Permission\Traits\HasRoles; // Import trait Spatie

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles; // Gunakan trait HasRoles

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relasi ke Permintaan: Seorang user bisa membuat banyak permintaan.
     */
    public function permintaan()
    {
        return $this->hasMany(Permintaan::class);
    }

    /**
     * Relasi ke Pengeluaran: Seorang user bisa mencatat banyak pengeluaran.
     */
    public function pengeluaran()
    {
        return $this->hasMany(Pengeluaran::class);
    }

    /**
     * Relasi ke Inventaris: Seorang user bisa mencatat banyak inventaris masuk.
     */
    public function inventaris()
    {
        return $this->hasMany(Inventaris::class);
    }
     public function persetujuans(): HasMany
    {
        return $this->hasMany(Persetujuan::class);
    }
}
