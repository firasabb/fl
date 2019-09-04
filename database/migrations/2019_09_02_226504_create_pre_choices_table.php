<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreChoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_choices', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('choice');
            $table->boolean('right')->default(0);
            $table->unsignedBigInteger('pre_question_id')->nullable();
            $table->timestamps();

            $table->foreign('pre_question_id')
                    ->references('id')->on('pre_questions')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pre_choices');
    }
}
