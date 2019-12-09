<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriablesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categoriables', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id')->unsigned();;
            $table->integer('categoriable_id')->unsigned();
            $table->string('categoriable_type');
            $table->timestamps();
            $table->index('category_id');
            $table->index('categoriable_id');
            $table->index('categoriable_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('categoriables');
    }
}
