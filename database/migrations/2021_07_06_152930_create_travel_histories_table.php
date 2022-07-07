<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTravelHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('travel_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('res_name');
            $table->date('date');
            $table->string('in', 0);
            $table->string('out', 0)->nullable();
            $table->string('role');
            $table->string('id_number');
            $table->string('cp_number');
            $table->string('address');
            $table->string('tel_number')->nullable();
            $table->string('emergency_contact');
            $table->string('ec_cp_number');
            $table->string('email');
            $table->string('reason_visit')->nullable();
            $table->unsignedBigInteger('establishment_id');
            $table->foreign('establishment_id')->references('id')->on('establishments');
            $table->string('establishment_name');
            $table->string('establishment_address');
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
        Schema::dropIfExists('travel_histories');
    }
}
