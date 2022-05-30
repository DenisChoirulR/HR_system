<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->text('message');
            $table->boolean('read')->default(0);
            $table->string('target_link');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return voidr
     */
    public function down()
    {
        Schema::dropIfExists('notifications');
    }
}
