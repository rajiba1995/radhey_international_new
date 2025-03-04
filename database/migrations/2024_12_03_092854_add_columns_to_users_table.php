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
            $table->string('whatsapp_no')->nullable()->after('password');
            $table->string('gst_number')->nullable()->after('whatsapp_no');
            $table->string('gst_certificate_image')->nullable()->after('gst_number');
            $table->decimal('credit_limit', 15, 2)->nullable()->after('gst_certificate_image');
            $table->integer('credit_days')->nullable()->after('credit_limit');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'whatsapp_no',
                'gst_number',
                'gst_certificate_image',
                'credit_limit',
                'credit_days',
            ]);
        });
    }
};
