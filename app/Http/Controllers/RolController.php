<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Rol;

class RolController extends Controller
{
    public function index(Request $request)
    {
        /**
         * Determinamos si la peticion que se haya hecho es diferente a una peticion ajax
         * sino se va redigirir a nuestro contenido principal, de esta manera solo se
         * puede acceder a nuestras funciones por la peticion ajax
         */
        if (!$request->ajax()) return redirect('/');

        /**
         * Declaramos dos variables "buscar" y "criterio"
         * En estas variables vamos almacenar en los parametros "buscar" y "criterio" a traves de AJAX mediante el metodo GET
         */
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        /**
         * Establecemos un campo condicional donde si el campo buscar esta vacio listaremos todos los registros
         * de la tabla categoria por el "id" de manera descendente"
         * Sino listaremos el registro de la tabla categorias donde la condicion sea que la variable "buscar" pueda
         * estar al inicio o al final del campo de donde esta el campo "criterio"
         */
        if ($buscar==''){
            $roles = Rol::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $roles = Rol::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        

        /**
         * Ahora lo que haremos es colocar las instancias del paginador como la data, estos metodos lo podemos encontrar
         * en la documentacion de Laravel->database->pagination->Paginator Instance Methods
         */
        return [
            'pagination' => [
                'total'        => $roles->total(),
                'current_page' => $roles->currentPage(),
                'per_page'     => $roles->perPage(),
                'last_page'    => $roles->lastPage(),
                'from'         => $roles->firstItem(),
                'to'           => $roles->lastItem(),
            ],
            'roles' => $roles
        ];
    }

    /**
     * Con esta funcion lo que hacemos es seleccionar todos los roles que tenga la condicion 1 o "activo"
     * obteniendo su id y su nombre, ordenados de manera ascendente y que obtenemos por el metodo get es
     * un objeto
     */
    public function selectRol(Request $request)
    {
        $roles = Rol::where('condicion', '=', '1')
        ->select('id','nombre')
        ->orderBy('nombre', 'asc')->get();

        /**
         * Y para retornar un objeto lo hacemos de esta manera
         */
        return ['roles' => $roles];
    } 
}
