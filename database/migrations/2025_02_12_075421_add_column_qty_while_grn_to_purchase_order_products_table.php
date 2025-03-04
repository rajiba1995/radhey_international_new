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
        Schema::table('purchase_order_products', function (Blueprint $table) {
            $table->decimal('qty_while_grn_product',10,2)->after('qty_in_pieces')->nullable();
            $table->decimal('qty_while_grn_fabric',10,2)->after('qty_in_meter')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('purchase_order_products', function (Blueprint $table) {
            $table->dropColumn('qty_while_grn_product');
            $table->dropColumn('qty_while_grn_fabric');
        });
    }
};
