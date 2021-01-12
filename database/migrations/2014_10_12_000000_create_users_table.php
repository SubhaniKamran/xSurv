<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('role_id')->default(1);
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('status')->default(1);
            $table->boolean('terms_condition')->nullable();
            $table->string('stripe_customer_id')->nullable();
            $table->string('stripe_card_id')->nullable();
            $table->string('card_number')->nullable();
            $table->string('card_exp_month')->nullable();
            $table->string('card_cvc')->nullable();
            $table->string('card_exp_year')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
