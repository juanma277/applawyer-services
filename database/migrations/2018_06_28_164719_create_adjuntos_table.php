<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdjuntosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjuntos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proceso_id')->unsigned();                        
            $table->foreign('proceso_id')->references('id')->on('proceso');
            $table->string('descripcion');
            $table->string('archivo');            
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
        Schema::drop('adjuntos');
    }
}
