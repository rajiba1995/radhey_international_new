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
        Schema::table('products', function (Blueprint $table) {
             // Drop the existing 'hsn_code' column
             $table->dropColumn('hsn_code');
            
             // Add the new 'product_code' column
             $table->string('product_code')->nullable()->after('description'); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
             // Revert the change by adding 'hsn_code' column back
             $table->string('hsn_code')->nullable(); // Modify the column type and properties as per your requirements

             // Drop the 'product_code' column
             $table->dropColumn('product_code');
        });
    }
};
