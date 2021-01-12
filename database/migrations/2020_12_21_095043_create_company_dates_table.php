<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyDatesTable extends Migration
{
    public function up()
    {
        Schema::create('company_dates', function (Blueprint $table) {
          $table->id();
          $table->unsignedInteger('user_id')->default(1);
          $table->integer('date1')->nullable();
          $table->integer('date2')->nullable();
          $table->integer('date3')->nullable();
          $table->integer('date4')->nullable();
          $table->timestamps();
          $table->softDeletes();
          $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_dates');
    }
}
