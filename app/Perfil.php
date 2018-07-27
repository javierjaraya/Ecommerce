<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model {
    protected $table = 'perfil';
    protected $primary_key = 'idPefil';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idPefil', 'nombrePerfil'
    ];
}
