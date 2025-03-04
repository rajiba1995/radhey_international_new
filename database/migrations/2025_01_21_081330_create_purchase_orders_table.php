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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('supplier_id');
            $table->string('unique_id')->unique();
            $table->json('product_ids')->nullable();
            $table->json('fabric_ids')->nullable();
            $table->text('address')->nullable();
            $table->string('city')->nullable();
            $table->string('pin')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('landmark')->nullable();
            $table->decimal('total_price', 15, 2);
            $table->boolean('is_good_in')->default(0);
            $table->enum('goods_in_type', ['scan', 'bulk'])->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};
