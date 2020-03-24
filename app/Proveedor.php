<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    /**
     * En laravel por defecto relaciona la tabla de la base de datos con el modelo sin embargo 
     * esto seria posible para este caso de que la tabla de la base de datos fuera "proovedors"
     * no "proovedores" por lo que hay que indicar al modelo la tabla con la cual se va relacionar
     */
    protected $table = 'proveedores';
    protected $fillable = [
        'id', 'contacto', 'telefono_contacto'
    ];

    /**
     * Recordemos que en nuestra tabla proovedores no tiene el campo "timestamps"
     */
    public $timestamps = false;

    /**
     * Con esta funcion hacemos referencia al modelo Persona en el cual una persona
     * puede ser un proovedor
     */
    public function persona()
    {
        return $this->belongsTo('App\Persona');
    }


}
