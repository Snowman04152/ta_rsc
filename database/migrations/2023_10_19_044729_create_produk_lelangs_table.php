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
        Schema::create('produk_lelangs', function (Blueprint $table) {
            $table->id();
            
            $table->dateTime('tanggal_mulai_lelang');
            $table->dateTime('tanggal_selesai_lelang');
            $table->dateTime('tanggal_konfirmasi_lelang');
            $table->date('tanggal_pengambilan')->nullable();
            $table->string('lokasi_pengambilan')->nullable();
            $table->string('nama_produk_lelang');
            $table->integer('harga_lelang');
            $table->integer('harga_lelang_process');
            $table->float('berat');
            $table->string('umur_simpan');
            $table->integer('kelipatan');
            $table->text('deskripsi');
            $table->integer('status_lelang');
            $table->string('original_filename')->nullable();
            $table->string('encrypted_filename')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk_lelangs');
    }
};
