<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddEmployeeIdToOtpsTable extends Migration
{
    public function up()
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->string('employee_id')->nullable()->after('email'); // Add after email column or as required
        });
    }

    public function down()
    {
        Schema::table('otps', function (Blueprint $table) {
            $table->dropColumn('employee_id');
        });
    }
}
