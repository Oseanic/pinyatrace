<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHealthDeclarationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('health_declarations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('est_id');
            $table->foreign('est_id')->references('id')->on('establishments');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->float('temp');
            $table->string('q1');
            $table->string('q2');
            $table->string('fever');
            $table->string('cough');
            $table->string('runny_nose');
            $table->string('sore_throat');
            $table->string('shortness_of_breath');
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
        Schema::dropIfExists('health_declarations');
    }
}
