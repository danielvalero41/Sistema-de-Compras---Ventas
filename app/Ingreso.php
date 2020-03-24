<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ingreso extends Model
{
    protected $fillable = [
        'idproveedor',
        'idusuario',
        'tipo_comprobante',
        'serie_comprobante',
        'num_comprobante',
        'fecha_hora',
        'impuesto',
        'total',
        'estado'
    ];
    
    /**
     * Esta funcion nos va permitir obtener el usuario
     * que ha registrado este ingreso
     */
    public function usuario()
    {
        return $this->belongsTo('App\User');
    }
    /**
     * Con esto indicamos cual es el proveedor que nos
     * ha abastecido al almacen
     */
    public function proveedor()
    {
        return $this->belongsTo('App\Proveedor');
    }
}
