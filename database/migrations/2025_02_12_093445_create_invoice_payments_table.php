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
        Schema::create('invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->unsigned()->nullable();
            $table->foreignId('payment_collection_id')->unsigned()->nullable();
            $table->double('invoice_amount', 10, 2)->comment("invoice's net amount");
            $table->double('vouchar_amount', 10, 2);
            $table->double('paid_amount', 10, 2)->comment('payment amount');
            $table->double('rest_amount', 10, 2);
            $table->boolean('is_commisionable')->default(0)->comment('for staff');
            $table->string('invoice_no')->nullable();
            $table->string('voucher_no')->nullable()->comment('payment_receipt');
            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');
            $table->foreign('payment_collection_id')->references('id')->on('payment_collections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_payments');
    }
};
