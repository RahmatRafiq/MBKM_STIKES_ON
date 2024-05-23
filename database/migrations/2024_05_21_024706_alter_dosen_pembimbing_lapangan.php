<?php

use App\Models\User;
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
        // Schema::table('dosen_pembimbing_lapangan', function (Blueprint $table) {
           
        //     if (Schema::hasColumn('dosen_pembimbing_lapangan', 'user_id')) {
        //         $table->dropColumn('user_id');
        //     }
        //     $table->string('address');
        //     $table->string('phone');
        //     $table->string('nip');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('dosen_pembimbing_lapangan', function (Blueprint $table) {
        //     $table->foreignIdFor(User::class)->nullable();
        // });
        //
        // Schema::table('dosen_pembimbing_lapangan', function (Blueprint $table) {
        //     $table->dropColumn(["address", "phone", "nip"]);
        //     $table->dropColumn('phone');
        //     $table->dropColumn('nip');
        // });
    }
};
