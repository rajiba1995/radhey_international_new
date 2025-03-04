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
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->decimal('paid_amount', 10, 2)->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('supplier_id')->nullable();
            $table->unsignedBigInteger('expense_id')->nullable();
            $table->unsignedBigInteger('service_slip_id')->nullable();
            $table->unsignedBigInteger('discount_id')->nullable();
            $table->string('payment_for')->nullable();
            $table->string('payment_in')->nullable();
            $table->enum('bank_cash', ['Bank', 'Cash'])->nullable();
            $table->string('voucher_no')->nullable();
            $table->date('payment_date')->nullable();
            $table->enum('payment_mode', ['Cash', 'Cheque', 'UPI', 'Bank Transfer'])->nullable();
            $table->decimal('amount', 10, 2)->nullable();
            $table->string('chq_utr_no')->nullable();
            $table->string('bank_name')->nullable();
            $table->text('narration')->nullable();
            $table->string('created_from')->nullable();
            $table->boolean('is_gst')->default(0);
            $table->timestamps();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();

            // Foreign Keys (Assuming Relationships Exist)
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('set null');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('set null');
            $table->foreign('expense_id')->references('id')->on('expences')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
