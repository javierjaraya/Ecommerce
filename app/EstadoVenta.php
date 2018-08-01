<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EstadoVenta extends Model
{
    protected $table = "estado_venta";
    protected $primaryKey = 'id_estado_venta';
    public $timestamps = "false";//Decir que no se utilizaran los campos update y create en la BD

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_estado_venta', 'estado_venta'
    ];
}
