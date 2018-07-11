<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Region extends Model {
	protected $table = 'regiones';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'region_id','region_nombre', 'region_ordinal',
    ];
}
