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
        Schema::table('dosen_pembimbing_lapangan', function (Blueprint $table) {
            $table->dropColumn('roles_id');
            $table->dropColumn('users_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dosen_pembimbing_lapangan', function (Blueprint $table) {
            $table->string('address');
            $table->string('phone');
            $table->string('email');
            $table->string('nip');
        });
    }
};
