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
        Schema::create('user_logins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->index(); // Foreign key to users table
            $table->string('country_code', 10);
            $table->string('mobile', 20)->unique();
            $table->boolean('is_verified')->default(false);
            $table->string('otp', 4)->nullable(); // Limit OTP length
            $table->string('mpin')->nullable(); // Store encrypted MPIN
            $table->string('device_id')->nullable()->unique(); // Unique device per user
            $table->timestamps();

            // Foreign key relation
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_logins');
    }
};
