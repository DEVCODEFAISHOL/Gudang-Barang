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
        Schema::create('pengeluaran_details', function (Blueprint $table) {
          $table->id();
        // Foreign key ke header pengeluaran
        $table->foreignId('pengeluaran_id')->constrained('pengeluarans')->onDelete('cascade');
        // Foreign key ke barang yang dikeluarkan
        $table->foreignId('barang_id')->constrained('barangs');
        $table->unsignedInteger('jumlah_dikeluarkan');
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluaran_details');
    }
};
