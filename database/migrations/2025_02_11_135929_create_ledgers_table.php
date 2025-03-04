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
        Schema::create('ledgers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->enum('user_type', ['staff', 'customer', 'partner', 'supplier'])->default('staff');
            $table->bigInteger('staff_id')->unsigned()->nullable();
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('supplier_id')->unsigned()->nullable();
            $table->bigInteger('admin_id')->unsigned()->nullable();
            $table->bigInteger('payment_id')->unsigned()->nullable();
            $table->bigInteger('staff_commision_id')->unsigned()->nullable();
            $table->bigInteger('collection_staff_commission_id')->unsigned()->nullable();
            $table->bigInteger('store_bad_debt_id')->unsigned()->nullable();
            $table->string('transaction_id', 244)->nullable()->comment('invoice_no / voucher_no');
            $table->double('transaction_amount', 10, 2)->notNullable();
            $table->boolean('is_credit')->default(false);
            $table->boolean('is_debit')->default(false);
            $table->enum('bank_cash', ['bank', 'cash'])->default('bank');
            $table->date('entry_date')->nullable();
            $table->string('purpose', 255)->nullable();
            $table->text('purpose_description')->nullable();
            $table->datetime('start_date')->nullable();
            $table->integer('whatsapp_status')->default(0)->comment('0:Pending, 1:Sent, 2: Cancel');
            $table->datetime('last_whatsapp')->nullable();
            $table->timestamps();

            $table->foreign('staff_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('supplier_id')->references('id')->on('suppliers')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
