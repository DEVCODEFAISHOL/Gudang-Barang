<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stoks', function (Blueprint $table) {
            $table->id();
            // Foreign key ke tabel barangs (harus unik untuk relasi one-to-one)
            $table->foreignId('barang_id')->unique()->constrained('barangs')->onDelete('cascade');
            $table->unsignedInteger('jumlah_stok')->default(0);
            $table->unsignedInteger('stok_aman')->default(0); // Batas minimum stok
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stoks');
    }
};
