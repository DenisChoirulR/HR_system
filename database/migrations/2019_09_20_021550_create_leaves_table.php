<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaves', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->unsignedBigInteger('leave_type_id');
            $table->foreign('leave_type_id')->references('id')->on('leave_types')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->string('status')->default("requested");
            $table->dateTime('cancelled_at')->nullable();
            $table->unsignedBigInteger('substitute_user_id');
            $table->foreign('substitute_user_id')->references('id')->on('users')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->text('leave_note');
            $table->text('work_note');
            $table->date('accepted_at')->nullable();                 
            $table->unsignedBigInteger('accepted_by')->nullable();
            $table->foreign('accepted_by')->references('id')->on('users')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->dateTime('rejected_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->foreign('rejected_by')->references('id')->on('users')
                ->onUpdate('restrict')->onDelete('restrict');
            $table->dateTime('approved_at')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('users')
                ->onUpdate('restrict')->onDelete('restrict');
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
        Schema::dropIfExists('leaves');
    }
}
