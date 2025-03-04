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
        Schema::create('invoices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('order_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable()->comment('order placed by whom or staff_id');
            $table->bigInteger('packingslip_id')->unsigned()->nullable();
            $table->string('invoice_no', 255)->nullable();
            $table->double('net_price', 10, 2)->comment('total amount');
            $table->double('required_payment_amount', 10, 2);
            $table->boolean('payment_status')->default(false)->comment('0:pending;1:half_paid;2:full_paid');
            $table->boolean('is_paid')->default(false);
            $table->bigInteger('created_by')->unsigned()->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->bigInteger('updated_by')->unsigned()->nullable();
            $table->timestamp('updated_at')->useCurrent();

            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
