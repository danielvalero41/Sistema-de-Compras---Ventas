<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable = ['nombre','tipo_documento','num_documento','direccion','telefono','email'];

    /**
     * Con esto hacemos relacion con el modelo Proovedor
     */
    public function provedor()
    {
        return $this->hasOne('App\Proveedor');
    }

    /**
     * Con esto hacemos relacion con el modelo User
     */
    public function user()
    {
        return $this->hasOne('App\User');
    }


}
