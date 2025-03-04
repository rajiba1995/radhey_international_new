<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone')->nullable();
            $table->string('location')->nullable();
            $table->text('about')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->softDeletes(); 
            $table->timestamps();
        });

        // Insert a default user with a hashed password
        DB::table('users')->insert([
            'name' => 'Master Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('secret'), // Replace with your desired default password
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
