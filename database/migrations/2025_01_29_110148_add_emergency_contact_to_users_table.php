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
            $table->string('emergency_contact_person')->nullable()->after('passport_id_front');
            $table->string('emergency_mobile')->nullable()->after('emergency_contact_person');
            $table->string('emergency_whatsapp')->nullable()->after('emergency_mobile');
            $table->text('emergency_address')->nullable()->after('emergency_whatsapp');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'emergency_contact_person',
                'emergency_mobile',
                'emergency_whatsapp',
                'emergency_address',
            ]);
        });
    }
};
