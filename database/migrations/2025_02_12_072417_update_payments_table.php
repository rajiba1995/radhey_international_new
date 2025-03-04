<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Remove existing columns
        Schema::table('payments', function (Blueprint $table) {
            // $table->dropColumn('user_id');
            $table->dropColumn('store_id');
        });

        // Add new column
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id')->after('supplier_id')->nullable();
            $table->foreign('customer_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rollback changes
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('store_id')->nullable();
            $table->dropForeign('payments_customer_id_foreign');
            $table->dropColumn('customer_id');
        });
    }
}
