<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model {
    protected $table = 'categoria';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'nombre'
    ];

    public function subcategorias() {
	   return $this->hasMany('App\SubCategoria','id_categoria');//(Tabla relacionada , columna señalada)
	}
}
