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
        Schema::create('transaksi_lelangs', function (Blueprint $table) {
            $table->id();
            $table->string('kurir')->nullable();
            $table->string('resi')->nullable();
            $table->integer('harga_ongkir')->nullable();
            $table->string('metode_transaksi')->nullable();
            $table->foreignID('id_penawaran')->references('id')->on('penawaran_lelangs')->nullable();
            $table->foreignID('id_alamat')->nullable()->references('id')->on('alamats');
            $table->integer('total_harga');
            $table->integer('status');
            $table->integer('tipe_transaksi');
            $table->string('snaptoken')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_lelangs');
    }
};
