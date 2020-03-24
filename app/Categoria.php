<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    //protected $table = 'categorias';
    //protected $primaryKey = 'id';
    /**
     * En laravel, esta clase asume la relacion que hay con la tabla que esta en la base de datos
     * Para nuestro ejemplo la clase es "Categoria" se relaciona con tabla "categorias"
     */

     /**
      * Con la propiedad "fillable" asignamos a las columnas
      * "nombre,descripcion,condicion" valores en masas para la
      * tabla "categorias"
      */
    protected $fillable = ['nombre','descripcion','condicion'];

    /**
     * Esta funcion lo que nos indica que una categoria puede tener varios articulos
     */
    public function articulos()
    {
        return $this->hasMany('App\Articulo');
    }
}
