<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model {
    protected $table = 'provincias';
    protected $primary_key = 'provincia_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provincia_id','provincia_nombre', 'region_id',
    ];
 

}
