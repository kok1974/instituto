<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMateriasimpartidasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materiasimpartidas', function (Blueprint $table) {
            $table->id();
            $table->integer('docente')->unsigned()->nullable();
            $table->integer('materia')->unsigned()->nullable();
            $table->integer('grupo')->unsigned()->nullable();
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
        Schema::dropIfExists('materiasimpartidas');
    }
}
