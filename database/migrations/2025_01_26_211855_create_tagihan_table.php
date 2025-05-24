<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tagihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pelanggan')->constrained('users')->onDelete('cascade');
            $table->foreignId('id_jumlah_tagihan')->constrained('jumlah_tagihan')->onDelete('cascade');
            $table->string('jumlah_tagihan')->nullable();
            $table->enum('metode_pembayaran', ['transfer', 'tunai'])->nullable();
            $table->enum('status', ['lunas', 'menunggu', 'belum lunas']);
            $table->string('bukti_pembayaran')->nullable();
            $table->timestamps();
        });        
    }

    public function down(): void
    {
        Schema::dropIfExists('tagihan');
    }
};
