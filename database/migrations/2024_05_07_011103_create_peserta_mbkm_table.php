<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('peserta', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->string('nama');
            $table->string('nim')->unique();
            $table->string('email')->unique();
            $table->string('jurusan')->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('jenis_kelamin')->nullable();
            $table->string('alamat')->nullable();
            $table->string('telepon')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('peserta');
    }
};
