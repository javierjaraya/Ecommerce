<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoDespacho extends Model
{
    protected $table = "tipo_despacho";
    protected $primaryKey = 'id_tipo_despacho';
    public $timestamps = "false";//Decir que no se utilizaran los campos update y create en la BD

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_tipo_despacho', 'tipo_despacho'
    ];
}
