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
        Schema::create('stock_fabrics', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stock_id'); 
            $table->unsignedBigInteger('fabric_id'); 
            $table->decimal('qty_in_meter', 10, 2); 
            $table->decimal('piece_price', 10, 2); 
            $table->decimal('total_price', 15, 2); 
            $table->timestamps();

            $table->foreign('stock_id')->references('id')->on('stocks');
            $table->foreign('fabric_id')->references('id')->on('fabrics');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_fabrics');
    }
};
