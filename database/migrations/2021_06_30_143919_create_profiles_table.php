<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('first_name');
            $table->string('surname');
            $table->string('middle_name');
            $table->date('dob');
            $table->string('age');
            $table->string('sex');
            $table->string('street');
            $table->string('barangay');
            $table->string('city');
            $table->string('cp_number');
            $table->string('tel_number')->nullable();     
            $table->string('role');
            $table->string('id_number')->nullable();
            $table->string('course');
            $table->string('section');          
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
        Schema::dropIfExists('profiles');
    }
}
