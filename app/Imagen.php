<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model {
    protected $table = 'imagen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','ruta', 'es_principal','id_producto'
    ];
}
