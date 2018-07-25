<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Imagen extends Model {
    protected $table = 'imagen';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','ruta', 'es_principal','id_producto'
    ];

    public function scopeIdProducto($query, $id_producto){
        if($id_producto)
            return $query->where('id_producto','=',$id_producto);
    }

    public function scopePrincipal($query,$id_producto){    
    	if($id_producto)    
            return $query->where('es_principal','=','1')->where('id_producto','=',$id_producto);
    }
}
