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
        Schema::create('journals', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('payment_id')->unsigned()->nullable();
            $table->double('transaction_amount', 10, 2);
            $table->boolean('is_credit')->default(false);
            $table->boolean('is_debit')->default(false);
            $table->string('bank_cash')->default('bank');
            $table->string('purpose')->nullable();
            $table->text('purpose_description')->nullable();
            $table->string('purpose_id')->nullable()->comment('invoice_no / voucher_no');
            $table->date('entry_date')->nullable();
            $table->boolean('is_gst')->default(true);
            $table->timestamps();

            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('journals');
    }
};
