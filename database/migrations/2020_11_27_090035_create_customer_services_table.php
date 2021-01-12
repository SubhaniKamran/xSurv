<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerServicesTable extends Migration
{
    public function up()
    {
        Schema::create('customer_services', function (Blueprint $table) {
          $table->id();
          $table->unsignedInteger('user_id')->default(1);
          $table->unsignedInteger('customer_id');
          $table->unsignedInteger('survey_id');
          $table->unsignedInteger('service_id');
          $table->date('email_date')->nullable();
          $table->date('service_date');
          $table->text('survey_question');
          $table->text('survey_answer')->nullable();
          $table->string('email_status')->nullable();
          $table->string('reaction_status')->nullable();
          $table->timestamps();
          $table->softDeletes();

          $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('customer_services');
    }
}
