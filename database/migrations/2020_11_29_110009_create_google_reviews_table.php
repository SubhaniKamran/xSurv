<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGoogleReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('google_reviews', function (Blueprint $table) {
          $table->id();
          $table->unsignedInteger('user_id')->default(1);
          $table->string('google_url')->nullable();
          $table->timestamps();
          $table->softDeletes();

          $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('google_reviews');
    }
}
