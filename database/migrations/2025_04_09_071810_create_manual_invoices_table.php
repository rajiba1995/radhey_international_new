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
        Schema::create('manual_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_no')->unique();
            $table->string('user_name');
            $table->date('invoice_date');
            $table->date('due_date');
            $table->string('source')->nullable();
            $table->string('reference')->nullable();
            
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('ht_amount', 15, 2)->default(0);
            $table->decimal('tva_amount', 15, 2)->default(0);
            $table->decimal('ca_amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual_invoices');
    }
};
