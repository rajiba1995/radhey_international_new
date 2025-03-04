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
        Schema::create('packingslips', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('invoice_id')->unsigned()->nullable();
            $table->string('slipno', 100)->nullable();
            $table->boolean('is_disbursed')->default(false);
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamp('updated_at')->useCurrent();
            $table->bigInteger('disbursed_by')->unsigned()->nullable();
            $table->timestamp('disbursed_at')->nullable();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_slips');
    }
};
