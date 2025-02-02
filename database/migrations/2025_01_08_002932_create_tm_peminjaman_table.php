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
        Schema::create('tm_peminjaman', function (Blueprint $table) {
            $table->string('pb_id', 20)->primary();
            $table->string('user_id', 10);

            $table->dateTime('pb_tgl')->nullable();
            $table->string('siswa_id', 20)->nullable();

            $table->dateTime('pb_harus_kembali_tgl')->nullable();
            $table->string('pb_stat', 2)->nullable();
            $table->timestamps();

            //for
            $table->foreign('user_id')->references('user_id')->on('tm_user');
            // $table->foreign('siswa_id')->references('siswa_id')->on('siswa');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_peminjaman');
    }
};
