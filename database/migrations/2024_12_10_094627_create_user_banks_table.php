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
        Schema::create('user_banks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Foreign key referencing 'users.id'
            $table->string('account_holder_name')->comment('Banking credentials');
            $table->string('bank_name')->nullable()->comment('Banking credentials');
            $table->string('branch_name')->nullable()->comment('Banking credentials');
            $table->string('bank_account_no')->nullable()->comment('Banking credentials');
            $table->string('ifsc')->nullable()->comment('Banking credentials');
            $table->double('monthly_salary', 10, 2)->nullable()->comment('Salary & allowance');
            $table->double('daily_salary', 10, 2)->nullable()->comment('Salary & allowance');
            $table->double('travelling_allowance', 10, 2)->nullable()->comment('Salary & allowance');
            
            $table->timestamps();
             // Foreign key constraint
             $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_banks');
    }
};
