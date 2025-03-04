<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('business_type')->nullable()->after('id')->constrained('business_types')->onDelete('cascade');

            // $table->string('business_type')->nullable()->after('id'); // Adjust position as needed
            $table->string('employee_id')->nullable()->after('user_type'); // Adjust position as needed
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('business_type');
            $table->dropColumn('employee_id');
        });
    }
};
