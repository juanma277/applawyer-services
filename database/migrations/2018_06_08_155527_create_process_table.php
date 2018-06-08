<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProcessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proceso', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('tipo_proceso_id')->unsigned();            
            $table->foreign('tipo_proceso_id')->references('id')->on('tipo_proceso');
            $table->integer('user_id')->unsigned();                        
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('juzgado_id')->unsigned();                                    
            $table->foreign('juzgado_id')->references('id')->on('juzgado');                                    
            $table->string('demandante');
            $table->string('demandado');
            $table->string('radicado');
            $table->date('fecha');  
            $table->string('estado')->default('ACTIVO');                                                         
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
        Schema::drop('proceso');
    }
}
