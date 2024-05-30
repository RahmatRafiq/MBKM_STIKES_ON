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
        Schema::create('lowongan', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('mitra_id');
            $table->string('description');
            $table->integer('quota');
            $table->boolean('is_open');
            $table->string('location');
            $table->string('gpa');
            $table->enum('semester', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'])->nullable();
            $table->string('experience_required');
            $table->date('start_date');
            $table->date('end_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongan');
    }
};
