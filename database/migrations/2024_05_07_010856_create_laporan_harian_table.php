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
        Schema::create('laporan_harian', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id');
            $table->tinyInteger('is_validate')->default(0);
            $table->string('attendance');
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_harian');
    }
};
// use Illuminate\Database\Migrations\Migration;
// use Illuminate\Database\Schema\Blueprint;
// use Illuminate\Support\Facades\Schema;

// class CreateLaporanHariansTable extends Migration
// {
//     /**
//      * Run the migrations.
//      *
//      * @return void
//      */
//     public function up()
//     {
//         Schema::create('laporan_harians', function (Blueprint $table) {
//             $table->id();
//             $table->unsignedBigInteger('peserta_id');
//             $table->unsignedBigInteger('mitra_id')->nullable();
//             $table->date('tanggal');
//             $table->text('isi_laporan');
//             $table->string('status');
//             $table->timestamps();

//             $table->foreign('peserta_id')->references('id')->on('pesertas')->onDelete('cascade');
//             $table->foreign('mitra_id')->references('id')->on('mitra_profiles')->onDelete('set null');
//         });
//     }

//     /**
//      * Reverse the migrations.
//      *
//      * @return void
//      */
//     public function down()
//     {
//         Schema::dropIfExists('laporan_harians');
//     }
// }