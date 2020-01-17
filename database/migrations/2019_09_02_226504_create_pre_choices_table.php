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
            $table->unsignedBigInteger('preart_id');
            $table->timestamps();

            $table->foreign('preart_id')
                    ->references('id')->on('pre_arts')
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
