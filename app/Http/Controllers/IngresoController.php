<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Ingreso;
use App\DetalleIngreso;
use App\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Notifications\NotifyAdmin;

class IngresoController extends Controller
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
             * Usaremos la propiedad join para unir nuestra tabla ingresos con la tabla personas y tambien con la tabla
             * roles y el select para seleccionar los campos con los que vamos a trabajar
             */
            /**
             * Lo que hacemos es unir la tabla personas con nuestra tabla ingresos mediante el campo idproveedor de nuestra tabla
             * ingresos con el id de nuestra tabla personas
             */
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            /**
             * Vamos a unir la tabla users mediante el campo idusuario de nuestra tabla ingresos con el id de nuestra tabla users
             */
            ->join('users','ingresos.idusuario','=','users.id')
            ->select(
            'ingresos.id',
            'ingresos.tipo_comprobante',
            'ingresos.serie_comprobante',            
            'ingresos.fecha_hora',
            'ingresos.impuesto',
            'ingresos.total',
            'ingresos.estado',                       
            'personas.nombre',
            'users.usuario')
            ->orderBy('ingresos.id', 'desc')->paginate(10);
        }
        else{
            /**
             * Para este caso uniremos las tablas personas y roles porque recordemos que para la creacion de un usuario
             * vamos a necesitar los datos de la persona y vamos a indicar que rol va tomar esa persona en el sistema
             */
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            /**
             * Vamos a unir la tabla users mediante el campo idusuario de nuestra tabla ingresos con el id de nuestra tabla users
             */
            ->join('users','ingresos.idusuario','=','users.id')
            ->select(
            'ingresos.id',
            'ingresos.tipo_comprobante',
            'ingresos.serie_comprobante',            
            'ingresos.fecha_hora',
            'ingresos.impuesto',
            'ingresos.total',
            'ingresos.estado',
            'users.password',
            'users.condicion',
            'users.idrol',
            'personas.nombre',
            'users.usuario')
            ->where('ingresos.'.$criterio, 'like', '%'. $buscar . '%')->orderBy('ingresos.id', 'desc')->paginate(10);
        }

        /**
         * Ahora lo que haremos es colocar las instancias del paginador como la data, estos metodos lo podemos encontrar
         * en la documentacion de Laravel->database->pagination->Paginator Instance Methods
         */
        
        return [
            'pagination' => [
                'total'        => $ingresos->total(),
                'current_page' => $ingresos->currentPage(),
                'per_page'     => $ingresos->perPage(),
                'last_page'    => $ingresos->lastPage(),
                'from'         => $ingresos->firstItem(),
                'to'           => $ingresos->lastItem(),
            ],
            'ingresos' => $ingresos
        ];
    }

    public function comprobante(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $comprobante = DB::table('ingresos')->select('serie_comprobante')->orderBy('ingresos.id','DESC')->first();           

        return ['ingresos' => $comprobante];
        
    }

    public function obtenerCabecera(Request $request)
    {
        
        /**
         * Determinamos si la peticion que se haya hecho es diferente a una peticion ajax
         * sino se va redigirir a nuestro contenido principal, de esta manera solo se
         * puede acceder a nuestras funciones por la peticion ajax
         */
        if (!$request->ajax()) return redirect('/');

        /**
         * Declaramos una variable llamada "id"
         * En estas variables vamos almacenar en los parametros "buscar" y "criterio" a traves de AJAX mediante el metodo 
         * GET
         */
        $id = $request->id;        
        
        /**
         * Usaremos la propiedad join para unir nuestra tabla ingresos con la tabla personas y tambien con la tabla
         * users y el select para seleccionar los campos con los que vamos a trabajar
         */
        /**
         * Lo que hacemos es unir la tabla personas con nuestra tabla ingresos mediante el campo idproveedor de nuestra tabla
         * ingresos con el id de nuestra tabla personas
         */
        $ingreso = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        /**
         * Vamos a unir la tabla users mediante el campo idusuario de nuestra tabla ingresos con el id de nuestra tabla users
         */
        ->join('users','ingresos.idusuario','=','users.id')
        ->select(
        'ingresos.id',
        'ingresos.tipo_comprobante',
        'ingresos.serie_comprobante',        
        'ingresos.fecha_hora',
        'ingresos.impuesto',
        'ingresos.total',
        'ingresos.estado',                       
        'personas.nombre',
        'users.usuario')
        /**
         * En esta funcion solo queremos ver un solo registro
         * por eso usamos la funcion where y la condicion es
         * de que el id de la tabla ingresos sea igual
         * al id que estamos recibiendo mediante ajax
         * y solo tomaremos un registro con el metodo
         * "take"
         */
        ->where('ingresos.id','=',$id)
        ->orderBy('ingresos.id', 'desc')->take(1)->get();
        
        return ['ingresos' => $ingreso];

    }

    public function obtenerDetalle(Request $request)
    {
        /**
         * Determinamos si la peticion que se haya hecho es diferente a una peticion ajax
         * sino se va redigirir a nuestro contenido principal, de esta manera solo se
         * puede acceder a nuestras funciones por la peticion ajax
         */
        if (!$request->ajax()) return redirect('/');

        /**
         * Declaramos una variable llamada "id"
         * En estas variables vamos almacenar en los parametros "buscar" y "criterio" a traves de AJAX mediante el metodo 
         * GET
         */
        $id = $request->id;        
        
        /**
         * Usaremos la propiedad join para unir nuestra tabla ingresos con la tabla articulo
         * y el select para seleccionar los campos con los que vamos a trabajar
         */
        /**
         * Vamos a unir detalle_ingreso con articulos mediante los campos
         * detalle_ingresos.idarticulo y articulo.id
         */
        $detalles = DetalleIngreso::join('articulos','detalle_ingresos.idarticulo','=','articulos.id')        
        ->select(
        'detalle_ingresos.cantidad',
        'detalle_ingresos.precio',
        'articulos.nombre as articulo'
        )
        /**
         * En esta funcion solo queremos ver un solo registro
         * por eso usamos la funcion where y la condicion es
         * de que el idingreso de la tabla detalle_ingresos sea igual
         * al id que estamos recibiendo mediante ajax
         */
        ->where('detalle_ingresos.idingreso','=',$id)
        ->orderBy('detalle_ingresos.id', 'desc')->get();
        
        return ['detalles' => $detalles];
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
             * Creamos esta variable con la clase Carbon e indicamos la hora
             * podemos buscar nuestra zona horaria buscando php zonetime 
             * Para captura la fecha y la hora automaticamente usamos este codigo
             */
            //$mytime = Carbon::now();
            $myfecha = date("d-m-Y");
            $myhora  = date(" g:i A");
            $mytime = $myfecha . $myhora;          
            /**
             * Creamos o instanciamos un objeto llamado "persona" de la clase "persona"
             * para acceder a las propiedades de la clase que son en este caso "nombre"
             * "tipo_documento",etc
             */
            $ingreso = new Ingreso();
            $ingreso->idproveedor = $request->idproveedor;
            /**
             * A nuestra propiedad idusuario le enviamos el id del usuario que se ha
             * autenticado
             */
            $ingreso->idusuario = \Auth::user()->id;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->serie_comprobante = $request->serie_comprobante;            
            /**
             * Para almacenar en nuestra propiedad fecha_hora le vamos asignar la variable
             * mytime y esta llamara el metodo "toDateString" para obtener la fecha y hora aceptable
             */
            $ingreso->fecha_hora = $mytime;
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total = $request->total;
            $ingreso->estado = 'Registrado';
            
            $ingreso->save();

            /**
             * Array de detalles, que recibe por medio de ajax todo el objeto
             * de la propiedad data
             */
           $detalles = $request->data;
            /**
             * Recorremos todos los elemetos del array detalles
             */
           foreach($detalles as $ep=>$det)
           {
               /**
                * Creamos el objeto detella que hace referencia al modelo
                * DetalleIngreso
                */
                $detalle = new DetalleIngreso();
                /**
                 * El id de detella ingreso le vamos a enviar es el id que se
                 * ha insertado de nuestra tabla ingresos
                 */
                $detalle->idingreso = $ingreso->id;
                /**
                 * La demas variables le vamos a enviar el indice de nuestro array
                 * detalles
                 */
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->save();                
           }
           /**
            * Creamos una variable llamada fechaActual
            * y con el metodo date elegimos el formato
            * este caso es año, mes y dia, y solo vamos
            * mostrar las notificaciones de ese dia en
            * especifico
            */
           $fechaActual = date('Y-m-d');

           /**
            * Luego creamos dos variables numVentas y 
            * numIngreos con el cual vamos hacer una 
            * consulta con su respectiva tabla haciendo
            * un filtro de la propiedad 'created_at'
            * que es la fecha de registro sea igual
            * al valor de la fechaActual y con el 
            * metodo count obtenemos la cantidad tanto
            * de ventas como de ingresos
            */
           $numVentas = DB::table('ventas')
           ->whereDate('created_at', $fechaActual)->count();
           $numIngresos = DB::table('ingresos')
           ->whereDate('created_at', $fechaActual)->count();

           /**
            * Ahora lo que hacemos es retornar estos valores
            * en un arreglo
            */

            $arregloDatos = [
                'ventas' =>[
                        'numero' => $numVentas,
                        'msj'    => 'Ventas'
                ],

                'ingresos' =>[
                           'numero' => $numIngresos,
                           'msj'    => 'Ingresos'
                ]
            ];

            /**
             * Ahora lo que haremos es hacerle la notificacion
            * a todos los usuario del sistema sobre la nueva
            * venta o el nuevo ingreso y para eso hacemos 
            * primero una consulta despues de capturar el arreglo
            */
            $allUsers = User::all();

            /**
             * Declaremos un foreach para recorrer a todos
             * los usuarios y dentro del foreach vamos 
             * a notificar 
             */
            foreach($allUsers as $notificar){
                User::findOrFail($notificar->id)->notify(new NotifyAdmin($arregloDatos));
            }

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
        $ingreso = Ingreso::findOrFail($request->id);
        $ingreso->estado = 'Anulado';
        $ingreso->save();
    }
}
