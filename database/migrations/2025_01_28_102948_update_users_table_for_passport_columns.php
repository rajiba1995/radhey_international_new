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
            // Rename the columns
            $table->renameColumn('user_id_back', 'passport_id_back');
            $table->renameColumn('user_id_front', 'passport_id_front');
    
            // Add the new column for passport expiry date
            $table->date('passport_expiry_date')->nullable()->after('passport_id_back');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revert the changes in case of rollback
            $table->renameColumn('passport_id_back', 'user_id_back');
            $table->renameColumn('passport_id_front', 'user_id_front');

            // Drop the passport expiry date column
            $table->dropColumn('passport_expiry_date');
        });
    }
};
