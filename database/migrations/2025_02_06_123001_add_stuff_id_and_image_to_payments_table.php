<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStuffIdAndImageToPaymentsTable extends Migration
{
    public function up()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->unsignedBigInteger('stuff_id')->nullable()->after('admin_id'); // Adjust placement as needed
            $table->string('image')->nullable()->after('voucher_no'); // Adjust placement if needed
            $table->foreign('stuff_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropForeign(['stuff_id']); // Drop foreign key constraint
            $table->dropColumn('stuff_id');
            $table->dropColumn('image');
        });
    }
}
