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
        Schema::table('td_peminjaman_barang', function (Blueprint $table) {
            //foreign 
            $table->foreign('pb_id')->references('pb_id')->on('tm_peminjaman');
            $table->foreign('br_kode')->references('br_kode')->on('tm_barang_inventaris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('td_peminjaman_barang', function (Blueprint $table) {

            $table->dropForeign('td_peminjaman_barang_pb_id_foreign');
            $table->dropForeign('td_peminjaman_barang_br_kode_foreign');
        });
    }
};
