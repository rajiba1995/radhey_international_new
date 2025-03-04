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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade'); // Assuming you have a 'products' table.
            // $table->foreignId('collection_type')->constrained('collection_types')->onDelete('cascade');
            $table->string('fabrics')->nullable(); // Assuming 'fabrics' table exists.
            $table->string('collection');
            $table->string('category')->nullable(); // Assuming you have a 'categories' table.
            $table->string('sub_category')->nullable(); // Assuming 'sub_categories' table exists.
            $table->string('product_name');
            $table->decimal('price', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
