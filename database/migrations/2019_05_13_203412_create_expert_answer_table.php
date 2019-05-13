<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExpertAnswerTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('expert_answer', function (Blueprint $table) {
            //
            $table->bigIncrements('id');
            $table->bigInteger('expert_id')->unsigned();
            $table->bigInteger('answer_id')->unsigned();
            $table->timestamps();

            $table->foreign('expert_id')->references('id')->on('experts')->onDelete('cascade');
            $table->foreign('answer_id')->references('id')->on('answers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('expert_answer', function (Blueprint $table) {
            //
        });
    }
}
