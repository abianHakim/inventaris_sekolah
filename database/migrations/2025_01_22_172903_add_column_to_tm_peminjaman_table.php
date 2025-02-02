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
        Schema::table('tm_peminjaman', function (Blueprint $table) {
            $table->foreign('siswa_id')->references('siswa_id')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tm_peminjaman', function (Blueprint $table) {
            $table->dropForeign('tm_peminjaman_siswa_id_foreign');
        });
    }
};

