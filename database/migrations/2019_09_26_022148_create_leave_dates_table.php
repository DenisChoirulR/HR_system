<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaveDatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leave_dates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('leave_id');
            $table->foreign('leave_id')->references('id')->on('leaves')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->date('requested_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('leave_dates');
    }
}
