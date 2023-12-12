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
        Schema::create('pengingat_lelangs', function (Blueprint $table) {
            $table->id();
            $table->foreignID('id_produk_lelang')->references('id')->on('produk_lelangs');
            $table->foreignID('id_user')->references('id')->on('users');
            $table->integer('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengingat_lelangs');
    }
};
