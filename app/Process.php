<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'proceso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['tipo_proceso_id', 'user_id', 'juzgado_id', 'demandante', 'demandado', 'radicado', 'fecha', 'estado'];
}
