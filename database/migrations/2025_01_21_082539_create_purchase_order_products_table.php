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
        Schema::create('purchase_order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('purchase_order_id');
            $table->unsignedBigInteger('collection_id')->nullable();
            $table->enum('stock_type', ['fabric', 'product']); // Clearly identifies stock type
            $table->decimal('piece_price', 15, 2);
            $table->decimal('total_price', 15, 2);

            // Fabric-specific columns
            $table->unsignedBigInteger('fabric_id')->nullable();
            $table->string('fabric_name')->nullable();
            $table->decimal('qty_in_meter', 15, 2)->nullable();

            // Product-specific columns
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_name')->nullable();
            $table->integer('qty_in_pieces')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('purchase_order_id')->references('id')->on('purchase_orders')->onDelete('cascade');
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('set null');
            $table->foreign('fabric_id')->references('id')->on('fabrics')->onDelete('set null');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('set null');
       
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_order_products');
    }
};
