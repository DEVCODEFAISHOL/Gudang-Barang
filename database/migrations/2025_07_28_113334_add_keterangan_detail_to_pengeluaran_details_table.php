<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
// database/migrations/xxxx_xx_xx_xxxxxx_add_keterangan_detail_to_pengeluaran_details_table.php

public function up(): void
{
    Schema::table('pengeluaran_details', function (Blueprint $table) {
        // Tambahkan kolom baru setelah kolom 'jumlah_dikeluarkan'
        $table->text('keterangan_detail')->nullable()->after('jumlah_dikeluarkan');
    });
}

public function down(): void
{
    Schema::table('pengeluaran_details', function (Blueprint $table) {
        // Perintah untuk membatalkan (jika rollback)
        $table->dropColumn('keterangan_detail');
    });
}
};
