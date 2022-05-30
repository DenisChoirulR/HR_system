<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('gender');
            $table->date('birth_date');
            $table->char('phone',30);                 
            $table->string('religion');
            $table->string('job_title');
            $table->string('employee_type');
            $table->string('placement_location');
            $table->date('start_date');
            $table->string('address');
            $table->string('marital_status');
            $table->char('identity_card_no',30);
            $table->string('access_type')->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->boolean('active')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
