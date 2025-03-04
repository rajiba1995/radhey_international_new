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
        Schema::create('payment_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('customer_id')->unsigned()->nullable();
            $table->bigInteger('user_id')->unsigned()->nullable();
            $table->bigInteger('admin_id')->unsigned()->nullable();
            $table->bigInteger('payment_id')->unsigned()->nullable();
            $table->double('collection_amount', 10, 2)->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('voucher_no', 255)->nullable()->comment('payment receipt voucher no');
            $table->string('payment_type', 255)->default('cheque')->comment('cheque,neft,cash');
            $table->string('bank_name', 255)->nullable();
            $table->string('cheque_number', 255)->nullable();
            $table->boolean('is_ledger_added')->default(false);
            $table->string('image', 255)->nullable();
            $table->integer('is_approve')->comment('1=approved');
            $table->enum('created_from', ['web', 'app'])->default('app');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('payment_id')->references('id')->on('payments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_collections');
    }
};
