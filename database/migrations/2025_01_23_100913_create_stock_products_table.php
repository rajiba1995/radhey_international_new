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
        Schema::create('stock_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id'); 
            $table->unsignedBigInteger('product_id'); 
            $table->integer('qty_in_pieces'); 
            $table->decimal('piece_price', 10, 2); 
            $table->decimal('total_price', 15, 2);
            $table->timestamps();

            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('product_id')->references('id')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_products');
    }
};
