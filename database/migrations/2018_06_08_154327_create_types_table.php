<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipo_proceso', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre')->unique();
            $table->string('abreviatura');
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
        Schema::drop('tipo_proceso');
    }
}
