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
        Schema::table('measurements', function (Blueprint $table) {
            Schema::table('measurements', function (Blueprint $table) {
                // Rename the column from subcategory_id to product_id
                $table->renameColumn('subcategory_id', 'product_id');
                
                // Drop the old foreign key constraint (if exists)
                $table->dropForeign(['subcategory_id']);
    
                // Add the new foreign key constraint
                $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            });
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('measurements', function (Blueprint $table) {
            Schema::table('measurements', function (Blueprint $table) {
                // Rename the column back to subcategory_id
                $table->renameColumn('product_id', 'subcategory_id');
                
                // Drop the new foreign key constraint
                $table->dropForeign(['product_id']);
                
                // Add the old foreign key constraint back
                $table->foreign('subcategory_id')->references('id')->on('products')->onDelete('cascade');
            });
        });
    }
};
