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
        Schema::create('produks', function (Blueprint $table) {
            $table->id();
            $table->string('nama_produk');
            $table->integer('rating')->nullable();
            $table->date('tanggal_pengambilan')->nullable();
            $table->integer('status')->nullable();
            $table->integer('stok')->nullable();
            $table->integer('status_pengambilan')->nullable();
            $table->string('lokasi_pengambilan')->nullable();
            $table->string('original_filename')->nullable();
            $table->string('encrypted_filename')->nullable();
            $table->string('umur_simpan');
            $table->text('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
