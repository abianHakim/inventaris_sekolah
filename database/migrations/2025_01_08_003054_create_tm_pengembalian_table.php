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
        Schema::create('tm_pengembalian', function (Blueprint $table) {
            $table->string('kembali_id', 10)->primary()->notNullable();

            $table->string('pb_id', 20);
            $table->foreign('pb_id')->references('pb_id')->on('tm_peminjaman');


            $table->string('user_id', 10);
            $table->foreign('user_id')->references('user_id')->on('tm_user');

            $table->dateTime("kembali_tgl");
            $table->string("kembali_sts", 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tm_pengembalian');
    }
};
