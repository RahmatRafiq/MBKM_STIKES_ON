<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktifitasMbkmTable extends Migration
{
    public function up()
    {
        Schema::create('aktifitas_mbkm', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('peserta_id');
            $table->unsignedBigInteger('lowongan_id');
            $table->unsignedBigInteger('mitra_id');
            $table->unsignedBigInteger('dospem_id');
            $table->unsignedBigInteger('laporan_harian_id')->nullable();
            $table->unsignedBigInteger('laporan_mingguan_id')->nullable();
            $table->unsignedBigInteger('laporan_lengkap_id')->nullable();
            $table->timestamps();

            $table->foreign('peserta_id')->references('id')->on('peserta')->onDelete('cascade');
            $table->foreign('lowongan_id')->references('id')->on('lowongan')->onDelete('cascade');
            $table->foreign('mitra_id')->references('id')->on('mitra_profile')->onDelete('cascade');
            $table->foreign('dospem_id')->references('id')->on('dosen_pembimbing_lapangan')->onDelete('cascade');
            $table->foreign('laporan_harian_id')->references('id')->on('laporan_harian')->onDelete('cascade');
            $table->foreign('laporan_mingguan_id')->references('id')->on('laporan_mingguan')->onDelete('cascade');
            $table->foreign('laporan_lengkap_id')->references('id')->on('laporan_lengkap')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('aktifitas_mbkm');
    }
}
