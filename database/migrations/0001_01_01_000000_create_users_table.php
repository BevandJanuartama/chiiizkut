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
        // Tabel Users dengan Username dan Role
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username')->unique(); // Mengganti name/email menjadi username
            $table->string('password');
            $table->enum('role', ['admin', 'kasir'])->default('kasir'); // Tambah Role
            $table->rememberToken();
            $table->timestamps();
        });

        // Tabel Reset Password (Opsional, tapi bagus untuk jaga-jaga)
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('username')->primary(); // Pakai username sebagai kunci
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // Tabel Sessions (PENTING: Agar error 'sessions not found' hilang)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};