<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePreQuestionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pre_questions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title');
            $table->unsignedBigInteger('user_id');
            $table->text('description')->nullable();
            $table->timestamps();

            $table->foreign('user_id')
                    ->references('id')->on('users')
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
        Schema::dropIfExists('pre_questions');
    }
}
