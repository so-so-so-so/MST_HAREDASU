<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservesTable extends Migration
{
  /**
   * Run the migrations.
   *
   * @return void
   */
  public function up()
  {
    Schema::create('reserves', function (Blueprint $table) {
      $table->increments("id");
      $table->unsignedInteger('user_id');
      $table->double('latitude', 8, 6);
      $table->double('longitude', 9, 6);
      $table->string('address');
      $table->date('date');
      $table->time('start_time');
      $table->time('end_time');
      $table->integer('area');
      $table->integer('drone');
      $table->integer('cost');
      $table->integer('status');
      $table->timestamp('created_at');
      $table->softDeletes();
      // 以下外部キー
      $table->foreign('user_id')->references('id')->on('users');
    });
  }

  /**
   * Reverse the migrations.
   *
   * @return void
   */
  public function down()
  {
    Schema::dropIfExists('reserves');
  }
}
