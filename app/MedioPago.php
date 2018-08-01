<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MedioPago extends Model
{
    protected $table = "medio_pago";
    protected $primaryKey = 'id_medio_pago';
    public $timestamps = "false";//Decir que no se utilizaran los campos update y create en la BD

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_medio_pago', 'medio_pago'
    ];
}
