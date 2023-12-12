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
        Schema::create('penawaran_lelangs', function (Blueprint $table) {
            $table->id();
            $table->foreignID('id_produk_lelang')->references('id')->on('produk_lelangs');
            $table->foreignID('id_user')->references('id')->on('users');
            $table->integer('status_tawaran');
            $table->integer('status_konfirmasi');
            $table->integer('penawaran_harga');
            $table->dateTime('tanggal_konfirmasi_lelang');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penawaran_lelangs');
    }
};
