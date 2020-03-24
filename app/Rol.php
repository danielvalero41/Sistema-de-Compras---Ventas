<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    /**
     * En laravel por defecto relaciona la tabla de la base de datos con el modelo sin embargo 
     * esto seria posible para este caso de que la tabla de la base de datos fuera "rols"
     * no "roles" por lo que hay que indicar al modelo la tabla con la cual se va relacionar
     */
    protected $table = 'roles';
    protected $fillable = ['nombre','descripcion','condicion'];
    /**
     * Recordemos que en nuestra tabla proovedores no tiene el campo "timestamps"
     */
    public $timestamps = false;

    /**
     * Con esta funcion hacemos referencia al modelo User en el cual varios usuarios
     * puede tener un rol
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

}
