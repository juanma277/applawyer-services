<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Court extends Model
{
     /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'juzgado';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nombre', 'ciudad_id', 'estado'];
}
