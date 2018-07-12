<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Oferta extends Model
{
    protected $table = 'oferta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'fecha_inicio', 'fecha_termino', 'precio_oferta','id_producto','stock'
    ];

    public function scopeIdProducto($query, $id_producto){
        if($id_producto)
            return $query->where('id_producto','=',"$id_producto");
    }

    // Relación uno a uno
    public function producto() {
        return $this->belongsTo(Producto::class, 'id_producto', 'id');
        //Nombre clase relacionada , id indice, id primary key clase relacionada
    }

}
