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
        Schema::table('suppliers', function (Blueprint $table) {
            $table->unsignedBigInteger('country_id')->nullable()->after('email');
            $table->string('country_code', 10)->nullable()->after('country_id');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
            $table->string('alternative_phone_number_1', 20)->nullable()->after('whatsapp_no');
            $table->string('alternative_phone_number_2', 20)->nullable()->after('alternative_phone_number_1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            $table->dropColumn('country_code');
            $table->dropForeign(['country_code', 'country_id', 'alternative_phone_number_1', 'alternative_phone_number_2']);
        });
    }
};
