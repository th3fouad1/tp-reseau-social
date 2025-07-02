<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIaQuestionsTable extends Migration
{
    public function up()
    {
        Schema::create('ia_questions', function (Blueprint $table) {
            $table->id();
            $table->text('prompt');
            $table->text('answer')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::dropIfExists('ia_questions');
    }
}