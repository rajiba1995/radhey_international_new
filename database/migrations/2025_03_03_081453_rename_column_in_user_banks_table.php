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
        Schema::table('user_banks', function (Blueprint $table) {
            $table->renameColumn('daily_salary', 'bonus');
            $table->renameColumn('travelling_allowance', 'past_salaries');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_banks', function (Blueprint $table) {
            $table->renameColumn('bonus', 'daily_salary');
            $table->renameColumn('past_salaries', 'travelling_allowance');
        });
    }
};
