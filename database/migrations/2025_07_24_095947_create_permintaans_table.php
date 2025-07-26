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
        Schema::create('permintaans', function (Blueprint $table) {
            $table->id();
             $table->string('kode_permintaan')->unique();
        // Foreign key ke user yang mengajukan permintaan
        $table->foreignId('user_id')->constrained('users');
        $table->date('tanggal_permintaan');
        $table->enum('status', ['pending', 'disetujui', 'ditolak', 'diproses', 'selesai'])->default('pending');
        $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permintaans');
    }
};
