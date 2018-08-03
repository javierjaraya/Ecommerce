<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarroCompra extends Model {
    protected $table = "carro_compra";
    protected $primaryKey = 'id_carro_compra';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_carro_compra', 'id_cliente'
    ];

    public function detalle() {
	   return $this->hasMany('App\DetalleCarroCompra','id_carro_compra');//(Tabla relacionada , columna señalada)
	}

    public function scopeIdCliente($query, $id_cliente){
        if($id_cliente)
            return $query->where('id_cliente','=',$id_cliente);
    }
}
