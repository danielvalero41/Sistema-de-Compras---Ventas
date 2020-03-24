<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla Listado -->
                <div class="card compacto">
                    <div class="card-header compacto">
                        <i class="fa fa-align-justify"></i> Ingreso
                        <!--A este boton le agregamos la directiva "click" para que llame el metodo "abrirModal" y le
                        enviamos por parametros el modelo y la accion que en este caso son "categoria" y "registrar"-->
                        <button type="button" @click="mostrarDetalle()" class="btn btn-secondary compacto">
                            <i class="icon-plus"></i>&nbsp;Nuevo Ingreso
                        </button>
                    </div>
                    <!--LISTADO-->
                    <!--Si queremos visualizar el listado 
                    de ingreso la variable listado sera
                    igual a 1-->
                    <template v-if="listado==1">
                        <div class="card-body compacto">
                         <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <!--Con la directiva "v-model" enlazamos la variable criterio con la opciones 
                                    que nos muestra el select para elegir en que criterio queremos hacer la busqueda-->
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="tipo_comprobante">Tipo Comprobante</option>                                      
                                      <option value="fecha_hora">Fecha-Hora</option>                                    
                                    </select>
                                    <!--De igual manera en el input usamos la directiva "v-model" y lo enlazamos a la
                                    variable "buscar"
                                    Usando la directiva "v-on" que hace referencia a la funcion "keyup" esto significa
                                    que cuando se oprima la tecla "enter" llamara al metodo "listarCategorias" y le 
                                    vamos a enviar los parametros que en este caso seria primero el numero de la pagina
                                    que en este caso sera la primera, despues la variable "buscar" de la propiedad "data" 
                                    que esta enlazada a la caja de texto por la directiva "v-model" igual que la variable
                                    "criterio"-->
                                    <input type="text" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <!--Aqui usando tambien la directiva "v-on" llamamos a la funcion "click" y llamamos al metodo "listarIngreso"
                                    y enviamos los mismos parametros-->
                                    <button type="submit" @click="listarIngreso(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Opciones</th>
                                    <th class="text-center">Usuarios</th>
                                    <th class="text-center">Proveedor</th>
                                    <th class="text-center">Tipo Comprobante</th>
                                    <th class="text-center">Serie Comprobante</th>                                    
                                    <th class="text-center">Fecha Hora</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Impuesto</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--Recorremos el "arrayingreso" con la variable "ingreso" con la directiva "v-for"
                                 que tiene como llave principal "ingreso.id".
                                 De esta manera ya tenemos una tabla de manera dinamica-->
                                <tr v-for="ingreso in arrayIngreso" :key="ingreso.id">
                                    <td class="text-center">
                                        <!--Aqui volvemos a agregar la directiva "click" y el enviamos los parametros modelo,
                                        accion y la data que en este caso si vamos a enviar
                                        Para el modelo seria "ingreso", la accion "actualizar" y la data seria ingreso
                                        esta si la enviamos porque existe el objeto que esta recorriendo en el arreglo 
                                        "arrayingreso" y lo enviamos como un objeto osea sin ('')-->
                                        <button type="button" @click="verIngreso(ingreso.id)" class="btn btn-success btn-sm compacto" title="Ver Ingreso">
                                          <i class="icon-eye"></i>
                                        </button> &nbsp;
                                        <!--Creamos un template con la directiva "v-if" para validar la condicion
                                        Si en este caso la condicion es 1 muestras el boton.
                                        En el boton colocamos la directiva "click" y llamamos el metodo "desactivarCate-
                                        goria" y le vamos a enviar el id de esa categoria-->
                                        <template v-if="ingreso.estado=='Registrado'">
                                            <button type="button" class="btn btn-danger btn-sm compacto" @click="desactivarIngreso(ingreso.id)" title="Anular Ingreso">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>                                        
                                    </td>
                                    <!--Con la directiva "v-text" mostramos lo que tiene el "arrayPersona" para mostrar
                                    en la vista-->
                                    <td class="text-center" v-text="ingreso.usuario"></td>
                                    <td class="text-center" v-text="ingreso.nombre"></td>
                                    <td class="text-center" v-text="ingreso.tipo_comprobante"></td>
                                    <td class="text-center" v-text="ingreso.serie_comprobante"></td>                                    
                                    <td class="text-center" v-text="ingreso.fecha_hora"></td>
                                    <td class="text-center" v-text="ingreso.total"></td>
                                    <td class="text-center" v-text="ingreso.impuesto"></td>
                                    <td class="text-center" v-text="ingreso.estado"></td>
                                </tr>                                
                            </tbody>
                        </table>
                        </div>                        
                        <nav>
                            <ul class="pagination">
                                <!--En esta seccion usamos la directiva "v-if" y llamamos al arreglo "pagination" con
                                el valor de "current_page" estableciendo que si ese valor es mayor que 1 muestre el boton
                                de enlace-->
                                <li class="page-item" v-if="pagination.current_page > 1">
                                    <!--Ahora llamamos la directiva "click.prevent" para cuando de click llame al metodo
                                    "cambiarPagina" y a la pagina actual le vamos a restar 1-->
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio)">Ant</a>
                                </li>
                                <!--Para este caso usaremos la directiva "v-for" y usaremos la propiedad computada que se llama 
                                "pagesNumber", usamos tambien como llave primaria (key) la variable "page" y luego usando la
                                directiva "bind" la clase "active" esto me va indicar si la pagina esta activa llamaremos a la 
                                clase "active"
                                Recordemos que en la propiedad computada "isActive" retorna el valor de la pagina actual-->
                                <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio)" v-text="page"></a>
                                </li>
                                <!--Esto es para indicar de que como todavia no me encuentro en la ultima pagina puedo 
                                mostrar el boton de la siguiente-->
                                <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                    <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio)">Sig</a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                    </template>
                    <!--FIN DEL LISTADO-->

                    <!--DETALLE-->
                    <!--Si queremos ver el formulario para
                    agregar un igreso y sus detalles
                    el listado sera igual a 0-->
                    <template v-else-if="listado==0">
                        <div class="card-body compacto">                            
                        <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for=""><strong>Nombre del proveedor:</strong></label>
                                        <!--Cuando instalamos el componente v-select, esta instalara la ultima version
                                        que es la 3.4.0 en el cual hay cambios, buscar en la documentacion de vue para
                                        aplicar los cambios, mas que todo en como son llamados por ejemplo
                                        "on-search" es ahora @search
                                        NOTA: Se arreglo el error de el porque llegaba el arrayProeedor vacio y era
                                        porque en el metedo selectProveedor recibia una variable "search" y el cual
                                        no la estabamos mandando por eso salia indefinida y no hacia ningun filtro
                                        NOTA2: Lo que hicmos para asignarle el idproveedor del v-select fue enlazar una
                                        variable que creamos en la propiedad data llamada "val1" el cual obtiene todo
                                        arreglo del arrayProveedor que seleccionamos en la lista por medio de "options". Ya con esto lo que 
                                        hacemos es enviar por parametro la variable val1 que ahora es un objeto y 
                                        en el metodo getDatosProveedor alli la asignamos a la propiedad idproveedor-->
                                        <v-select
                                            
                                            @search="selectProveedor(search)"
                                            label="nombre"                                                                    
                                            :options="arrayProveedor"   
                                            v-model="val1"                           
                                            placeholder="Buscar Proveedores"
                                            @input="getDatosProveedor(val1)"
                                        >
                                            
                                        </v-select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label for=""><strong>N° Factura</strong></label>
                                    <input type="text" class="form-control compacto" readonly style="background:white;" v-model="serie_comprobante">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for=""><strong>Tipo Comprobante:</strong></label>
                                            <select class="form-control compacto" v-model="tipo_comprobante">
                                                <option value="">Seleccione</option>
                                                <option value="BOLETA">Boleta</option>
                                                <option value="FACTURA">Factura</option>
                                                <option value="TICKET">Ticket</option>
                                            </select>
                                    </div>
                                </div>
                                
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for=""><strong>Numero del proveedor</strong></label>
                                        <input type="text" class="form-control compacto" v-model="numproveedor" readonly style="background:white;">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for=""><strong>Impuesto:</strong></label>                                            
                                        <input type="text" class="form-control compacto" v-model="impuesto" readonly style="background:white;">
                                    </div>
                                </div>
                                
                                <div class="col-md">
                                    <div class="form-group">
                                        <label for=""><strong>Nombre del contacto:</strong></label>
                                        <input type="text" class="form-control compacto" v-model="nomproveedor" readonly style="background:white;">
                                    </div>
                                </div>
                            </div>                                                        
                            <div class="col-md-12">
                                <div v-show="errorIngreso" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>
                            </div>
                        
                        
                        <div class="form-group row compacto">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <!--En este label agregamos un span y con la directiva
                                    v.show indicaremos que se muestre lo que esta dentro de
                                    la etiqueta span si el idarticulo es igual a 0-->
                                    <label for=""><strong>Buscar articulo:</strong></label>
                                    <v-select
                                        @search="selectArticulo(search)"
                                        label="nombre"                                                                    
                                        :options="arrayArticulo"   
                                        v-model="val2"                           
                                        placeholder="Buscar por nombre del producto"
                                        @input="getDatosArticulo(val2)"                                        
                                    >
                                    </v-select>
                                    <div class="form-inline">
                                        <!--Este input va estar enlazado a la variable codigo, que sera
                                        el codigo de barra.
                                        Lo que hacemos es hacer una consulta con el codigo de barra de nuestra tabla 
                                        articulos, es decir ingresamos el codigo de barra, si este existe nos debe
                                        devolver el nombre del articulo que enlazamos abajo en el siguiente input-->
                                        <!-- <input type="text" class="form-control compacto" v-model="codigo" @keyup.enter="buscarArticulo()" placeholder="Ingrese articulo">-->
                                        <!-- <button @click="abrirModal()" class="btn btn-primary">...</button>-->
                                        <!-- Este input solo sera de lectura-->
                                        <!-- <input type="text" readonly class="form-control compacto" style="background:white;" v-model="articulo">-->
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for=""><strong>Precio:</strong></label>                                    
                                    <input type="number" min="0"  step="any" class="form-control compacto" v-model="precio">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for=""><strong>Cantidad disponible:</strong></label>
                                    
                                    <input type="number" min="0"  class="form-control compacto" v-model="cantidad">
                                </div>    
                            </div>                            
                            <div class="col-md-2">
                                <div class="form-group">
                                   <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar compacto">                                       
                                       <i class="icon-plus"></i>
                                       <strong>Agregar articulo</strong>
                                   </button>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="table-responsive col-md-12">
                                <table class="table table-hover table-sm">
                                    
                                    <thead>
                                        <tr>
                                            <th class="text-center">Opciones</th>
                                            <th class="text-center">Articulo</th>
                                            <th class="text-center">Precio</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <!--Vamos a mostar la tabla de detalles de los 
                                    articulos si se encuentra uno en el arreglo 
                                    arrayDetalle-->
                                    <tbody v-if="arrayDetalle.length">
                                        <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                            <td>
                                                <!--Ah este boton le agregamos el evento click que este
                                                a su vez llama al metodo eliminarDetalle y le pasamos el
                                                parametro index-->
                                                <button @click="eliminarDetalle(index)" type="button" class="btn btn-danger btn-sm">
                                                    <i class="icon-close"></i>
                                                </button>
                                            </td>
                                            <!--Nombre del articulo-->
                                            <td v-text="detalle.articulo">                                                
                                            </td>
                                            <!--Precio-->
                                            <td>
                                                <input type="number" v-model="detalle.precio" value="3" class="form-control">
                                            </td>
                                            <!--Cantidad-->
                                            <td>
                                                <input type="number" v-model="detalle.cantidad" value="2" class="form-control">
                                            </td>
                                            <!--Sub-total-->
                                            <td>
                                               $ {{detalle.precio * detalle.cantidad}} 
                                            </td>
                                        </tr>                                        
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                            <!---->
                                            <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                            <!--Hacemos el calculo del total del impuesto y con el
                                            metodo toFixed lo que hacemos es asignarle solo dos 
                                            decimales al resultado-->
                                            <td>$ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                        </tr>
                                        <tr style="background-color: #CEECF5;">
                                            <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                            <!--Guardamos en la variable total de la propiedad data
                                            el metodo calcularTotal que retorna el calculto total
                                            de todos los articulos ingresados-->
                                            <td>$ {{total=calcularTotal}}</td>
                                        </tr>
                                    </tbody>
                                    <!--Sino hay articulos en el arreglo mostramos
                                    el siguiente mensaje y con la propiedad colspan
                                    damos la misma dimension de 5 columnas que tiene
                                    la tabla-->
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5">
                                                No hay articuos agregados
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-secondary compacto" @click="ocultarDetalle()">Cerrar</button>
                                <button type="button" class="btn btn-primary compacto" @click="registrarIngreso()">Registrar Compra</button>
                            </div>
                        </div>
                    </div>
                    </template>
                    <!--FIN DEL DETALLE-->
                    <!--VER INGRESO-->
                    <!--Y si queremos visualizar el detalle
                    de un ingreso registrado previamente
                    el listado sera igual a 2-->
                    <template v-else-if="listado==2">
                            <div class="card-body compacto">
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="">Proveedor</label>
                                        <p v-text="proveedor"></p>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <label for="">Impuesto</label>
                                    <p v-text="impuesto"></p>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Tipo Comprobante</label>
                                        <p v-text="tipo_comprobante"></p>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Serie Comprobante</label>
                                        <p v-text="serie_comprobante"></p>
                                    </div>
                                </div>                                                               
                            </div>
                                                        
                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table-hover table-sm">
                                        
                                        <thead>
                                            <tr>                                                
                                                <th>Articulo</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <!--Vamos a mostar la tabla de detalles de los 
                                        articulos si se encuentra uno en el arreglo 
                                        arrayDetalle-->
                                        <tbody v-if="arrayDetalle.length">
                                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">                                                
                                                <!--Nombre del articulo-->
                                                <td v-text="detalle.articulo">                                                
                                                </td>
                                                <!--Precio-->
                                                <td v-text="detalle.precio"> 
                                                </td>
                                                <!--Cantidad-->
                                                <td v-text="detalle.cantidad">                                                   
                                                </td>
                                                <!--Sub-total-->
                                                <td>
                                                $ {{detalle.precio * detalle.cantidad}} 
                                                </td>
                                            </tr>                                        
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="4" align="right"><strong>Total Parcial:</strong></td>
                                                <!---->
                                                <td>$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="4" align="right"><strong>Total Impuesto:</strong></td>
                                                
                                                <td>$ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                                            </tr>
                                            <tr style="background-color: #CEECF5;">
                                                <td colspan="4" align="right"><strong>Total Neto:</strong></td>
                                                
                                                <td>$ {{total}}</td>
                                            </tr>
                                        </tbody>
                                        <!--Sino hay articulos en el arreglo mostramos
                                        el siguiente mensaje y con la propiedad colspan
                                        damos la misma dimension de 5 columnas que tiene
                                        la tabla-->
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="5">
                                                    No hay articuos agregados
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <button type="button" class="btn btn-secondary compacto" @click="ocultarDetalle()">Cerrar</button>                                    
                                </div>
                            </div>
                        </div>
                    </template>
                    <!--FIN DE VER INGRESO-->
               </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>
            <!--Inicio del modal agregar/actualizar-->
            <!--Se agrega una directiva en este caso es "v-bind" que anexa un resultado al atributo "class" y diremos que
            el modal anexara a la clase mostrar si la variable modal es verdadero o 1-->
            <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
                <div class="modal-dialog modal-primary modal-lg" role="document">
                    <div class="modal-content compacto">
                        <div class="modal-header compacto">
                            <h4 class="modal-title" v-text="tituloModal"></h4>
                            <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <!--En este modal lo usamos para mostrar una ventana-->
                        <div class="modal-body">
                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <!--Con la directiva "v-model" enlazamos la variable criterio con la opciones 
                                        que nos muestra el select en este caso son "nombre" y "descripcion"-->
                                        <select class="form-control col-md-3" v-model="criterioA">
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        <option value="codigo">Codigo</option>
                                        </select>
                                        <!--De igual manera en el input usamos la directiva "v-model" y lo enlazamos a la
                                        variable "buscar"
                                        Usando la directiva "v-on" que hace referencia a la funcion "keyup" esto significa
                                        que cuando se oprima la tecla "enter" llamara al metodo "listarCategorias" y le 
                                        vamos a enviar los parametros que en este caso seria primero el numero de la pagina
                                        que en este caso sera la primera, despues la variable "buscar" de la propiedad "data" 
                                        que esta enlazada a la caja de texto por la directiva "v-model" igual que la variable
                                        "criterio"-->
                                        <input type="text" v-model="buscarA" @keyup.enter="listarArticulo(buscarA,criterioA)" class="form-control" placeholder="Texto a buscar">
                                        <!--Aqui usando tambien la directiva "v-on" llamamos a la funcion "click" y llamamos al metodo "listarCategorias"
                                        y enviamos los mismos parametros-->
                                        <button type="submit" @click="listarArticulo(buscarA,criterioA)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                    </div>
                                </div>
                        </div>
                            <div class="table-responsive">
                                <table class="table table-hover table-sm">
                                    <thead>
                                        <tr>
                                            <th>Opciones</th>
                                            <th>Código</th>
                                            <th>Nombre</th>
                                            <th>Categoría</th>
                                            <th>Precio Venta</th>
                                            <th>Stock</th>
                                            <th>Estado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <!--Recorremos el "arrayArticulo" con la variable "articulo" con la directiva "v-for"
                                        que tiene como llave principal "articulo.id".
                                        De esta manera ya tenemos una tabla de manera dinamica-->
                                        <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                            <td>
                                                <!--Aqui volvemos a agregar la directiva "click" y el enviamos los parametros modelo,
                                                accion y la data que en este caso si vamos a enviar
                                                Para el modelo seria "articulo", la accion "actualizar" y la data seria articulo
                                                esta si la enviamos porque existe el objeto que esta recorriendo en el arreglo 
                                                "arrayArticulo" y lo enviamos como un objeto osea sin ('')-->
                                                <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-success btn-sm compacto">
                                                <i class="icon-check"></i>
                                                </button> 
                                            </td>
                                            <!--Con la directiva "v-text" mostramos lo que tiene el "arrayArticulo" para mostrar
                                            en la vista-->
                                            <td v-text="articulo.codigo"></td>
                                            <td v-text="articulo.nombre"></td>
                                            <!--Recordemos que para obtener el nombre de la categoria en nuestra funcion index hacemos el llamado
                                            del nombre de categoria con el alias "nombre_categoria"-->
                                            <td v-text="articulo.nombre_categoria"></td>
                                            <td v-text="articulo.precio_venta"></td>
                                            <td v-text="articulo.stock"></td>                                            
                                            <!--Usamos las directiva "v-if" y "v-else" para determinar si la articulo esta 
                                            activa o inactiva-->
                                            <td>
                                                <div v-if="articulo.condicion">
                                                    <span class="badge badge-success">Activo</span>
                                                </div>
                                                <div v-else>
                                                    <span class="badge badge-danger">Desactivado</span>
                                                </div>
                                                
                                            </td>
                                        </tr>                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary compacto" @click="cerrarModal()">Cerrar</button>
                            <!--Aqui agregamos la directiva "v-if" para determinar que boton se debe seleccionar 
                            dependiendo de que si se quiere guardar o actualizar-->
                            <button type="button" v-if="tipoAccion==1" class="btn btn-primary compacto" @click="registrarPersona()">Guardar</button>
                            <button type="button" v-if="tipoAccion==2" class="btn btn-primary compacto" @click="actualizarPersona()">Actualizar</button>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!--Fin del modal-->
        </main>
</template>

<script>
    import vSelect from 'vue-select';
    import 'vue-select/dist/vue-select.css';
    export default {
        props:['ruta'],
        data (){
            return {
                /*
                 *Datos de la tabla ingreso con los cuales vamos a trabajar
                 */
                ingreso_id: 0,//Con esto voy a utilizar el id del ingreso que quiero actualizar
                idproveedor: 0,
                proveedor:'',
                nombre : '',
                tipo_comprobante:'BOLETA',
                serie_comprobante: '',
                numproveedor: '',
                nomproveedor: '',
                impuesto: 0.18,
                total: 0.0,
                totalImpuesto:0.0,
                totalParcial:0.0,
                arrayIngreso : [],
                arrayDetalle: [],  
                arrayProveedor:[],  
                listado: 1,                            
                modal : 0,//Variable con la cual determinamos si estara abierto o cerrado la ventana modal
                tituloModal : '',
                tipoAccion : 0,//Nos indica si estamos registrarndo o actualizando
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
                /**
                 * Creamos el objeto "pagination" y colocamos la misma estructura que tiene el controlador, todos 
                 * inicializados en 0
                 */
                pagination : {
                    'total' : 0,//Total de registros
                    'current_page' : 0,//pagina actual
                    'per_page' : 0,//Numero de registros por pagina
                    'last_page' : 0,//Ultima pagina
                    'from' : 0,//Desde la pagina
                    'to' : 0,//Hasta la pagina
                },
                offset : 3,
                search:'',// Indicamos el texto con el cual vamos hacer el filtro de busqueda    
                val1:'',  //Variable que usamos para guardar un objeto de nuestro arrayProveedor en nuestro v-select          
                criterio : 'fecha_hora',//Indicamos cual sera el criterio de busqueda
                buscar : '',//Indicamos el texto de busqueda para iniciar el filtro del registro
                criterioA:'nombre',
                buscarA:'',
                /**
                 * Variables que vamos a usar referente al articulo que vamos a comprar
                 */
                arrayArticulo: [],
                idarticulo:0,
                codigo:'',
                articulo:'',
                precio: 0,
                cantidad: 0
            }
        },
        components:{
            vSelect
        },
        /**
         * Propiedad computada donde estableceremos algunas funciones
         */
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            },

            /**
             * En este metodo hace el calculo de todo
             * los ingresos y lo que hacemos es reco-
             * -rrer todo el arreglo arrayDetalle y
             * lo que hacemos es guardar en una variable
             * e ir sumando cada vez que se agregue un
             * articulo
             */
            calcularTotal: function(){
                var resultado=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado = resultado + (this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad);
                }

                return resultado;
            }
        },
        /**
         * Axios, es una biblioteca que te permite realizar peticiones HTTP desde el navegador, ademas 
         * transforma las peticiones en JSON
         */
        methods : {
            /**
            * Usando el primer ejemplo de Axios con el metodo "get" y mediante ese verbo capturamos los datos que se
            * envia a traves de la direccion que en este caso es "/ingreso"
            */
            listarIngreso (page,buscar,criterio){
                let me=this;
                /**
                 * Lo que hacemos es crear la variable "url" que contiene la direccion mas el parametro "page","buscar" 
                 * y "criterio" por medio del verbo "get" y le asignamos el valor que recibe a traves del metodo
                 */
                var url=this.ruta + '/ingreso?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    /**
                     * Se crea una variable llamada "me" y esto lo que hace es guardar en el arrayPersona los datos 
                     * por medio del objeto "response"
                     */
                    var respuesta= response.data;
                    /**
                     * Se presentaba un error a la hora de mostrar la data ya que antes se le estaba asignando al 
                     * arreglo "arrayingreso" respuesta.ingresos.data lo cual no trae ningun registro
                     * Se cambio por respuesta.proveedores.data, esto se nota cuando lo revisamos por console
                     * y nos muestras como van viniendo los datos
                     */
                    me.arrayIngreso = respuesta.ingresos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            /**
             * Con esto mediante axios hacemos referencia a la ruta que llama la funcion "selectProveedor" de nuestro 
             * controlador y devuelve una lista de todos los proveedores, la capturamos y la guardamos en el 
             * arreglo arrayProveedor
             */
            selectProveedor(search,loading){                
                let me=this;
                me.loading = true;
                var url=this.ruta + '/proveedor/selectProveedor?filtro='+search;
                axios.get(url).then(function (response) {
                    /**
                     * Se crea una variable llamada "me" y esto lo que hace es guardar en el arrayPersona los datos 
                     * por medio del objeto "response"
                     */                    
                    var respuesta= response.data;
                    q:search
                    me.arrayProveedor = respuesta.proveedores;
                    me.loading = false;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            /**
             * Este metodo lo llamamos en el componente v-select el cual manda un objeto y aqui
             * lo recibimos con el nombre de "val1" y lo que hacemos es asignarle al idproveedor
             * el id que se encuentra en el objeto val1
             */
            getDatosProveedor(val1){
                console.log(val1);
                let me = this;
                if(val1==null){
                    me.loading = true;
                    me.idproveedor = 0;
                    me.numproveedor = '';
                    me.nomproveedor = '';
                }else{
                    me.loading = true;
                    me.idproveedor = val1.id;
                    me.numproveedor = val1.telefono;
                    me.nomproveedor = val1.contacto;
                }
                
            },

            selectArticulo(search,loading){                
                let me=this;
                me.loading = true;
                var url=this.ruta + '/articulo/selectArticulo?filtro='+search;
                axios.get(url).then(function (response) {
                    /**
                     * Se crea una variable llamada "me" y esto lo que hace es guardar en el arrayPersona los datos 
                     * por medio del objeto "response"
                     */                    
                    var respuesta= response.data;
                    q:search
                    me.arrayArticulo = respuesta.articulos;
                    me.loading = false;
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            /**
             * Este metodo lo llamamos en el componente v-select el cual manda un objeto y aqui
             * lo recibimos con el nombre de "val1" y lo que hacemos es asignarle al idproveedor
             * el id que se encuentra en el objeto val1
             */
            getDatosArticulo(val2){
                console.log(val2);
                let me = this;
                if(val2==null){
                    me.loading = true;
                    me.idarticulo = 0;
                    me.articulo = '';
                    me.precio = 0;
                    me.stock = 0;
                    me.cantidad = 0; 
                }else{
                    me.loading = true;
                    me.idarticulo = val2.id;
                    me.articulo = val2.nombre;
                    me.precio = val2.precio_venta;
                    me.stock = val2.stock;
                    me.cantidad = val2.stock;
                }
                
            },

            /**
             * Mediante ajax hacemos referencia a la funcion buscarArticulo de nuestro
             * controlador ArticuloController el que cual a traves del filtro que enviamos
             * con el metodo GET obtenemos el filtro y este buscara en la base de datos
             * el codigo del articulo y lo guardara en el arrayArticulo.
             * Luego con un condicional asignamos a las variables articulo e idarticulo
             * con nuestro datos que se encuentra en el arreglo arrayArticulo
             */
            buscarArticulo(){
                let me = this;
                var url =this.ruta + '/articulo/buscarArticulo?filtro=' + me.codigo;
                
                axios.get(url).then(function (response) {
                var respuesta = response.data;
                me.arrayArticulo = respuesta.articulos;

                if (me.arrayArticulo.length>0) {
                    me.articulo = me.arrayArticulo[0]['nombre'];
                    me.idarticulo = me.arrayArticulo[0]['id'];
                }else{
                    me.articulo = 'No existe el articulo';
                    me.idarticulo = 0;
                }
                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            encuentra(id){
                var sw=false;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idarticulo == id){
                        sw=true;
                    }
                }
                return sw;
            },

            /**
             * Este metodo nos permitira cancelar un registro de
             * detalle a la compra
             */
            eliminarDetalle(index){
                let me = this;
                /**
                 * Con el metodo "splice" lo que hacemos es
                 * eliminar un objeto que tenga el valor de
                 * indice index y solo se va a eliminar 1
                 * solo objeto
                 */
                me.arrayDetalle.splice(index,1);
            },

            /**
             * Este metodo lo que permite es agregar variable
             * al arrayDetalle, variables que ya estan cargadas
             * y enlazadas de la propiedad data
             */
            agregarDetalle(){
                let me = this;
                me.cantidad = 1;
                /**
                 * Validamos que si no hay nada tanto como la cantidad, precio
                 * o idarticulo, no agregue o no haga ninguna accion
                 */
                if(me.idarticulo ==0 || me.cantidad==0 || me.precio==0){
                    
                }else{
                    /**
                     * Hacemos un condicional para verificar si ya
                     * se ha agregado un articulo con le mismo id
                     * Si se encuentra mostramos un error con la
                     * libreria sweetalert
                     */
                    if(me.encuentra(me.idarticulo)){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese articulo ya se encuentra agregado'
                        })
                    }else{
                        me.arrayDetalle.push({
                        idarticulo: me.idarticulo,
                        articulo: me.articulo,
                        cantidad: me.cantidad,
                        precio: me.precio
                        });
                        /**
                         * Despues de agregar el detalle inicializamos todo
                         * en 0 o vacio
                         */
                        me.codigo = "";
                        me.idarticulo = 0;
                        me.articulo = "";
                        me.precio = 0;
                        me.cantidad = 0;
                    }
                    
                }
                
            },
            /**
             * Similar al metodo agregarDetalle solo con la
             * diferencia de que el metodo recibe un arreglo
             * de articulo con el cual usando el id el articulo
             * lo vamos a enviar al metodo encuentra
             */
            agregarDetalleModal(data){
                let me = this;
                console.log(data);
                /**
                     * Hacemos un condicional para verificar si ya
                     * se ha agregado un articulo con le mismo id
                     * Si se encuentra mostramos un error con la
                     * libreria sweetalert
                     */
                    if(me.encuentra(data['id'])){
                        swal({
                            type: 'error',
                            title: 'Error...',
                            text: 'Ese articulo ya se encuentra agregado'
                        })
                    }else{
                        me.arrayDetalle.push({
                        idarticulo: data['id'],
                        articulo: data['nombre'],
                        cantidad: 1,
                        precio: 1
                        });                        
                    }
            },

            /**
             * Este listararticulo lo vamos a usar para mostrar todos
             * los articulos para la ventana modal que se abrira cuando
             * queramos agregar detalles al ingreso
             */
            listarArticulo (buscar,criterio){
                let me=this;
                /**
                 * Lo que hacemos es crear la variable "url" que contiene la direccion mas el parametro "page","buscar" 
                 * y "criterio" por medio del verbo "get" y le asignamos el valor que recibe a traves del metodo
                 */
                var url=this.ruta +'/articulo/listarArticulo?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    /**
                     * Se crea una variable llamada "me" y esto lo que hace es guardar en el arrayArticulo los datos 
                     * por medio del objeto "response"
                     */
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;                    
                })
                .catch(function (error) {
                    console.log(error);
                });
            },

            /**
             * Este metedo recibe como parametro "page" que va recibir el numero de pagina que queremos mostrar
             */
            cambiarPagina(page,buscar,criterio){
                let me = this;
                //Actualiza la página actual
                /**
                 * Le estamos asignando al arreglo "pagination" al atributo "current_page" el valor que 
                 * recibe por parametro que en este caso es "page"
                 */
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarIngreso(page,buscar,criterio);
            },
            /**
             * En este metodo usamos axios pero con verbo "post" y en este caso vamos a enviar dos parametros
             * 1. la ruta que en este caso seria "/ingreso/registrar" y este hace referencia a nuestro metodo "store" de 
             * nuestro controlador de ingreso
             * 2. Vamos enviar los valores que va recibir el controlador en este caso vamos a enviar el "nombre" y la
             * "descripcion"
             */
            registrarIngreso(){
                /**
                 * Con esto validamos que no se presente un error
                 * Si el metodo devuelve un 1 significa que hay un error y se sale del metodo por lo que no permite guardar
                 */
                if (this.validarIngreso()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/ingreso/registrar',{
                    'idproveedor': this.idproveedor,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,                    
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'idrol' : this.idrol,
                    'data': this.arrayDetalle
                    

                }).then(function (response) {                   
                    /**
                     * Despues de registar inicializamos el metodo "listarIngreso" de esta manera que cuando
                     * terminemos un registro en el primer parametro que es "1" nos mande a la primera pagina
                     * El segundo parametro de buscar sea vacio
                     * Y el tercero sera fecha_hora 
                     */
                    me.listado=1;
                    me.listarIngreso(1,'','fecha_hora');
                    me.idproveedor= 0;
                    me.tipo_comprobante= 'BOLETA';
                    me.serie_comprobante= '';                    
                    me.impuesto= 0.18;
                    me.total= 0.0;
                    me.idarticulo= 0;
                    me.articulo= '';
                    me.cantidad= 0;
                    me.precio= 0;
                    me.arrayDetalle=[];
                }).catch(function (error) {
                    console.log(error);
                });
            },
           
            validarIngreso(){
                this.errorIngreso=0;
                this.errorMostrarMsjIngreso =[];
                if(this.idproveedor==0) this.errorMostrarMsjIngreso.push("Seleccione un Proveedor");
                if(this.tipo_comprobante==0) this.errorMostrarMsjIngreso.push("Seleccione el comprobante");                
                if(!this.impuesto) this.errorMostrarMsjIngreso.push("Ingrese el impuesto de compra");
                if(this.arrayDetalle.length<=0) this.errorMostrarMsjIngreso.push("Ingrese detalles");
                
                if(this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;
                return this.errorIngreso;
            },

            mostrarDetalle(){
                let me = this;
                var url= this.ruta +'/ingreso/comprobante';
                axios.get(url).then(function (response) {                    
                    var respuesta= response.data;   
                    //console.log(parseInt(respuesta.ventas.serie_comprobante) + 1);
                    
                    me.serie_comprobante = parseInt(respuesta.ingresos.serie_comprobante) + 1;
                })
                .catch(function (error) {
                    console.log(error);
                });
                this.listado=0;
                me.idproveedor= 0;
                me.tipo_comprobante= 'BOLETA';                
                me.impuesto= 0.18;
                me.total= 0.0;
                me.idarticulo= 0;
                me.articulo= '';
                me.cantidad= 0;
                me.precio= 0;
                me.arrayDetalle=[];
            },

            ocultarDetalle(){
                this.listado=1;
            },

            verIngreso(id){
                /**
                     * Se crea una variable llamada "me" y esto lo que hace es guardar en el arrayPersona los datos 
                     * por medio del objeto "response"
                     */
                let me= this;
                me.listado=2;
                
                /**
                 * Obtener los datos del ingreso
                 */
                /**
                 * Creamos un arreglo temporal llamado arrayIngresoT
                 * inicializado en vacio
                 */
                var arrayIngresoT = [];
                var url=this.ruta + '/ingreso/obtenerCabecera?id='+id;
                axios.get(url).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    /**
                     * Luego de obtener el valor resultante
                     * de nuestra url y guardada en la varia-
                     * -ble respuesta, vamos a asignarla
                     * al arreglo arrayIngresoT el valor de
                     * respuesta.ingreso que recordemos que
                     * "ingreso" lo retorna la funcion
                     * "obtenerCabecera" que hacemos referen-
                     * -cia en la url                     
                     */
                    arrayIngresoT = respuesta.ingresos;
                    /**
                     * Ahora lo que hacemos es asignarle a la
                     * variable proveedor de nuestra propiedad
                     * data el valor que tenemos en nuestro
                     * arreglo ya cargado arrayIngresoT
                     */
                    me.proveedor = arrayIngresoT[0]['nombre'];
                    me.tipo_comprobante = arrayIngresoT[0]['tipo_comprobante'];
                    me.serie_comprobante = arrayIngresoT[0]['serie_comprobante'];                    
                    me.impuesto = arrayIngresoT[0]['impuesto'];
                    me.total = arrayIngresoT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                /**
                 * Obtener los datos de los detalles
                 */

                var urld=this.ruta + '/ingreso/obtenerDetalle?id='+id;
                axios.get(urld).then(function (response) {
                    
                    var respuesta= response.data;
                    /**
                     * Luego de obtener el valor resultante
                     * de nuestra url y guardada en la varia-
                     * -ble respuesta, vamos a asignarla
                     * al arreglo arrayDetalle el valor de
                     * respuesta.detalles que recordemos que
                     * "detalles" lo retorna la funcion
                     * "obtenerDetalles" que hacemos referen-
                     * -cia en la url                     
                     */
                    me.arrayDetalle = respuesta.detalles;
                                        
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            /**
             * Con este metodo indicamos que la variable modal sera 0 y se cerrara la ventana modal ademas de inicializar
             * los valores
             */
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },
            /**
             * Este metodo contiene 3 parametros
             * 1.El modelo que en este caso sera persona
             * 2.La accion que tendra dos posibles acciones "registrar" o "actualizar"
             * 3.El objeto de esa fila de la tabla de persona de la tabla de la base de datos
             */
            abrirModal(){
                this.arrayArticulo = [];
                this.modal = 1;//Con esto indicamos que se debe mostrar la ventana modal
                this.tituloModal = 'Seleccione uno o varios articulos';
                              
            },

             /*
              * En este metodo lo que hacemos es modificar la
              * url para que haga referencia al controlador
              * IngresoController y a su funcion desactivar
              * Modificamos tambien el mensaje que queremos 
              * mostrar y aplicamos el trigger cuando anulamos
              * un ingreso, esto ultimo lo hacemos en la pagina
              * de phpmyAdmin en la seccion de SQL
              */
            desactivarIngreso(id){
               swal({
                title: 'Esta seguro de anular este ingreso?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar!',
                cancelButtonText: 'Cancelar',
                confirmButtonClass: 'btn btn-success',
                cancelButtonClass: 'btn btn-danger',
                buttonsStyling: false,
                reverseButtons: true
                }).then((result) => {
                if (result.value) {
                    let me = this;

                    axios.put(this.ruta +'/ingreso/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarIngreso(1,'','fecha_hora');
                        swal(
                        'Anulado!',
                        'El ingreso ha sido anulado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                    
                    
                } else if (
                    // Read more about handling dismissals
                    result.dismiss === swal.DismissReason.cancel
                ) {
                    
                }
                }) 
            },
            
        },
        /**
        * Le enviaremos al metodo "listarIngreso" los valores que tenga la propiedad data en ese momento
        */
        mounted() {
            this.listarIngreso(1,this.buscar,this.criterio);
        }
    }
</script>
<!--Creamos las clases para cuando queramos mostrar la ventana modal-->
<style>    
    .modal-content{
        width: 100% !important;
        position: absolute !important;
    }
    .mostrar{
        display: list-item !important;
        opacity: 1 !important;
        position: absolute !important;
        background-color: #3c29297a !important;
    }
    .div-error{
        display: flex;
        justify-content: center;
    }
    .text-error{
        color: red !important;
        font-weight: bold;
    }


    @media(min-width: 600px){
        .btnagregar{
            margin-top: 2rem;
        }
    }
</style>
