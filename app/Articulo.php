<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    /**
         * Con hacemos referencia a todos los campos de la tabla articulos
         * Recordemos que en la tabla articulos el "idcategoria" esta relacionada con la tabla categoria
         * Ya que un articulo pertenece a una categoria y una categoria puede tener varios articulos 
         */
    protected $fillable =[
        'idcategoria','codigo','nombre','precio_venta','stock','descripcion','condicion'
    ];
    /**
     * Con esta funcion hacemos relacion con el modelo "Categoria" ya que un articulo puede tener una categoria
     */
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }
}
