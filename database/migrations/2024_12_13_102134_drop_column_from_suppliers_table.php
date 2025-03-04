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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn([
                'is_wa_same',
                'shipping_address',
                'shipping_landmark',
                'shipping_state',
                'shipping_city',
                'shipping_pin',
                'shipping_country',
                'is_billing_shipping_same',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            // Re-adding columns (just in case you need to rollback)
            $table->boolean('is_wa_same')->default(false);
            $table->string('shipping_address')->nullable();
            $table->string('shipping_landmark')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_pin')->nullable();
            $table->string('shipping_country')->nullable();
            $table->boolean('is_billing_shipping_same')->default(false);
        });
    }
};
