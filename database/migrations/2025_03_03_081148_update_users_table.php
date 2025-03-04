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
        Schema::table('users', function (Blueprint $table) {
            $table->string('emp_code')->nullable()->after('name');
            $table->string('surname')->nullable()->after('emp_code');
            $table->string('prof_name')->nullable()->after('surname');

            $table->string('passport_no')->nullable()->after('passport_id_front');
            $table->string('visa_no')->nullable()->after('passport_no');

            $table->date('passport_issued_date')->nullable()->after('passport_id_back');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['emp_code', 'surname', 'prof_name', 'passport_no', 'visa_no', 'passport_issued_date']);
        });
    }
};
