<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionHistoriesTable extends Migration
{
    public function up()
    {
        Schema::create('transaction_histories', function (Blueprint $table) {
          $table->id();
          $table->unsignedInteger('company_packages_id');
          $table->unsignedInteger('user_id')->default(1);
          $table->string('transaction_id');
          $table->unsignedInteger('package_id');
          $table->string('package_name');
          $table->double('package_price');
          $table->integer('package_duration');
          $table->double('amount_paid');
          $table->date('end_date');
          $table->string('invoice');
          $table->timestamps();
          $table->softDeletes();

          $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('transaction_histories');
    }
}
