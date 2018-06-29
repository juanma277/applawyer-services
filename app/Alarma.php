<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Alarma extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'alarmas';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['proceso_id', 'descripcion', 'fecha', 'hora'];
}
