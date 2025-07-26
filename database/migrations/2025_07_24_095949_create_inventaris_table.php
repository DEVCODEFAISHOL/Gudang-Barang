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
        Schema::create('inventaris', function (Blueprint $table) {
         $table->id();
        $table->string('kode_inventaris')->unique();
        $table->date('tanggal_inventaris');
        // Foreign key ke user yang melakukan inventarisasi
        $table->foreignId('user_id')->constrained('users');
        $table->enum('status', ['berlangsung', 'selesai', 'dibatalkan'])->default('berlangsung');
        $table->text('catatan')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventaris');
    }
};
