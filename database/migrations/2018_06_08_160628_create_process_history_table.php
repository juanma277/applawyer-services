<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessHistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('historial_proceso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proceso_id')->unsigned();                        
            $table->foreign('proceso_id')->references('id')->on('proceso');
            $table->string('actuacion');            
            $table->string('anotacion');
            $table->date('fecha');                                                                                                            
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
        Schema::drop('historial_proceso');
    }
}
