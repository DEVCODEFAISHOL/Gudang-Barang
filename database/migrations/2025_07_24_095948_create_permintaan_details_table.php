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
       Schema::create('permintaan_details', function (Blueprint $table) {
        $table->id();
        // Foreign key ke header permintaan
        $table->foreignId('permintaan_id')->constrained('permintaans')->onDelete('cascade');
        // Foreign key ke barang yang diminta
        $table->foreignId('barang_id')->constrained('barangs');
        $table->unsignedInteger('jumlah_diminta');
        $table->unsignedInteger('jumlah_disetujui')->nullable()->default(0); // Diisi saat proses persetujuan
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaan_details');
    }
};
