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
        Schema::create('invoice_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->index()->constrained('invoices')->onDelete('cascade');
            $table->foreignId('product_id')->index()->constrained('products')->onDelete('cascade');
            $table->string('product_name', 255)->nullable();
            $table->integer('quantity')->nullable();
            $table->double('single_product_price', 10, 2)->nullable(false)->comment('order_product_piece_price');
            $table->double('total_price', 10, 2)->nullable(false);
            $table->tinyInteger('is_store_address_outstation')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_products');
    }
};
