<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProcessHistory extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'historial_proceso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['proceso_id', 'descripcion', 'fecha'];
}
