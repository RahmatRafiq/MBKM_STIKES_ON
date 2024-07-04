<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('laporan_harian', function (Blueprint $table) {
            $table->unsignedBigInteger('dospem_id')->nullable()->after('mitra_id');
            $table->text('feedback')->nullable()->after('kehadiran');
        });

        Schema::table('laporan_mingguan', function (Blueprint $table) {
            $table->unsignedBigInteger('dospem_id')->nullable()->after('mitra_id');
            $table->text('feedback')->nullable()->after('kehadiran');
        });

        Schema::table('laporan_lengkap', function (Blueprint $table) {
            $table->unsignedBigInteger('dospem_id')->nullable()->after('peserta_id');
            $table->text('feedback')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('laporan_harian', function (Blueprint $table) {
            $table->dropColumn('dospem_id');
            $table->dropColumn('feedback');
        });

        Schema::table('laporan_mingguan', function (Blueprint $table) {
            $table->dropColumn('dospem_id');
            $table->dropColumn('feedback');
        });

        Schema::table('laporan_lengkap', function (Blueprint $table) {
            $table->dropColumn('dospem_id');
            $table->dropColumn('feedback');
        });
    }
};
