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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('status')->default(1); // Status of the order
            $table->decimal('paid_amount', 10, 2)->default(0.00); // Amount paid
            $table->decimal('remaining_amount', 10, 2)->default(0.00); // Remaining amount
            $table->timestamp('last_payment_date')->nullable(); // Last payment date
            $table->string('payment_mode')->nullable(); // Payment mode (e.g., cash, card, etc.)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('paid_amount');
            $table->dropColumn('remaining_amount');
            $table->dropColumn('last_payment_date');
            $table->dropColumn('payment_mode');
        });
    }
};
