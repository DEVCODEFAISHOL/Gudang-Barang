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
        Schema::create('pengeluarans', function (Blueprint $table) {
              $table->id();
        $table->string('kode_pengeluaran')->unique();
        // Opsional: Foreign key ke permintaan, jika pengeluaran berdasarkan permintaan
        $table->foreignId('permintaan_id')->nullable()->constrained('permintaans');
        // Foreign key ke user yang memproses pengeluaran (staff gudang)
        $table->foreignId('user_id')->constrained('users');
        $table->date('tanggal_pengeluaran');
        $table->string('penerima'); // Nama orang atau departemen yang menerima barang
        $table->text('keterangan')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengeluarans');
    }
};
