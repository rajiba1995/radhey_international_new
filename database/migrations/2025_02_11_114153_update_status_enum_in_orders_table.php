<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up()
    {
        DB::statement("ALTER TABLE orders MODIFY COLUMN status ENUM(
            'Pending', 
            'Confirmed', 
            'In Production', 
            'Ready for Delivery', 
            'Shipped', 
            'Delivered', 
            'Cancelled', 
            'Returned'
        ) NOT NULL DEFAULT 'Pending'");
    }

    public function down()
    {
        // Rollback: Change status back to a string if needed
        DB::statement("ALTER TABLE orders MODIFY COLUMN status VARCHAR(255) NOT NULL DEFAULT 'Pending'");
    }
};

