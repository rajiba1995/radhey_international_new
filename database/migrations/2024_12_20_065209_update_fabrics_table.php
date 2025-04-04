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
            // Add the new column
            $table->unsignedBigInteger('product_id')->nullable()->after('id');
            
            // Rename the column
            $table->renameColumn('code', 'hexacode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fabrics', function (Blueprint $table) {
            // Drop the added column
            $table->dropColumn('product_id');
            
            // Rename the column back
            $table->renameColumn('hexacode', 'code');
        });
    }
};
