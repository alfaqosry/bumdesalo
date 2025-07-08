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
        Schema::create('penjualans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id');
            $table->foreign('barang_id')->references('id')->on('barangs');
            $table->integer('harga');
            $table->integer('sisa_stok');
            $table->integer('kuantitas');
            $table->foreignId('kasir_id');
            $table->foreign('kasir_id')->references('id')->on('users');
          

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penjualans');
    }
};
