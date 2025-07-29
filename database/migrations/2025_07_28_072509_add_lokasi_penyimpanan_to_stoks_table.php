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
        Schema::table('stoks', function (Blueprint $table) {
            //
             // Menambahkan kolom 'lokasi_penyimpanan' setelah kolom 'stok_aman'
            $table->string('lokasi_penyimpanan', 255)
                  ->after('stok_aman')
                  ->nullable() // Membuat kolom bisa kosong (opsional tapi aman)
                  ->default('Gudang Utama'); // Memberi nilai default sesuai controller
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('stoks', function (Blueprint $table) {
            // Perintah untuk menghapus kolom jika diperlukan
            $table->dropColumn('lokasi_penyimpanan');
        });
    }
};
