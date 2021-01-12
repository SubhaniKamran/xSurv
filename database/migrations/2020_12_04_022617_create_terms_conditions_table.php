<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTermsConditionsTable extends Migration
{
    public function up()
    {
        Schema::create('terms_conditions', function (Blueprint $table) {
          $table->id();
          $table->unsignedInteger('user_id')->default(1);
          $table->text('termscondition');
          $table->timestamps();
          $table->softDeletes();

          $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('terms_conditions');
    }
}
