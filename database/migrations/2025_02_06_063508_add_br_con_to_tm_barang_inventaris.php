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
        Schema::table('tm_barang_inventaris', function (Blueprint $table) {
            $table->integer('br_con')->after('br_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tm_barang_inventaris', function (Blueprint $table) {
            $table->dropColumn('br_con');
        });
    }
};
