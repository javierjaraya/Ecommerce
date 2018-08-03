<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCarroCompra extends Model
{
    protected $table = "detalle_carro_compra";
    protected $primaryKey = 'id_detalle_carro';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_detalle_carro', 'id_producto', 'cantidad','precio','id_carro_compra'
    ];

    // Relación uno a uno
    public function producto() {
        return $this->hasOne('App\Producto', 'id','id_producto');
    }


    public function scopeIdCarroCompra($query, $id_carro_compra){
        if($id_carro_compra)
            return $query->where('id_carro_compra','=',$id_carro_compra);
    }

    public function scopeIdProductoAndCarro($query, $id_producto,$id_carro_compra){
        if($id_producto && $id_carro_compra)
            return $query->where('id_producto','=',$id_producto)->where('id_carro_compra','=',$id_carro_compra);
    }
}
