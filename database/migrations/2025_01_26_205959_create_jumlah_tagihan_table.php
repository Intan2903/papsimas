<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jumlah_tagihan', function (Blueprint $table) {
            $table->id();
            $table->string('jumlah_tagihan');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jumlah_tagihan');
    }
};
