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
        Schema::create('stocks', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('grn_no')->nullable(); // Goods Received Note number
            $table->unsignedBigInteger('purchase_order_id'); // Foreign key column
            $table->string('po_unique_id')->nullable(); // Purchase order unique ID
            $table->unsignedBigInteger('return_id')->nullable(); // Optional return ID
            $table->string('return_order_no')->nullable(); // Return order number
            $table->string('goods_in_type')->nullable(); // Type of goods in (e.g., Fabric, Product)
            $table->string('product_ids')->nullable(); // JSON column for product IDs
            $table->string('fabric_ids')->nullable(); // JSON column for fabric IDs
            $table->decimal('total_price', 15, 2)->default(0.00); // Total price
            $table->timestamps(); // Created at and updated at

            // Foreign key constraint
            $table->foreign('purchase_order_id')
                  ->references('id')
                  ->on('purchase_orders')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stocks');
    }
};
