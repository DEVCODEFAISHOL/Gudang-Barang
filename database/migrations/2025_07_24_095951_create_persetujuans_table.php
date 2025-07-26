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
        Schema::create('persetujuans', function (Blueprint $table) {
            $table->id();
        // Kolom untuk polymorphic relationship (contoh: bisa berelasi ke Permintaan, dll)
        $table->morphs('persetujuanable'); // Akan membuat persetujuanable_id dan persetujuanable_type
        // Foreign key ke user yang memberi persetujuan (manajer)
        $table->foreignId('user_id')->constrained('users');
        $table->enum('status', ['disetujui', 'ditolak']);
        $table->text('catatan')->nullable();
        $table->timestamp('tanggal_persetujuan')->useCurrent();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('persetujuans');
    }
};
