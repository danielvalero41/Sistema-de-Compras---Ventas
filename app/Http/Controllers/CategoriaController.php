<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//use Illuminate\Support\Facades\DB; //Importamos el Facedes para usar la clase DB usando Query Builder
use App\Categoria;//Importamos el modelo a usar

class CategoriaController extends Controller
{
    /**
     * Listamos todos los registros de la tabla categoria
     */
    
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
            $categorias = Categoria::orderBy('id', 'desc')->paginate(10);
        }
        else{
            $categorias = Categoria::where($criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
        }
        
        /**
         * Ahora lo que haremos es colocar las instancias del paginador como la data, estos metodos lo podemos encontrar
         * en la documentacion de Laravel->database->pagination->Paginator Instance Methods
         */
        return [
            'pagination' => [
                'total'        => $categorias->total(),
                'current_page' => $categorias->currentPage(),
                'per_page'     => $categorias->perPage(),
                'last_page'    => $categorias->lastPage(),
                'from'         => $categorias->firstItem(),
                'to'           => $categorias->lastItem(),
            ],
            'categorias' => $categorias
        ];
    }

     /**
     * En esta funcion lo que hace es seleccionar el id y el nombre de todas la categorias mientras su condicion sea 1
     * y con el metodo get() obtiene ese objeto que es retornado por medio la variable "categorias"
     */

    public function selectCategoria(Request $request){
        if (!$request->ajax()) return redirect('/');
        $categorias = Categoria::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['categorias' => $categorias];
    }

    /**
     * Guardamos los datos en la tabla "categorias"
     */
    public function store(Request $request)
    {
        /**
         * Determinamos si la peticion que se haya hecho es diferente a una peticion ajax
         * sino se va redigirir a nuestro contenido principal, de esta manera solo se
         * puede acceder a nuestras funciones por la peticion ajax
         */
        if (!$request->ajax()) return redirect('/');
        /**
         * Creamos o instanciamos un objeto llamado "categoria" de la clase "Categoria"
         * para acceder a las propiedades de la clase que son en este caso "nombre"
         * "descripcion","condicion"
         */
        $categoria = new Categoria();
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        /**
         * Con esto insertamos este objeto en nuestra tabla "categorias" de nuestra base de datos
         */
        $categoria->save();
    }
  

    /**
     * Realizamos una comprobacion antes de guardar los datos con el metodo "findOrFail" para encontrar el registro y
     * actualizarlo en caso de encontrarlo
     */
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
        $categoria = Categoria::findOrFail($request->id);
        $categoria->nombre = $request->nombre;
        $categoria->descripcion = $request->descripcion;
        $categoria->condicion = '1';
        $categoria->save();
    }

    /**
     * Actualizamos la informacion de la propiedad "condicion" a 0
     */
    public function desactivar(Request $request)
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
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '0';
        $categoria->save();
    }

    /**
     * Actualizamos la informacion de la propiedad "condicion" a 1
     */
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        /**
         * El parametro "request->id" lo obtenemos de la vista 
         * correspondiente a traves del formulario
         */
        $categoria = Categoria::findOrFail($request->id);
        $categoria->condicion = '1';
        $categoria->save();
    }

    
}
