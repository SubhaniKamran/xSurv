<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyPackagesTable extends Migration
{
    public function up()
    {
        Schema::create('company_packages', function (Blueprint $table) {
          $table->id();
          $table->unsignedInteger('user_id')->default(1);
          $table->unsignedInteger('package_id');
          $table->string('package_name');
          $table->double('package_price');
          $table->integer('package_duration');
          $table->date('start_date');
          $table->date('end_date');
          $table->string('invoice_status');
          $table->boolean('active_status');
          $table->timestamps();
          $table->softDeletes();

          $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('company_packages');
    }
}
