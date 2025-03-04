<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
    public function up()
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->boolean('is_wa_same')->default(false); // Is WhatsApp number same as mobile
            $table->string('whatsapp_no')->nullable();
            $table->text('billing_address')->nullable();
            $table->string('billing_landmark')->nullable();
            $table->string('billing_state')->nullable();
            $table->string('billing_city')->nullable();
            $table->string('billing_pin')->nullable();
            $table->string('billing_country')->nullable();
            $table->text('shipping_address')->nullable();
            $table->string('shipping_landmark')->nullable();
            $table->string('shipping_state')->nullable();
            $table->string('shipping_city')->nullable();
            $table->string('shipping_pin')->nullable();
            $table->string('shipping_country')->nullable();
            $table->boolean('is_billing_shipping_same')->default(false);
            $table->string('gst_number')->nullable();
            $table->string('gst_file')->nullable(); // Path to the uploaded GST file
            $table->decimal('credit_limit', 10, 2)->nullable();
            $table->integer('credit_days')->nullable();
            $table->tinyInteger('status')->default(1); // 1 = Active, 0 = Inactive
            $table->softDeletes(); // Soft deletes column
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
}
