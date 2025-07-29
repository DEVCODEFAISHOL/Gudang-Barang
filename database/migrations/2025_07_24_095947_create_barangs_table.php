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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->onDelete('cascade');
            $table->string('kode_barang', 50)->unique();
            $table->string('nama_barang', 255);
            $table->enum('satuan', ['pcs', 'kg', 'liter', 'meter', 'unit', 'set', 'box', 'pack', 'gram', 'ton', 'ml']);
            $table->text('deskripsi')->nullable();
            $table->decimal('harga_beli', 12, 2)->nullable();
            $table->decimal('harga_jual', 12, 2)->nullable();
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('aktif');
            $table->text('spesifikasi')->nullable();
            $table->string('merk', 100)->nullable();
            $table->timestamps();

            // Indexes for better performance
            $table->index(['kategori_id', 'status']);
            $table->index(['kode_barang']);
            $table->index(['nama_barang']);
            $table->index(['status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
