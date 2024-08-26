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
        Schema::create('team_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ketua_id')->constrained('peserta')->onDelete('cascade'); // ID ketua tim
            $table->foreignId('peserta_id')->constrained('peserta')->onDelete('cascade'); // ID anggota tim
            $table->foreignId('members_id')->constrained('peserta')->onDelete('cascade'); // Alternatif untuk anggota (misalnya untuk peran khusus)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_members');
    }
};
