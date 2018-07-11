<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    protected $table = 'usuario';
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','email', 'password','id_perfil'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relación uno a uno
    public function perfil() {
        return $this->hasOne('App\Perfil', 'idPerfil'); // Le indicamos que se va relacionar con la tabla perfil y su atributo idPerfil
    }
}
