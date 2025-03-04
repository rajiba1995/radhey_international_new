<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBusinessTypeToOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Schema::table('orders', function (Blueprint $table) {
        //     $table->unsignedBigInteger('business_type')->after('id')->nullable();

        //     // Add the foreign key constraint
        //     $table->foreign('business_type')
        //           ->references('id')
        //           ->on('business_type')
        //           ->onDelete('cascade')
        //           ->onUpdate('cascade');
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Drop the foreign key and column
            $table->dropForeign(['business_type']);
            $table->dropColumn('business_type');
        });
    }
}
