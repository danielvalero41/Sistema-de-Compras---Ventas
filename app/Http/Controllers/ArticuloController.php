<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Articulo;

class ArticuloController extends Controller
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
         * de la tabla articulos por el "id" de manera descendente"
         * Sino listaremos el registro de la tabla articulos donde la condicion sea que la variable "buscar" pueda
         * estar al inicio o al final del campo de donde esta el campo "criterio"
         */
        if ($buscar==''){
            /**
             * Utilizando el join lo que hacemos es lo siguiente
             * Vamos a unir la tabla "categorias" de manera de que en la tabla "articulos" el valor de
             * "idcategoria" de la tabla articulos sea = al "id" de la tabla "categorias"
             * En terminos simples hacemos la union de la llave foranea de la tabla articulos "idcategoria"
             * con la llave primaria de la tabla categorias
             */
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            /**
             * Con select vamos a seleccionar los campos que queremos usar tanto de la tabla articulos como de la tabla
             * categorias
             */
            ->select('articulos.id',
            'articulos.idcategoria',
            'articulos.codigo',
            'articulos.nombre',
            /**
            * Como ya hacemos un llamado a la variable "nombre" utilizamos el "as" para hacerle un alias con
            * el nombre de "nombre_categoria"
            */
            'categorias.nombre as nombre_categoria',
            'articulos.precio_venta',
            'articulos.stock',
            'articulos.descripcion',
            'articulos.condicion')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
             /**
             * Con select vamos a seleccionar los campos que queremos usar tanto de la tabla articulos como de la tabla
             * categorias
             */
            ->select('articulos.id',
            'articulos.idcategoria',
            'articulos.codigo',
            'articulos.nombre',
            'categorias.nombre as nombre_categoria',
            'articulos.precio_venta',
            'articulos.stock',
            'articulos.descripcion',
            'articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        
         /**
         * Ahora lo que haremos es colocar las instancias del paginador como la data, estos metodos lo podemos encontrar
         * en la documentacion de Laravel->database->pagination->Paginator Instance Methods
         */
        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
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
     * mediante el arreglo articulos
     */
    public function selectArticulo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $filtro = $request->filtro;
        $articulos = Articulo::where('nombre','like','%'. $filtro . '%')
        ->where('condicion','=',1)      
        ->select(
            'id',
            'nombre',
            'precio_venta',
            'stock')
        ->orderBy('nombre','ASC')->get();

        return ['articulos' => $articulos];
        
    }

    public function indexx(Request $request)
    {
        /**
         * Determinamos si la peticion que se haya hecho es diferente a una peticion ajax
         * sino se va redigirir a nuestro contenido principal, de esta manera solo se
         * puede acceder a nuestras funciones por la peticion ajax
         */
        //if (!$request->ajax()) return redirect('/');

        /**
         * Declaramos dos variables "buscar" y "criterio"
         * En estas variables vamos almacenar en los parametros "buscar" y "criterio" a traves de AJAX mediante el metodo GET
         */
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        
        /**
         * Establecemos un campo condicional donde si el campo buscar esta vacio listaremos todos los registros
         * de la tabla articulos por el "id" de manera descendente"
         * Sino listaremos el registro de la tabla articulos donde la condicion sea que la variable "buscar" pueda
         * estar al inicio o al final del campo de donde esta el campo "criterio"
         */
        if ($buscar==''){
            /**
             * Utilizando el join lo que hacemos es lo siguiente
             * Vamos a unir la tabla "categorias" de manera de que en la tabla "articulos" el valor de
             * "idcategoria" de la tabla articulos sea = al "id" de la tabla "categorias"
             * En terminos simples hacemos la union de la llave foranea de la tabla articulos "idcategoria"
             * con la llave primaria de la tabla categorias
             */
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            /**
             * Con select vamos a seleccionar los campos que queremos usar tanto de la tabla articulos como de la tabla
             * categorias
             */
            ->select('articulos.id',
            'articulos.idcategoria',
            'articulos.codigo',
            'articulos.nombre',
            /**
            * Como ya hacemos un llamado a la variable "nombre" utilizamos el "as" para hacerle un alias con
            * el nombre de "nombre_categoria"
            */
            'categorias.nombre as nombre_categoria',
            'articulos.precio_venta',
            'articulos.stock',
            'articulos.descripcion',
            'articulos.condicion')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
             /**
             * Con select vamos a seleccionar los campos que queremos usar tanto de la tabla articulos como de la tabla
             * categorias
             */
            ->select('articulos.id',
            'articulos.idcategoria',
            'articulos.codigo',
            'articulos.nombre',
            'categorias.nombre as nombre_categoria',
            'articulos.precio_venta',
            'articulos.stock',
            'articulos.descripcion',
            'articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        
         /**
         * Ahora lo que haremos es colocar las instancias del paginador como la data, estos metodos lo podemos encontrar
         * en la documentacion de Laravel->database->pagination->Paginator Instance Methods
         */
        return [
            'pagination' => [
                'total'        => $articulos->total(),
                'current_page' => $articulos->currentPage(),
                'per_page'     => $articulos->perPage(),
                'last_page'    => $articulos->lastPage(),
                'from'         => $articulos->firstItem(),
                'to'           => $articulos->lastItem(),
            ],
            'articulos' => $articulos
        ];
    }

    public function listarArticulo(Request $request)
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
         * de la tabla articulos por el "id" de manera descendente"
         * Sino listaremos el registro de la tabla articulos donde la condicion sea que la variable "buscar" pueda
         * estar al inicio o al final del campo de donde esta el campo "criterio"
         */
        if ($buscar==''){
            /**
             * Utilizando el join lo que hacemos es lo siguiente
             * Vamos a unir la tabla "categorias" de manera de que en la tabla "articulos" el valor de
             * "idcategoria" sea = al "id" de la tabla "categorias"
             * En terminos simples hacemos la union de la llave foranea de la tabla articulos "idcategoria"
             * con la llave primaria de la tabla categorias
             */
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            /**
             * Con select vamos a seleccionar los campos que queremos usar tanto de la tabla articulos como de la tabla
             * categorias
             */
            ->select('articulos.id',
            'articulos.idcategoria',
            'articulos.codigo',
            'articulos.nombre',
            /**
            * Como ya hacemos un llamado a la variable "nombre" utilizamos el "as" para hacerle un alias con
            * el nombre de "nombre_categoria"
            */
            'categorias.nombre as nombre_categoria',
            'articulos.precio_venta',
            'articulos.stock',
            'articulos.descripcion',
            'articulos.condicion')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
             /**
             * Con select vamos a seleccionar los campos que queremos usar tanto de la tabla articulos como de la tabla
             * categorias
             */
            ->select('articulos.id',
            'articulos.idcategoria',
            'articulos.codigo',
            'articulos.nombre',
            'categorias.nombre as nombre_categoria',
            'articulos.precio_venta',
            'articulos.stock',
            'articulos.descripcion',
            'articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        
         /**
         * Ahora lo que haremos es colocar las instancias del paginador como la data, estos metodos lo podemos encontrar
         * en la documentacion de Laravel->database->pagination->Paginator Instance Methods
         */
        return ['articulos' => $articulos];
    }

    public function listarArticuloVenta(Request $request)
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
         * de la tabla articulos por el "id" de manera descendente"
         * Sino listaremos el registro de la tabla articulos donde la condicion sea que la variable "buscar" pueda
         * estar al inicio o al final del campo de donde esta el campo "criterio"
         */
        if ($buscar==''){
            /**
             * Utilizando el join lo que hacemos es lo siguiente
             * Vamos a unir la tabla "categorias" de manera de que en la tabla "articulos" el valor de
             * "idcategoria" sea = al "id" de la tabla "categorias"
             * En terminos simples hacemos la union de la llave foranea de la tabla articulos "idcategoria"
             * con la llave primaria de la tabla categorias
             */
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            /**
             * Con select vamos a seleccionar los campos que queremos usar tanto de la tabla articulos como de la tabla
             * categorias
             */
            ->select('articulos.id',
            'articulos.idcategoria',
            'articulos.codigo',
            'articulos.nombre',
            /**
            * Como ya hacemos un llamado a la variable "nombre" utilizamos el "as" para hacerle un alias con
            * el nombre de "nombre_categoria"
            */
            'categorias.nombre as nombre_categoria',
            'articulos.precio_venta',
            'articulos.stock',
            'articulos.descripcion',
            'articulos.condicion')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        else{
            $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
             /**
             * Con select vamos a seleccionar los campos que queremos usar tanto de la tabla articulos como de la tabla
             * categorias
             */
            ->select('articulos.id',
            'articulos.idcategoria',
            'articulos.codigo',
            'articulos.nombre',
            'categorias.nombre as nombre_categoria',
            'articulos.precio_venta',
            'articulos.stock',
            'articulos.descripcion',
            'articulos.condicion')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')
            ->where('articulos.stock','>','0')
            ->orderBy('articulos.id', 'desc')->paginate(10);
        }
        
         /**
         * Ahora lo que haremos es colocar las instancias del paginador como la data, estos metodos lo podemos encontrar
         * en la documentacion de Laravel->database->pagination->Paginator Instance Methods
         */
        return ['articulos' => $articulos];
    }

    /**
     * Funcion para generar reportes pdf de articulos
     */
    public function listarPdf()
    {
        $articulos = Articulo::join('categorias','articulos.idcategoria','=','categorias.id')
            /**
             * Con select vamos a seleccionar los campos que queremos usar tanto de la tabla articulos como de la tabla
             * categorias
             */
            ->select('articulos.id',
            'articulos.idcategoria',
            'articulos.codigo',
            'articulos.nombre',
            /**
            * Como ya hacemos un llamado a la variable "nombre" utilizamos el "as" para hacerle un alias con
            * el nombre de "nombre_categoria"
            */
            'categorias.nombre as nombre_categoria',
            'articulos.precio_venta',
            'articulos.stock',
            'articulos.descripcion',
            'articulos.condicion')
            ->orderBy('articulos.nombre', 'desc')->get();
        /**
         * Esta variable almacenara la cantidad de registros
         * que tenemos en la tabla articulos
         */
        $cont = Articulo::count();
        /**
         * Con esto vamos generar una vista llamada articulos.pdf
         * con el metodo loadView
         */
        $pdf = \PDF::loadView('pdf.articulospdf',['articulos' => $articulos,'cont'=>$cont]);
        return $pdf->download('articulos.pdf');
    }
    
    public function buscarArticulo(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        /**
         * Declaramos una variable para realizar el filtro que sera
         * recibido mediante ajax. En este caso hacemos el filtro de 
         * los articulos que queremos mostrar, el filtro va ser el codigo
         * de barra del articulo que deseo encontrar en la tabla articulo
         * de la base datos
         */

         $filtro = $request->filtro;
         /**
          * De nuestra tabla articulo vamos a seleccionar un registro
          * cuando el codigo del articulo se igual a la variable filtro
          * que obtenemos mediante ajax y seleccionaremos el id y el nombre
          * lo ordenamos de manera ascendente y tomaremos solo un registro
          */
         $articulos = Articulo::where('codigo','=',$filtro)
         ->select('id','nombre')->orderBy('nombre','asc')->take(1)->get();

         return ['articulos' =>$articulos];
    }

    public function buscarArticuloVenta(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        /**
         * Declaramos una variable para realizar el filtro que sera
         * recibido mediante ajax. En este caso hacemos el filtro de 
         * los articulos que queremos mostrar, el filtro va ser el codigo
         * de barra del articulo que deseo encontrar en la tabla articulo
         * de la base datos
         */

         $filtro = $request->filtro;
         /**
          * De nuestra tabla articulo vamos a seleccionar un registro
          * cuando el codigo del articulo se igual a la variable filtro
          * que obtenemos mediante ajax y seleccionaremos el id, el nombre
          * el stock y el precio_venta lo ordenamos de manera ascendente 
          * y tomaremos solo un registro
          */
         $articulos = Articulo::where('codigo','=',$filtro)
         ->select(
             'id',
             'nombre',
             'stock',
             'precio_venta')
         ->where('stock','>','0')
         ->orderBy('nombre','asc')->take(1)->get();

         return ['articulos' =>$articulos];
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
         * Creamos o instanciamos un objeto llamado "articulo" de la clase "Articulo"
         * para acceder a las propiedades de la clase que son en este caso
         */
        $articulo = new Articulo();
        /**
         * Desde el objeto "articulo" le estamos asignando a todas las propiedades de la tabla articulos con el objeto "request"
         * Recordemos que todos estos valores los estamos enviando a traves de ajax por eso usamos el objeto "request"
         */
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        /**
         * Con esto insertamos este objeto en nuestra tabla "articulos" de nuestra base de datos
         */
        $articulo->save();
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
        $articulo = Articulo::findOrFail($request->id);
        $articulo->idcategoria = $request->idcategoria;
        $articulo->codigo = $request->codigo;
        $articulo->nombre = $request->nombre;
        $articulo->precio_venta = $request->precio_venta;
        $articulo->stock = $request->stock;
        $articulo->descripcion = $request->descripcion;
        $articulo->condicion = '1';
        $articulo->save();
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
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '0';
        $articulo->save();
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
        $articulo = Articulo::findOrFail($request->id);
        $articulo->condicion = '1';
        $articulo->save();
    }

}
