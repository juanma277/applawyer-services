<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlarmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alarmas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('proceso_id')->unsigned();                        
            $table->foreign('proceso_id')->references('id')->on('proceso');
            $table->string('descripcion');            
            $table->date('fecha');
            $table->time('hora');                                                                                                            
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
        Schema::drop('alarmas');
    }
}
