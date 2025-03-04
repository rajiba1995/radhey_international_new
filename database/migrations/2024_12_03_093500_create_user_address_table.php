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
        Schema::create('user_address', function (Blueprint $table) {
            $table->id(); // Creates an auto-incrementing 'id' column
            $table->unsignedBigInteger('user_id'); // Foreign key referencing 'users.id'
            $table->string('address_type')->comment('1: billing; 2: shipping');;
            $table->string('address');
            $table->string('landmark');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('zip_code'); // Change 'number' to 'string' for zip code
            $table->timestamp('created_at')->useCurrent(); // Sets the default value to current timestamp
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate(); // Sets both default and update behavior to current timestamp

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_address');
    }
};
