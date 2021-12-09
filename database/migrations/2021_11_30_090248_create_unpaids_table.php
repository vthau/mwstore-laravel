<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUnpaidsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('unpaids', function (Blueprint $table) {
            $table->string("order_code")->primary();
            $table->string("name");
            $table->string("email");
            $table->string("phone");
            $table->string("note")->nullable();
            $table->integer("method");
            $table->string("coupon_code");
            $table->string("feeship_id");
            $table->string("address");
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
        Schema::dropIfExists('unpaids');
    }
}
