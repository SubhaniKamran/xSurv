<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
          $table->id();
          $table->string('message')->nullable();
          $table->unsignedInteger('sender_id');
          $table->unsignedInteger('reciever_id');
          $table->string('status')->default('unread')->comment('unread/read');
          $table->timestamps();
          $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
