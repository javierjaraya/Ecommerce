<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model {
    protected $table = 'cliente';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id', 'rut','nombres_rason_social', 'apellidos','giro','direccion','id_comuna','contacto','	id_usuario'
    ];

    // Relación uno a uno
    public function usuario() {
        return $this->hasOne('App\Usuario', 'id'); // Le indicamos que se va relacionar con la tabla usuario y su atributo id
    }
}
