<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Persona;
use App\Cliente;

class ClienteController extends Controller
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
            $personas = Persona::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $personas = Persona::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        
        /**
         * Ahora lo que haremos es colocar las instancias del paginador como la data, estos metodos lo podemos encontrar
         * en la documentacion de Laravel->database->pagination->Paginator Instance Methods
         */
        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    /**
     * En esta funcion lo que hacemos es recibir mediante
     * ajax una variable que la asignamos a la variable
     * filtro con cual vamos hacer la busqueda del registro
     * en nuestra tabla personas obteniendo el id,nombre y
     * num_documento si el nombre o el num_documento coincide
     * con lo que esta dentro de la variable filtro.
     * Despues obtener ese registro retornamos todo
     * mediante el arreglo clientes
     */
    public function selectCliente(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $clientes = Persona::where('nombre','like','%'. $filtro . '%')
        ->orWhere('num_documento','like','%'. $filtro .'%')
        ->select(
            'id',
            'nombre',
            'num_documento',
            'direccion')
        ->orderBy('nombre','ASC')->get();

        return ['clientes' => $clientes];
        
    }

    public function store(Request $request)
    {
        /**
         * Determinamos si la peticion que se haya hecho es diferente a una peticion ajax
         * sino se va redigirir a nuestro contenido principal, de esta manera solo se
         * puede acceder a nuestras funciones por la peticion ajax
         */
        if (!$request->ajax()) return redirect('/');
        /**
         * Creamos o instanciamos un objeto llamado "persona" de la clase "persona"
         * para acceder a las propiedades de la clase que son en este caso "nombre"
         * "tipo_documento",etc
         */
        $persona = new Persona();
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        /**
         * Con esto insertamos este objeto en nuestra tabla "personas" de nuestra base de datos
         */
        $persona->save();
    }

    public function update(Request $request)
    {
        /**
         * Determinamos si la peticion que se haya hecho es diferente a una peticion ajax
         * sino se va redigirir a nuestro contenido principal, de esta manera solo se
         * puede acceder a nuestras funciones por la peticion ajax
         */
        if (!$request->ajax()) return redirect('/');
        /**
         * El parametro "request->id" lo obtenemos de la vista 
         * correspondiente a traves del formulario
         */
        $persona = Persona::findOrFail($request->id);
        $persona->nombre = $request->nombre;
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->direccion = $request->direccion;
        $persona->telefono = $request->telefono;
        $persona->email = $request->email;
        /**
         * Con esto insertamos este objeto en nuestra tabla "personas" de nuestra base de datos
         */
        $persona->save();
    }
}
