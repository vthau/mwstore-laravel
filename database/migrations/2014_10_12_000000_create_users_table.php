<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('password')->nullable();
            $table->string('forgot_password')->nullable();
            $table->string('address')->nullable();
            $table->string('image')->default('default.png');
            $table->string('status')->nullable();
            $table->string('zalo_id')->nullable();
            $table->string('google_id')->nullable();
            $table->string('facebook_id')->nullable();
            $table->integer('block')->default(0);
            $table->string('expired')->nullable(0);
            $table->timestamp('time')->useCurrent();
            $table->timestamps();
        });
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
