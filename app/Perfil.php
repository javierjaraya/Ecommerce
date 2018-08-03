<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Perfil extends Model {
    protected $table = 'perfil';
    protected $primaryKey = 'idPefil';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'idPefil', 'nombrePerfil'
    ];
}
