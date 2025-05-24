<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pengaduan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_pengguna')->constrained('users')->onDelete('cascade');
            $table->text('isi');
            $table->text('balasan')->nullable();
            $table->timestamps();
        });        
    }
    public function down(): void
    {
        Schema::dropIfExists('pengaduan');
    }
};
