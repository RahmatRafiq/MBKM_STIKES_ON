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
        Schema::create('laporan_lengkap', function (Blueprint $table) {
            $table->id();
            $table->integer('peserta_id');
            $table->tinyInteger('is_validate')->default(0);
            $table->string('document');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_lengkap');
    }
};

// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateLaporanLengkapsTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('laporan_lengkaps', function (Blueprint $table) {
//             $table->id();
//             $table->unsignedBigInteger('peserta_id');
//             $table->unsignedBigInteger('dospem_id');
//             $table->text('isi_laporan');
//             $table->string('status');
//             $table->timestamps();

//             $table->foreign('peserta_id')->references('id')->on('pesertas')->onDelete('cascade');
//             $table->foreign('dospem_id')->references('id')->on('dosen_pembimbing_lapangans')->onDelete('cascade');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('laporan_lengkaps');
//     }
// }