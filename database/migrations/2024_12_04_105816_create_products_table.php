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
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->unsignedBigInteger('category_id'); // Foreign key to categories
            $table->unsignedBigInteger('sub_category_id')->nullable(); // Foreign key to sub_categories, nullable if not mandatory
            $table->string('name'); // Product name
            $table->string('hsn_code')->nullable(); // HSN Code, nullable if not mandatory
            $table->string('short_description', 255)->nullable(); // Short Description
            $table->text('description')->nullable(); // Full Description
            $table->decimal('gst_details', 5, 2)->default(0); // GST Details (In Percent)
            $table->string('product_image')->nullable(); // Product Image (Path)
            $table->timestamps(); // Created at and Updated at

            // Foreign key constraints
            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('sub_category_id')->references('id')->on('sub_categories')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
