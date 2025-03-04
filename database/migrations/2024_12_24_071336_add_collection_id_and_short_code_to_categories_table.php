<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.2024_12_24_065427_remove_column_from_collections_table
     */
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('collection_id')->nullable()->after('id');
            $table->string('short_code')->nullable()->after('collection_id'); 
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropForeign(['collection_id']); 
            $table->dropColumn('collection_id');    
            $table->dropColumn('short_code');      
        });
    }
};
