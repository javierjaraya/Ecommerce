<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model {
    protected $table = 'provincias';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provincia_id','provincia_nombre', 'region_id',
    ];
 

}
