<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;

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
            $table->string('password');
            $table->text('avatar');
            $table->integer('role')->default(0); // 1: super admin
            $table->integer('allowed')->default(0); // 1: allowed
            $table->tinyInteger('is_new')->default(0); // 0: you registered first in this system
            $table->tinyInteger('department_code');
            $table->tinyInteger('boss')->default(0);
            $table->tinyInteger('leader')->default(0);
            $table->rememberToken();
            $table->timestamps();
        });
        User::create(['name' => 'admin','email' => 'admin@gmail.com','password' => Hash::make('123456'),'email_verified_at'=>'2022-01-02 17:04:58','avatar' => 'avatar-1.jpg','created_at' => now(), 'role' => 1, 'allowed' => 1]);
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
