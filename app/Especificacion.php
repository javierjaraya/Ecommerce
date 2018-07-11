<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especificacion extends Model {
    protected $table = 'especificacion';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nombre', 'descripcion', 'id_producto'
    ];
}
