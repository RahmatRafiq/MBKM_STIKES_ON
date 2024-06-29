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
        Schema::create('about_mbkms', function (Blueprint $table) {
            $table->id();
            $table->string('program_name');
            $table->text('description');
            $table->string('duration')->nullable(); // Duration of the program
            $table->string('eligibility')->nullable(); // Eligibility criteria for the program
            $table->string('benefits')->nullable(); // Benefits of the program
            $table->string('contact_email')->nullable(); // Contact email for inquiries
            $table->string('contact_phone')->nullable(); // Contact phone number for inquiries
            $table->string('contact_address')->nullable(); // Contact address for inquiries
            $table->timestamps(); // Created at and updated at timestamps
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_mbkms');
    }
};
