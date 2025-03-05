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
            $table->string('alternative_phone_number_1')->nullable()->after('phone');
            $table->string('alternative_phone_number_2')->nullable()->after('alternative_phone_number_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['alternative_phone_number_1', 'alternative_phone_number_2']);
        });
    }
};
