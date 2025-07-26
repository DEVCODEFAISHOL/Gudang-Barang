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
        Schema::create('inventaris_details', function (Blueprint $table) {
            $table->id();
            // Foreign key ke header inventaris
            $table->foreignId('inventaris_id')->constrained('inventaris')->onDelete('cascade');
            // Foreign key ke barang yang dihitung
            $table->foreignId('barang_id')->constrained('barangs');
            $table->integer('stok_sistem'); // Jumlah stok menurut sistem saat itu
            $table->integer('stok_fisik');  // Jumlah stok hasil hitungan fisik
            $table->integer('selisih');       // Hasil dari stok_fisik - stok_sistem
            $table->text('keterangan')->nullable(); // Penjelasan jika ada selisih
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris_details');
    }
};
