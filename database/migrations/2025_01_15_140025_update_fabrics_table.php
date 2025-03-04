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
        Schema::table('fabrics', function (Blueprint $table) {
            // Drop the product_id column
            $table->dropColumn('product_id');

            // Update the image column to allow null
            $table->string('image')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fabrics', function (Blueprint $table) {
            // Add the product_id column back
            $table->unsignedBigInteger('product_id');

            // Revert the image column to not null (adjust as needed)
            $table->string('image')->nullable(false)->change();
        });
    }
};
