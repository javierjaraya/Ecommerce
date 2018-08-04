<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $table = "venta";
    protected $primaryKey = 'id_venta';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_venta', 'id_cliente', 'venta_revisada','id_tipo_despacho','comentario_despacho','id_estado_venta','detalle_anulacion','anulacion_revisada','rut_retira','nombre_retira','apellido_retira','telefono_retira','direccion_retira','id_medio_pago','created_at'
    ];

    public function medioPago() {
        return $this->hasOne('App\MedioPago', 'id_medio_pago','id_medio_pago');
    }

    public function estadoVenta() {
        return $this->hasOne('App\EstadoVenta', 'id_estado_venta','id_estado_venta');
    }

    public function tipoDespacho() {
        return $this->hasOne('App\TipoDespacho', 'id_tipo_despacho','id_tipo_despacho');
    }

    public function detalle() {
       return $this->hasMany('App\DetalleVenta','id_venta');//(Tabla relacionada , columna señalada)
    }

    public function scopeIdCliente($query, $id_cliente){
        if($id_cliente)
            return $query->where('id_cliente','=',$id_cliente);
    }
}
