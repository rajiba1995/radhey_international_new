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
        Schema::create('sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id'); // Define as unsigned to match the referenced primary key type
            $table->string('title');
            $table->boolean('status')->default(1)->comment('1: Active, 0: Inactive');
            $table->timestamps();
            $table->softDeletes(); // Soft delete column

            // Add the foreign key constraint
            $table->foreign('category_id')
                  ->references('id')
                  ->on('categories')
                  ->onDelete('cascade') // Optional: Adjust cascade behavior as needed
                  ->onUpdate('cascade'); // Optional: Adjust cascade behavior as needed
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sub_categories');
    }
};
