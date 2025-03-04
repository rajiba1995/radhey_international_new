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
        Schema::create('expences', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->boolean('for_debit')->default(0);
            $table->boolean('for_credit')->default(0);
            $table->boolean('for_staff')->default(0);
            $table->boolean('for_store')->default(0);
            $table->boolean('for_partner')->default(0);
            $table->boolean('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expences');
    }
};
