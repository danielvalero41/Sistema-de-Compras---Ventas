<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/**
 * Empezamos creando nuestro primero "Route::group" y creamos nuestro primer "middleware" y este caso
 * va ser para invitados(guest) lo que no se han autenticado van a tener acceso a las siguientes rutas
 */

Route::group(['middleware'=>['guest']],function(){
    /**
     * Esto lo podra visualizar cualquier usuario, el podra visualizar el formulario para ingresar
     * sus credenciales y poder entrar al sistema
     */
    Route::get('/','Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

/**
 * Este grupo de rutas van para los usuarios autenticados que han ingresado al sistema correctamente
 */

Route::group(['middleware'=>['auth']],function(){
    /**
     * Por defecto estamos haciendo referencia a la funcion _invoke
     */
    Route::get('/dashboard','DashboardController');
    /**
     * Ruta de notificaciones que hemos creado en el archivo
     * app.js
     */
    Route::post('/notification/get','NotificationController@get');
    
    /**
     * Creamos la ruta para los usuarios autenticados puedan salirse
     */
    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');//El metodo "name" sive para colocarle como alias en este caso es "main"

    /**
    * Para este grupo de rutas lo podran ver los usuarios de rol "Almacenero" y estos tendran
    * acceso a las rutas para poder gestionar las categorias, los articulos, los proveedores
    * y los ingresos
    */
    Route::group(['middleware' => ['Almacenero']], function () {
        /**
         * Como se va obtener datos de la base de datos se usa el metedo "get", luego este recibe dos parametros
         * El primero es la direccion uri como se va escribir en la URL en este caso "/categoria"
         * El segundo indica el controlador y la funcion en la que apunta que seria el controlador "categoria" y su funcion "index"
         */
        Route::get('/categoria', 'CategoriaController@index');
        /**
         * En esta caso usamos el metodo "post" que tambien recibe dos parametros el primero para cuando se indique la uri
         * "/categoria/registrar" vamos hacer referencia al controlador "CategoriaController" y a la funcion "store"
         */
        Route::post('/categoria/registrar', 'CategoriaController@store');
        /**
         * Con el metodo "put" podemos actualizar la informacion, en esta caso lo usamos para las diferentes uir's y controla-
         * dores
         */
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');

        /**
         * Como se va obtener datos de la base de datos se usa el metedo "get", luego este recibe dos parametros
         * El primero es la direccion uri como se va escribir en la URL en este caso "/articulo"
         * El segundo indica el controlador y la funcion en la que apunta que seria el controlador "articulo" y su funcion "index"
         */
        Route::get('/articulo', 'ArticuloController@index');
        /**
         * En esta caso usamos el metodo "post" que tambien recibe dos parametros el primero para cuando se indique la uri
         * "/articulo/registrar" vamos hacer referencia al controlador "articuloController" y a la funcion "store"
         */
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf');        
        

        /**
         * Como se va obtener datos de la base de datos se usa el metedo "get", luego este recibe dos parametros
         * El primero es la direccion uri como se va escribir en la URL en este caso "/proveedor"
         * El segundo indica el controlador y la funcion en la que apunta que seria el controlador "categoria" y su funcion "index"
         */
        Route::get('/proveedor', 'ProveedorController@index');
        /**
         * En esta caso usamos el metodo "post" que tambien recibe dos parametros el primero para cuando se indique la uri
         * "/proveedor/registrar" vamos hacer referencia al controlador "ProveedorController" y a la funcion "store"
         */
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        /**
         * Con el metodo "put" podemos actualizar la informacion, en esta caso lo usamos para las diferentes uir's y controla-
         * dores
         */
        Route::put('/proveedor/actualizar', 'ProveedorController@update');

        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');

        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalle', 'IngresoController@obtenerDetalle');
        Route::get('/ingreso/comprobante', 'IngresoController@comprobante');

    });//TERMINA EL ROUTE GROUP DE ALMACENERO

    /**
     * Creamos el grupo de rutas para el "Vendedor" el cual tendra acceso a las rutas de los clientes por ahora
     */
    Route::group(['middleware' => ['Vendedor']], function () {
        /**
         * Como se va obtener datos de la base de datos se usa el metedo "get", luego este recibe dos parametros
         * El primero es la direccion uri como se va escribir en la URL en este caso "/cliente"
         * El segundo indica el controlador y la funcion en la que apunta que seria el controlador "categoria" y su funcion "index"
         */
        Route::get('/cliente', 'ClienteController@index');
        /**
         * En esta caso usamos el metodo "post" que tambien recibe dos parametros el primero para cuando se indique la uri
         * "/cliente/registrar" vamos hacer referencia al controlador "ClienteController" y a la funcion "store"
         */
        Route::post('/cliente/registrar', 'ClienteController@store');
        /**
         * Con el metodo "put" podemos actualizar la informacion, en esta caso lo usamos para las diferentes uir's y controla-
         * dores
         */
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

        Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');
        Route::get('/articulo/selectArticulo', 'ArticuloController@selectArticulo');

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalle', 'VentaController@obtenerDetalle');
        Route::get('/venta/comprobante', 'VentaController@comprobante');
        /**
         * A esta ruta el vamos a enviar por parametros un id
         * porque este parametro lo estamos recibiendo en el
         * controlador
         */
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');
    });//TERMINA EL ROUTE GROUP DE VENDEDOR

    /**
     * Creamos el grupo de rutas de administrador y tendra acceso a las rutas de los clientes, categorias, articulos,
     *  proveedores,etc.
     */
    Route::group(['middleware' => ['Administrador']], function () {
        
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');

        Route::get('/articulo', 'ArticuloController@index');
        Route::get('/articuloo', 'ArticuloController@indexx');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');
        Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');
        Route::get('/articulo/listarPdf', 'ArticuloController@listarPdf');
        Route::get('/articulo/selectArticulo', 'ArticuloController@selectArticulo');

        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');

        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalle', 'IngresoController@obtenerDetalle');
        Route::get('/ingreso/comprobante', 'IngresoController@comprobante');
        
        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');
        Route::put('/venta/desactivar', 'VentaController@desactivar');
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalle', 'VentaController@obtenerDetalle');
        Route::get('/venta/comprobante', 'VentaController@comprobante');
        /**
         * A esta ruta el vamos a enviar por parametros un id
         * porque este parametro lo estamos recibiendo en el
         * controlador
         */
        Route::get('/venta/pdf//{id}', 'VentaController@pdf')->name('venta_pdf');

        Route::get('/rol', 'RolController@index');
        Route::get('/rol/selectRol', 'RolController@selectRol');
        
        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');

        
    });//TERMINA EL ROUTE GROUP DE ADMINISTRADOR

});//TERMINA EL ROUTE GROUP DE AUTH

//Route::get('/home', 'HomeController@index')->name('home');
