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
      Schema::create('pergerakan_stoks', function (Blueprint $table) {
    $table->id();
    $table->foreignId('stok_id')->constrained('stoks')->onDelete('cascade');
    $table->enum('jenis_pergerakan', ['masuk', 'keluar']);
    $table->integer('jumlah');
    $table->string('keterangan')->nullable();
    $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pergerakan_stoks');
    }
};
