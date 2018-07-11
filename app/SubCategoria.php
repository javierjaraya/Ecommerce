<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategoria extends Model {
    protected $table = 'subcategoria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre', 'id_categoria'
    ];

    
}
