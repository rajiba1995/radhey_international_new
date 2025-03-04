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
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->unsignedBigInteger('customer_id')->nullable()->after('order_number');
        //     $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->dropForeign(['customer_id']); // Drop the foreign key
        //     $table->dropColumn('customer_id');   // Drop the column
        // });
    }
};
