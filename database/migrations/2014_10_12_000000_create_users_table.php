<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('nama_lengkap');
            $table->string('telepon', 15)->unique()->nullable();
            $table->text('alamat');
            $table->string('rt_rw', 10);
            $table->string('qrcode')->nullable();
            $table->string('password');
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->enum('role', ['admin', 'petugas', 'pelanggan']);
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
