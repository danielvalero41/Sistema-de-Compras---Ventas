<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Proveedor;
use App\Persona;


class ProveedorController extends Controller
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
         * de la tabla proveedor por el "id" de manera descendente"
         * Sino listaremos el registro de la tabla proveedors donde la condicion sea que la variable "buscar" pueda
         * estar al inicio o al final del campo de donde esta el campo "criterio"
         */
        if ($buscar==''){            
            /**
             * Usaremos la propiedad join para unir nuestra tabla con la tabla personas y el select para seleccionar 
             * los campos con los que vamos a trabajar
             */
            $personas = Proveedor::join('personas','proveedores.id','=','personas.id')
            ->select('personas.id',
            'personas.nombre',
            'personas.tipo_documento',
            'personas.num_documento',
            'personas.direccion',
            'personas.telefono',
            'personas.email',
            'proveedores.contacto',
            'proveedores.telefono_contacto')
            ->orderBy('personas.id', 'desc')->paginate(10);
        }else{
            $personas = Proveedor::join('personas','proveedores.id','=','personas.id')
            ->select('personas.id',
            'personas.nombre',
            'personas.tipo_documento',
            'personas.num_documento',
            'personas.direccion',
            'personas.telefono',
            'personas.email',
            'proveedores.contacto',
            'proveedores.telefono_contacto')            
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.id', 'desc')->paginate(10);
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

    public function selectProveedor(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $proveedores = Proveedor::join('personas','proveedores.id','=','personas.id')
        ->where('personas.nombre','like','%'. $filtro . '%')
        ->orWhere('personas.num_documento','like','%'. $filtro .'%')
        ->select(
            'personas.id',
            'personas.nombre',
            'personas.num_documento',
            'personas.telefono',
            'proveedores.contacto')
        ->orderBy('personas.nombre','ASC')->get();

        return ['proveedores' => $proveedores];
        
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
         * Este codigo lo que intenta hacer es que cuando estemos registrando un proveedor vamos estar
         * registrando tanto en la tabla personas como en la tabla proveedor
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

            $proveedor = new Proveedor();
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            /**
            * De esta manera lo que hacemos es que el id de la llave foranea proveedor sea igual
            * al id de la llave primaria de persona
            */
            $proveedor->id = $persona->id;
            $proveedor->save();

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
             * Primero buscamos al proveedor a modificar
             */
            $proveedor = Proveedor::findOrFail($request->id);

            /**
             * Despues de haber encontrado al proveedor con el mismo id vamos buscar a la persona
             * ya que el id del proveedor es el mismo id de nuestra tabla persona
             */
            $persona = Persona::findOrFail($proveedor->id);

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
            /**
             * Con esto insertamos este objeto en nuestra tabla "personas" de nuestra base de datos
             */
            $persona->save();

            
            $proveedor->contacto = $request->contacto;
            $proveedor->telefono_contacto = $request->telefono_contacto;
            /**
             * De esta manera lo que hacemos es que el id de la llave foranea proveedor sea igual
             * al id de la llave primaria de persona
             */
            $proveedor->save();

            DB::commit();

        } catch (Exception $e){
            /**
            * Si ocurre un error con el metodo "rollBack" deshacemos toda la transaccion
            */
            DB::rollBack();
        }

    }
}
