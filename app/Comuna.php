<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comuna extends Model {
	protected $table = 'comunas';
	protected $primaryKey = 'comuna_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'comuna_id','comuna_nombre', 'provincia_id',
    ];
}
