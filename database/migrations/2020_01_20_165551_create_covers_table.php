<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCoversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('covers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('url');
            $table->unsignedBigInteger('art_id')->nullable();
            $table->unsignedBigInteger('preart_id')->nullable();
            $table->timestamps();
            
            $table->foreign('art_id')
                    ->references('id')->on('arts')
                    ->onDelete('cascade');

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
        Schema::dropIfExists('covers');
    }
}
