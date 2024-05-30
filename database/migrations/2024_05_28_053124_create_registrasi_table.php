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
        Schema::create('registrasi', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            // $table->string('nama_peserta');
            $table->unsignedBigInteger('lowongan_id');
            $table->string('status')->default('registered'); // Ubah status menjadi string
            $table->unsignedBigInteger('dospem_id')->nullable();
            $table->timestamps();
            
            // Indexes
            // $table->index('peserta_id');
            // $table->index('lowongan_id');
            // $table->index('dospem_id');
            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi');
    }
};
