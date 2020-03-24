<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * La ventaja de usar esta funcion es que no necesitamos
     * especificar el nombre de la funcion cuando creamos
     * la ruta para este controlador
     */
    public function __invoke(Request $request)
    {   
        /**
         * Creamos una variable con el nombre anio y usamos
         * el metodo "date" nos permite obtener el año actual
         */
        $anio=date('Y');
        $ingresos=DB::table('ingresos as i')
        /**
         * De nuestra tabla ingresos queremos obtener a traves
         * del metodo raw el mes que nos permite utilizar
         * la funcion MONTH para capturar solo el mes de
         * nuestra propiedad fecha_hora, igual pasa para el
         * año usamos la funcion YEAR y para obtener toda la
         * suma de una propiedad de esa tabla usamos la funcion
         * SUM
         */
        ->select(
            DB::raw('MONTH(i.created_at) as mes'),
            DB::raw('YEAR(i.created_at) as anio'),
            DB::raw('SUM(i.total) as total')
        )
        /**
         * Lo que hacemos ahora el filtrar por el año
         * usando la variable que hemos creado arriba
         * que tiene el valor del año actual y nos mostrara
         * los que meses que han transcurrido en ese año       
         */
        ->whereYear('i.created_at',$anio)
        /**
         * Agrupamos por mes y año, para poder hacer el calculo
         * SUM
         */
        ->groupBy(DB::raw('MONTH(i.created_at)'),
                  DB::raw('YEAR(i.created_at)'))
        ->get();

        $ventas=DB::table('ventas as v')
        /**
         * De nuestra tabla ventas queremos obtener a traves
         * del metodo raw el mes que nos permite utilizar
         * la funcion MONTH para capturar solo el mes de
         * nuestra propiedad fecha_hora, igual pasa para el
         * año usamos la funcion YEAR y para obtener toda la
         * suma de una propiedad de esa tabla usamos la funcion
         * SUM
         */
        ->select(
            DB::raw('MONTH(v.created_at) as mes'),
            DB::raw('YEAR(v.created_at) as anio'),
            DB::raw('SUM(v.total) as total')
        )
        /**
         * Lo que hacemos ahora el filtrar por el año
         * usando la variable que hemos creado arriba
         * que tiene el valor del año actual y nos mostrara
         * los que meses que han transcurrido en ese año       
         */
        ->whereYear('v.created_at',$anio)
        /**
         * Agrupamos por mes y año, para poder hacer el calculo
         * SUM
         */
        ->groupBy(DB::raw('MONTH(v.created_at)'),
                  DB::raw('YEAR(v.created_at)'))
        ->get();

        return ['ingresos' =>$ingresos,'ventas' =>$ventas,'anio' =>$anio];
    }
}
