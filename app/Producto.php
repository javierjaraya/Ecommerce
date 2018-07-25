<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model {
	protected $table = 'producto';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','nombre', 'descripcion','precio_normal','stock','marca','modelo','id_subcategoria'
    ];

    public function imagenes() {
	   return $this->hasMany('App\Imagen','id_producto');//(Tabla relacionada , columna señalada)
	}

    public function scopeId($query, $id){
        if($id)
            return $query->where('id','LIKE',"%$id%");
    }

    public function scopeNombre($query, $nombre){
        if($nombre)
            return $query->where('nombre','LIKE',"%$nombre%");
    }

    public function scopeDescripcion($query, $descripcion){
        if($descripcion)
            return $query->where('descripcion','LIKE',"%$descripcion%");
    }

    public function scopeMarca($query, $marca){
        if($marca)
            return $query->where('marca','LIKE',"%$marca%");
    }

    public function scopeModelo($query, $modelo){
        if($modelo)
            return $query->where('modelo','LIKE',"%$modelo%");
    }

    public function scopeCategoria($query, $id_categoria){
        if($id_categoria)
            return $query->join('subcategoria','producto.id_subcategoria','=','subcategoria.id')
                    ->join('categoria','subcategoria.id','=','categoria.id')
                    ->where('categoria.id','=', $id_categoria);
    }
}
