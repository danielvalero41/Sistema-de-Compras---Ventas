<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleIngreso extends Model
{
    /**
     * Recordemos que esto lo hacemos para relacionar 
     * correctamente la tabla "detalle_ingresos" con 
     * nuestro modelo "DetalleIngreso"
     */
    protected $table = 'detalle_ingresos';

    protected $fillable = [
        'idingreso',
        'idarticulo',
        'cantidad',
        'precio'
    ];

    public $timestamps = false;

}
