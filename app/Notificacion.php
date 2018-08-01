<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notificacion extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'notificaciones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['user_id', 'titulo', 'mensaje', 'tipo', 'estado'];
}
