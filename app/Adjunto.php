<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Adjunto extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'adjuntos';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['proceso_id', 'descripcion', 'archivo'];
}
