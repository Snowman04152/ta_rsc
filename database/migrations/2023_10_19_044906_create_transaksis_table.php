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
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->string('kurir')->nullable();
            $table->integer('harga_ongkir')->nullable();
            $table->foreignID('id_alamat')->nullable()->references('id')->on('alamats');
            $table->foreignID('id_user')->references('id')->on('users')->nullable();
            $table->integer('tipe_transaksi');
            $table->integer('total_harga');
            $table->string('snaptoken')->nullable();
            $table->integer('status');
            $table->string('resi')->nullable();
            $table->timestamps();  
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};
