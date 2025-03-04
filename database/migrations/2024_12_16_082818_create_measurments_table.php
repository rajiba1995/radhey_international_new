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
        Schema::create('measurements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('subcategory_id'); // Match the data type of 'id' in 'subcategories'
            $table->string('title');
            $table->string('short_code');
            $table->boolean('status')->default(1);
            $table->integer('position')->default(0);
            $table->timestamps();
    
            // Define the foreign key
            $table->foreign('subcategory_id')
                  ->references('id')
                  ->on('sub_categories')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('measurments');
    }
};
