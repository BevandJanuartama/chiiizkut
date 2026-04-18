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
            $table->string('kode_unik')->unique();
            $table->string('nama')->nullable();
            $table->string('telepon')->nullable();
            $table->decimal('total', 15, 2); // Naikkan ke 15 digit agar lebih lega untuk Rupiah
            $table->string('metode_pembayaran')->nullable(); 
            
            // TAMBAHKAN KOLOM INI AGAR CONTROLLER TIDAK ERROR
            $table->integer('nomor_antrean')->default(0); 
            $table->enum('status', ['pending', 'sukses', 'gagal'])->default('pending');
            
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
