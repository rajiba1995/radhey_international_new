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
        // Schema::table('order_items', function (Blueprint $table) {
        //     // Check if 'collection_type' exists before renaming
        //     if (Schema::hasColumn('order_items', 'collection_type')) {
        //         $table->renameColumn('collection_type', 'collection_id');
        //     }

        //     // Check if 'category' exists before dropping
        //     if (Schema::hasColumn('order_items', 'category')) {
        //         $table->dropColumn('category');
        //     }

        //     // Update 'collection' column to represent the category
        //     $table->string('collection')->nullable()->comment('Represents the category')->after('product_name');
        // });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Schema::table('order_items', function (Blueprint $table) {
        //     // Check if 'collection_id' exists before renaming back
        //     if (Schema::hasColumn('order_items', 'collection_id')) {
        //         $table->renameColumn('collection_id', 'collection_type');
        //     }

        //     // Recreate the 'category' column
        //     $table->string('category')->nullable()->after('collection_id');

        //     // Optionally reverse the changes made to 'collection'
        //     $table->string('collection')->comment(null)->change();
        // });
    }
};
