<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Persona;

class UserController extends Controller
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
         * En estas variables vamos almacenar en los parametros "buscar" y "criterio" a traves de AJAX mediante el metodo 
         * GET
         */
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        /**
         * Establecemos un campo condicional donde si el campo buscar esta vacio listaremos todos los registros
         * de la tabla persona por el "id" de manera descendente"
         * Sino listaremos el registro de la tabla personas donde la condicion sea que la variable "buscar" pueda
         * estar al inicio o al final del campo de donde esta el campo "criterio"
         */
        
        if ($buscar==''){
            /**
             * Usaremos la propiedad join para unir nuestra tabla users con la tabla personas y tambien con la tabla
             * roles y el select para seleccionar los campos con los que vamos a trabajar
             */
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id',
            'personas.nombre',
            'personas.tipo_documento',
            'personas.num_documento',
            'personas.direccion',
            'personas.telefono',
            'personas.email',
            'users.usuario',
            'users.password',
            'users.condicion',
            'users.idrol',
            /**
             * Como vamos a necesitar el nombre de la tabla roles pero ya tenemos una variable con el mismo nombre
             * pero en otra tabla (personas.nombre) vamos a colocarle un alias para asi evitar la ambigüedad
             */
            'roles.nombre as rol')
            ->orderBy('personas.id', 'desc')->paginate(10);
        }
        else{
            /**
             * Para este caso uniremos las tablas personas y roles porque recordemos que para la creacion de un usuario
             * vamos a necesitar los datos de la persona y vamos a indicar que rol va tomar esa persona en el sistema
             */
            $personas = User::join('personas','users.id','=','personas.id')
                            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id',
            'personas.nombre',
            'personas.tipo_documento',
            'personas.num_documento',
            'personas.direccion',
            'personas.telefono',
            'personas.email',
            'users.usuario',
            'users.password',
            'users.condicion',
            'users.idrol',
            /**
             * Como vamos a necesitar el nombre de la tabla roles pero ya tenemos una variable con el mismo nombre
             * pero en otra tabla (personas.nombre) vamos a colocarle un alias para asi evitar la ambigüedad
             */
            'roles.nombre as rol')
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('id', 'desc')->paginate(10);
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

    public function store(Request $request)
    {
        /**
         * Determinamos si la peticion que se haya hecho es diferente a una peticion ajax
         * sino se va redigirir a nuestro contenido principal, de esta manera solo se
         * puede acceder a nuestras funciones por la peticion ajax
         */
        if (!$request->ajax()) return redirect('/');

        /**
         * Este codigo lo que intenta hacer es que cuando estemos registrando un usuario vamos estar
         * registrando tanto en la tabla personas como en la tabla user
         */
        try{
            DB::beginTransaction();

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

            $user = new User();
        /**
         * Despues de haber registrado una persona, con ese mismo id vamos guardar el id de nuestra tabla users
         */
            $user->id = $persona->id;
            $user->idrol = $request->idrol;
            $user->usuario = $request->usuario;
            /**
             * Metodo para encriptar contraseñas
             */
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';            
            $user->save();

            /**
             * Para guardar los cambios en la base de datos
             */
            DB::commit();
        } catch (Exception $e){
            /**
             * Si ocurre un error con el metodo "rollBack" deshacemos toda la transaccion
             */
            DB::rollBack();
        }
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();

            /**
             * Primero buscamos al usuario a modificar
             */
            $user = User::findOrFail($request->id);
            /**
             * Despues de haber encontrado al usuario con el mismo id vamos buscar a la persona
             * ya que el id del usuario es el mismo id de nuestra tabla persona
             */
            $persona = Persona::findOrFail($user->id);
            /**
             * Desde el objeto "persona" le estamos asignando por ejemplo a la propiedad "nombre" el valor que estamos
             * recibiendo del objeto "request" a la propiedad "nombre" que este recibe desde un formulario
             */
            $persona->nombre = $request->nombre;
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->direccion = $request->direccion;
            $persona->telefono = $request->telefono;
            $persona->email = $request->email;
            $persona->save();

            
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();

            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
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
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }

    /**
     * Actualizamos la informacion de la propiedad "condicion" a 1
     */
    public function activar(Request $request)
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
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    }
}
