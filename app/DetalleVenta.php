<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleVenta extends Model
{
    protected $table = "detalle_venta";
    protected $primaryKey = 'id_detalle_venta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_detalle_venta', 'id_producto','cantidad','precio','id_venta'
    ];


    public function producto() {
        return $this->hasOne('App\Producto', 'id','id_producto');
    }

    public function scopeIdVenta($query, $id_venta){
        if($id_venta)
            return $query->where('id_venta','=',$id_venta);
    }
}
