<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('stok_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produk_varian_id')
                ->constrained('produk_varians')
                ->cascadeOnDelete();

            $table->integer('jumlah_masuk');
            $table->integer('stok_sebelumnya');
            $table->integer('stok_sesudahnya');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stok_logs');
    }
};
