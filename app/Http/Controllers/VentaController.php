<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Venta;
use App\DetalleVenta;
use App\User;
use App\Notifications\NotifyAdmin;

class VentaController extends Controller
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
             * Usaremos la propiedad join para unir nuestra tabla ventas con la tabla personas y tambien con la tabla
             * personas y el select para seleccionar los campos con los que vamos a trabajar
             */
            /**
             * Lo que hacemos es unir la tabla personas con nuestra tabla ventas mediante el campo idcliente de nuestra tabla
             * ventas con el id de nuestra tabla personas
             */
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            /**
             * Vamos a unir la tabla users mediante el campo idusuario de nuestra tabla ventas 
             * con el id de nuestra tabla users
             */
            ->join('users','ventas.idusuario','=','users.id')
            ->select(
            'ventas.id',
            'ventas.tipo_comprobante',
            'ventas.serie_comprobante',            
            'ventas.fecha_hora',
            'ventas.impuesto',
            'ventas.total',
            'ventas.estado',                       
            'personas.nombre',
            'users.usuario')
            ->orderBy('ventas.id', 'desc')->paginate(10);
        }
        else{
            /**
             * Para este caso uniremos las tablas personas y ventas porque recordemos que para la creacion de un usuario
             * vamos a necesitar los datos de la persona y vamos a indicar que rol va tomar esa persona en el sistema
             */
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            /**
             * Vamos a unir la tabla users mediante el campo idusuario de nuestra tabla ventas 
             * con el id de nuestra tabla users
             */
            ->join('users','ventas.idusuario','=','users.id')
            ->select(
            'ventas.id',
            'ventas.tipo_comprobante',
            'ventas.serie_comprobante',            
            'ventas.fecha_hora',
            'ventas.impuesto',
            'ventas.total',
            'ventas.estado',                       
            'personas.nombre',
            'users.usuario')
            ->where('ventas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ventas.id', 'desc')->paginate(10);
        }

        /**
         * Ahora lo que haremos es colocar las instancias del paginador como la data, estos metodos lo podemos encontrar
         * en la documentacion de Laravel->database->pagination->Paginator Instance Methods
         */
        
        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
    }

    public function comprobante(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $comprobante = DB::table('ventas')->select('serie_comprobante')->orderBy('ventas.id','DESC')->first();           

        return ['ventas' => $comprobante];
        
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
         * Usaremos la propiedad join para unir nuestra tabla ventas con la tabla personas y tambien con la tabla
         * users y el select para seleccionar los campos con los que vamos a trabajar
         */
        /**
         * Lo que hacemos es unir la tabla personas con nuestra tabla ventas mediante el campo idcliente de nuestra tabla
         * ventas con el id de nuestra tabla personas
         */
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        /**
         * Vamos a unir la tabla users mediante el campo idusuario de nuestra tabla ventas con el id de nuestra tabla users
         */
        ->join('users','ventas.idusuario','=','users.id')
        ->select(
        'ventas.id',
        'ventas.tipo_comprobante',
        'ventas.serie_comprobante',
        'ventas.fecha_hora',
        'ventas.impuesto',
        'ventas.total',
        'ventas.estado',                       
        'personas.nombre',
        'users.usuario')
        /**
         * En esta funcion solo queremos ver un solo registro
         * por eso usamos la funcion where y la condicion es
         * de que el id de la tabla ventas sea igual
         * al id que estamos recibiendo mediante ajax
         * y solo tomaremos un registro con el metodo
         * "take"
         */
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();
        
        return ['venta' => $venta];

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
        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')        
        ->select(
        'detalle_ventas.cantidad',
        'detalle_ventas.precio',
        'detalle_ventas.descuento',
        'articulos.nombre as articulo' 
        )
        /**
         * En esta funcion solo queremos ver un solo registro
         * por eso usamos la funcion where y la condicion es
         * de que el idingreso de la tabla detalle_ventas sea igual
         * al id que estamos recibiendo mediante ajax
         */
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();
        
        return ['detalles' => $detalles];
    }

    /**
     * Vamos obtener los datos de la cabecera, es decir
     * los datos del cliente, la venta y los detalles 
     * de la venta
     */
    public function pdf(Request $request,$id)
    {
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select(
            'ventas.id',
            'ventas.tipo_comprobante',
            'ventas.serie_comprobante',            
            'ventas.created_at',
            'ventas.impuesto',
            'ventas.total',
            'ventas.estado',
            'personas.nombre',
            'personas.tipo_documento',
            'personas.num_documento',
            'personas.direccion',
            'personas.email',
            'personas.telefono',
            'users.usuario'
        )
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id','DESC')->take(1)->get();

        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select(
            'detalle_ventas.cantidad',
            'detalle_ventas.precio',
            'detalle_ventas.descuento',
            'articulos.nombre as articulo'
        )
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id','DESC')->get();

        $numventa =Venta::select('serie_comprobante')
        ->where('id',$id)->get();

        $pdf = \PDF::loadView('pdf.venta',['venta' => $venta,'detalles'=>$detalles]);
        return $pdf->download('venta-'.$numventa[0]->serie_comprobante.'.pdf');
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
            //$mytime = Carbon::now('America/Caracas');
            $myfecha = date("d-m-Y");
            $myhora  = date(" g:i A");
            $mytime = $myfecha . $myhora; 

            /**
             * Creamos o instanciamos un objeto llamado "persona" de la clase "persona"
             * para acceder a las propiedades de la clase que son en este caso "nombre"
             * "tipo_documento",etc
             */
            $venta = new Venta();
            $venta->idcliente = $request->idcliente;
            /**
             * A nuestra propiedad idusuario le enviamos el id del usuario que se ha
             * autenticado
             */
            $venta->idusuario = \Auth::user()->id;
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->serie_comprobante = $request->serie_comprobante;            
            /**
             * Para almacenar en nuestra propiedad fecha_hora le vamos asignar la variable
             * mytime y esta llamara el metodo "toDateString" para obtener la fecha y hora aceptable
             */
            $venta->fecha_hora = $mytime;
            $venta->impuesto = $request->impuesto;
            $venta->total = $request->total;
            $venta->estado = 'Registrado';
            
            $venta->save();

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
                $detalle = new DetalleVenta();
                /**
                 * El id de detella ingreso le vamos a enviar es el id que se
                 * ha insertado de nuestra tabla ingresos
                 */
                $detalle->idventa = $venta->id;
                /**
                 * La demas variables le vamos a enviar el indice de nuestro array
                 * detalles
                 */
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->descuento = $det['descuento'];
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

            return ['id' => $venta->id];
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
        $venta = Venta::findOrFail($request->id);
        $venta->estado = 'Anulado';
        $venta->save();
    }
}
