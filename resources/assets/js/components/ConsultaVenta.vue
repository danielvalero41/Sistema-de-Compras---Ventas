<template>
            <main class="main">
            <!-- Breadcrumb -->
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
            </ol>
            <div class="container-fluid">
                <!-- Ejemplo de tabla |-->
                <div class="card compacto">
                    <div class="card-header compacto">
                        <i class="fa fa-align-justify"></i> Venta                        
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
                                      <option value="num_comprobante">Numero Comprobante</option>
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
                                    <input type="text" v-model="buscar" @keyup.enter="listarVenta(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <!--Aqui usando tambien la directiva "v-on" llamamos a la funcion "click" y llamamos al metodo "listarVenta"
                                    y enviamos los mismos parametros-->
                                    <button type="submit" @click="listarVenta(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Opciones</th>
                                    <th class="text-center">Usuarios</th>
                                    <th class="text-center">Cliente</th>
                                    <th class="text-center">Tipo Comprobante</th>
                                    <th class="text-center">Serie Comprobante</th>
                                    <th class="text-center">Numero Comprobante</th>
                                    <th class="text-center">Fecha Hora</th>
                                    <th class="text-center">Total</th>
                                    <th class="text-center">Impuesto</th>
                                    <th class="text-center">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--Recorremos el "arrayventa" con la variable "venta" con la directiva "v-for"
                                 que tiene como llave principal "venta.id".
                                 De esta manera ya tenemos una tabla de manera dinamica-->
                                <tr v-for="venta in arrayVenta" :key="venta.id">
                                    <td class="text-center">
                                        <!--Aqui volvemos a agregar la directiva "click" y el enviamos los parametros modelo,
                                        accion y la data que en este caso si vamos a enviar
                                        Para el modelo seria "venta", la accion "actualizar" y la data seria venta
                                        esta si la enviamos porque existe el objeto que esta recorriendo en el arreglo 
                                        "arrayventa" y lo enviamos como un objeto osea sin ('')-->
                                        <button type="button" @click="verVenta(venta.id)" class="btn btn-success btn-sm compacto" title="Ver Venta">
                                          <i class="icon-eye"></i>
                                        </button> &nbsp;
                                        <!--Con este boton vamos a descargar los datos
                                        de la venta en un pdf-->
                                        <button type="button" @click="pdfVenta(venta.id)" class="btn btn-info btn-sm compacto" title="Descargar Reporte de Venta">
                                          <i class="icon-doc"></i>
                                        </button> &nbsp;                                                                              
                                    </td>
                                    <!--Con la directiva "v-text" mostramos lo que tiene el "arrayPersona" para mostrar
                                    en la vista-->
                                    <td class="text-center" v-text="venta.usuario"></td>
                                    <td class="text-center" v-text="venta.nombre"></td>
                                    <td class="text-center" v-text="venta.tipo_comprobante"></td>
                                    <td class="text-center" v-text="venta.serie_comprobante"></td>
                                    <td class="text-center" v-text="venta.num_comprobante"></td>
                                    <td class="text-center" v-text="venta.fecha_hora"></td>
                                    <td class="text-center" v-text="venta.total"></td>
                                    <td class="text-center" v-text="venta.impuesto"></td>
                                    <td class="text-center" v-text="venta.estado"></td>
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
                    
                    <!--VER INGRESO-->
                    <!--Y si queremos visualizar el detalle
                    de un ingreso registrado previamente
                    el listado sera igual a 2-->
                    <template v-else-if="listado==2">
                            <div class="card-body">
                            <div class="form-group row border">
                                <div class="col-md-9">
                                    <div class="form-group">
                                        <label for="">Cliente</label>
                                        <p v-text="cliente"></p>
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label for="">Numero Comprobante</label>
                                        <p v-text="num_comprobante"></p>
                                    </div>
                                </div>                                
                            </div>
                                                        
                            <div class="form-group row border">
                                <div class="table-responsive col-md-12">
                                    <table class="table table.bordered table-striped table-sm">
                                        
                                        <thead>
                                            <tr>                                                
                                                <th>Articulo</th>
                                                <th>Precio</th>
                                                <th>Cantidad</th>
                                                <th>Descuento</th>
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
                                                <!--Descuento-->
                                                <td v-text="detalle.descuento">                                                   
                                                </td>
                                                <!--Sub-total-->
                                                <td>
                                                $ {{detalle.precio * detalle.cantidad - detalle.descuento}} 
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
                                    <button type="button" class="btn btn-secondary" @click="ocultarDetalle()">Cerrar</button>                                    
                                </div>
                            </div>
                        </div>
                    </template>
                    <!--FIN DE VER INGRESO-->
               </div>
                <!-- Fin ejemplo de tabla Listado -->
            </div>           
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
                venta_id: 0,//Con esto voy a utilizar el id del ingreso que quiero actualizar
                idcliente: 0,
                cliente:'',
                descuento: 0,
                nombre : '',
                stock: 0,
                tipo_comprobante:'BOLETA',
                serie_comprobante: '',
                num_comprobante: '',
                impuesto: 0.18,
                total: 0.0,
                totalImpuesto:0.0,
                totalParcial:0.0,
                arrayVenta : [],
                arrayDetalle: [],  
                arrayCliente:[],  
                listado: 1,                            
                modal : 0,//Variable con la cual determinamos si estara abierto o cerrado la ventana modal
                tituloModal : '',
                tipoAccion : 0,//Nos indica si estamos registrarndo o actualizando
                errorVenta : 0,
                errorMostrarMsjVenta : [],
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
                criterio : 'num_comprobante',//Indicamos cual sera el criterio de busqueda
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
                    resultado = resultado + (this.arrayDetalle[i].precio * this.arrayDetalle[i].cantidad - this.arrayDetalle[i].descuento);
                }

                return resultado;
            }
        },
        /**
         *  compacto, es una biblioteca que te permite realizar peticiones HTTP desde el navegador, ademas 
         * transforma las peticiones en JSON
         */
        methods : {
            /**
            * Usando el primer ejemplo de Axios con el metodo "get" y mediante ese verbo capturamos los datos que se
            * envia a traves de la direccion que en este caso es "/ingreso"
            */
            listarVenta (page,buscar,criterio){
                let me=this;
                /**
                 * Lo que hacemos es crear la variable "url" que contiene la direccion mas el parametro "page","buscar" 
                 * y "criterio" por medio del verbo "get" y le asignamos el valor que recibe a traves del metodo
                 */
                var url=this.ruta +  '/venta?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
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
                    me.arrayVenta = respuesta.ventas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
        

            pdfVenta(id){
                window.open('http://localhost:8000/venta/pdf/'+ id + ',' +'_blank');
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
                me.listarVenta(page,buscar,criterio);
            },
            
            mostrarDetalle(){
                let me = this;
                this.listado=0;
                me.idproveedor= 0;
                me.tipo_comprobante= 'BOLETA';
                me.serie_comprobante= '';
                me.num_comprobante= '';
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

            verVenta(id){
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
                var arrayVentaT = [];
                var url=this.ruta +  '/venta/obtenerCabecera?id='+id;
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
                    arrayVentaT = respuesta.venta;
                    /**
                     * Ahora lo que hacemos es asignarle a la
                     * variable proveedor de nuestra propiedad
                     * data el valor que tenemos en nuestro
                     * arreglo ya cargado arrayVentaT
                     */
                    me.cliente = arrayVentaT[0]['nombre'];
                    me.tipo_comprobante = arrayVentaT[0]['tipo_comprobante'];
                    me.serie_comprobante = arrayVentaT[0]['serie_comprobante'];
                    me.num_comprobante = arrayVentaT[0]['num_comprobante'];
                    me.impuesto = arrayVentaT[0]['impuesto'];
                    me.total = arrayVentaT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                /**
                 * Obtener los datos de los detalles
                 */

                var urld=this.ruta +  '/venta/obtenerDetalle?id='+id;
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
            
        },
        /**
        * Le enviaremos al metodo "listarIngreso" los valores que tenga la propiedad data en ese momento
        */
        mounted() {
            this.listarVenta(1,this.buscar,this.criterio);
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
