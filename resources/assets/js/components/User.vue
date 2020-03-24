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
                        <i class="fa fa-align-justify"></i> Usuario
                        <!--A este boton le agregamos la directiva "click" para que llame el metodo "abrirModal" y le
                        enviamos por parametros el modelo y la accion que en este caso son "categoria" y "registrar"-->
                        <button type="button" @click="abrirModal('persona','registrar')" class="btn btn-secondary compacto">
                            <i class="icon-plus"></i>&nbsp;Nuevo Usuario
                        </button>
                    </div>
                    <div class="card-body compacto">
                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="input-group">
                                    <!--Con la directiva "v-model" enlazamos la variable criterio con la opciones 
                                    que nos muestra el select para elegir en que criterio queremos hacer la busqueda-->
                                    <select class="form-control col-md-3" v-model="criterio">
                                      <option value="nombre">Nombre</option>
                                      <option value="tipo_documento">Tipo de documento</option>
                                      <option value="num_documento">Numero de documento</option>                                      
                                      <option value="telefono">Teléfono</option>
                                    </select>
                                    <!--De igual manera en el input usamos la directiva "v-model" y lo enlazamos a la
                                    variable "buscar"
                                    Usando la directiva "v-on" que hace referencia a la funcion "keyup" esto significa
                                    que cuando se oprima la tecla "enter" llamara al metodo "listarCategorias" y le 
                                    vamos a enviar los parametros que en este caso seria primero el numero de la pagina
                                    que en este caso sera la primera, despues la variable "buscar" de la propiedad "data" 
                                    que esta enlazada a la caja de texto por la directiva "v-model" igual que la variable
                                    "criterio"-->
                                    <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio)" class="form-control" placeholder="Texto a buscar">
                                    <!--Aqui usando tambien la directiva "v-on" llamamos a la funcion "click" y llamamos al metodo "listarPersona"
                                    y enviamos los mismos parametros-->
                                    <button type="submit" @click="listarPersona(1,buscar,criterio)" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        <table class="table table-hover table-sm">
                            <thead>
                                <tr>
                                    <th class="text-center">Opciones</th>
                                    <th class="text-center">Nombre</th>
                                    <th class="text-center">Tipo Documento</th>
                                    <th class="text-center">Número</th>
                                    <th class="text-center">Dirección</th>
                                    <th class="text-center">Teléfono</th>
                                    <th class="text-center">Email</th>
                                    <th class="text-center">Usuario</th>
                                    <th class="text-center">Rol</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!--Recorremos el "arraypersona" con la variable "persona" con la directiva "v-for"
                                 que tiene como llave principal "persona.id".
                                 De esta manera ya tenemos una tabla de manera dinamica-->
                                <tr v-for="persona in arrayPersona" :key="persona.id">
                                    <td class="text-center">
                                        <!--Aqui volvemos a agregar la directiva "click" y el enviamos los parametros modelo,
                                        accion y la data que en este caso si vamos a enviar
                                        Para el modelo seria "persona", la accion "actualizar" y la data seria persona
                                        esta si la enviamos porque existe el objeto que esta recorriendo en el arreglo 
                                        "arrayPersona" y lo enviamos como un objeto osea sin ('')-->
                                        <button type="button" @click="abrirModal('persona','actualizar',persona)" class="btn btn-warning btn-sm compacto" title="Actualizar Datos">
                                          <i class="icon-pencil"></i>
                                        </button> &nbsp;
                                        <!--Creamos un template con la directiva "v-if" para validar la condicion
                                        Si en este caso la condicion es 1 muestras el boton.
                                        En el boton colocamos la directiva "click" y llamamos el metodo "desactivarCate-
                                        goria" y le vamos a enviar el id de esa categoria-->
                                        <template v-if="persona.condicion">
                                            <button type="button" class="btn btn-danger btn-sm compacto" @click="desactivarUsuario(persona.id)" title="Desactivar Usuario">
                                                <i class="icon-trash"></i>
                                            </button>
                                        </template>
                                        <template v-else>
                                            <button type="button" class="btn btn-info btn-sm compacto" @click="activarUsuario(persona.id)" title="Activar Usuario">
                                                <i class="icon-check"></i>
                                            </button>
                                        </template>
                                    </td>
                                    <!--Con la directiva "v-text" mostramos lo que tiene el "arrayPersona" para mostrar
                                    en la vista-->
                                    <td class="text-center" v-text="persona.nombre"></td>
                                    <td class="text-center" v-text="persona.tipo_documento"></td>
                                    <td class="text-center" v-text="persona.num_documento"></td>
                                    <td class="text-center" v-text="persona.direccion"></td>
                                    <td class="text-center" v-text="persona.telefono"></td>
                                    <td class="text-center" v-text="persona.email"></td>
                                    <td class="text-center" v-text="persona.usuario"></td>
                                    <td class="text-center" v-text="persona.rol"></td>
                                </tr>                                
                            </tbody>
                        </table>
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
                        <div class="modal-body compacto">
                            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Nombre(*)</label>
                                    <div class="col-md-9">
                                        <!--Aqui agregammos la directiva "v-model" que es una relacion bidireccional
                                        En cual podemos agregar y escribir sobre la propiedad o variable "nombre"
                                        igual aplicamos la directiva para para cuando agregamos la descripcion-->
                                        <input type="text" v-model="nombre" class="form-control" placeholder="Nombre de la persona">                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="text-input">Tipo documento</label>
                                    <div class="col-md-9">
                                        <select v-model="tipo_documento" class="form-control">
                                            <option value="DNI">DNI</option>
                                            <option value="RUC">RUC</option>
                                            <option value="CEDULA">CEDULA</option>
                                            <option value="PASS">PASS</option>
                                        </select>                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Número documento</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="num_documento" class="form-control" placeholder="Número de documento">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Dirección</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="direccion" class="form-control" placeholder="Dirección">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Teléfono</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="telefono" class="form-control" placeholder="Teléfono">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Email</label>
                                    <div class="col-md-9">
                                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>
                                </div>
                                <!--Aqui agregamos el campo exclusivo del componente user-->
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Role</label>
                                    <div class="col-md-9">
                                        <select v-model="idrol" class="form-control">
                                            <option value="0" disabled>Seleccione</option>
                                            <option v-for="role in arrayRol" :key="role.id" :value="role.id" v-text="role.nombre"></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">Usuario</label>
                                    <div class="col-md-9">
                                        <input type="text" v-model="usuario" class="form-control" placeholder="Nombre del usuario">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3 form-control-label" for="email-input">password</label>
                                    <div class="col-md-9">
                                        <input type="password" v-model="password" class="form-control" placeholder="password del usuario">
                                    </div>
                                </div>
                                <!--Aqui nos encargamos de mostrar los errores que ocurran, en este caso si se llegara
                                a producir un error sobre de que no puede dejar el nombre de la persona en vacio-->
                                <div v-show="errorPersona" class="form-group row div-error">
                                    <div class="text-center text-error">
                                        <div v-for="error in errorMostrarMsjPersona" :key="error" v-text="error">

                                        </div>
                                    </div>
                                </div>

                            </form>
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
    export default {
        props:['ruta'],
        data (){
            return {
                /*
                 *Datos de la tabla cliente con los cuales vamos a trabajar
                 */
                persona_id: 0,//Con esto voy a utilizar el id de la persona que quiero actualizar
                nombre : '',
                tipo_documento : 'CEDULA',
                num_documento : '',
                direccion : '',
                telefono : '',
                email : '',
                /**
                 * Variables exclusivas de la tabla user */
                usuario: '',
                password:'',
                idrol: '',
                /**
                 * Con este array lo que haremos es que la data que recibe el metodo "listarPersona" mediante el 
                 * objeto "response" se almacene en este array
                 */
                arrayPersona : [],
                arrayRol : [],// Este arreglo se llenara en el metodo "selectRol"
                modal : 0,//Variable con la cual determinamos si estara abierto o cerrado la ventana modal
                tituloModal : '',
                tipoAccion : 0,//Nos indica si estamos registrarndo o actualizando
                errorPersona : 0,
                errorMostrarMsjPersona : [],
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
                criterio : 'nombre',//Indicamos cual sera el criterio de busqueda
                buscar : ''//Indicamos el texto de busqueda para iniciar el filtro del registro
            }
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

            }
        },
        /**
         * Axios, es una biblioteca que te permite realizar peticiones HTTP desde el navegador, ademas 
         * transforma las peticiones en JSON
         */
        methods : {
            /**
            * Usando el primer ejemplo de Axios con el metodo "get" y mediante ese verbo capturamos los datos que se
            * envia a traves de la direccion que en este caso es "/cliente"
            */
            listarPersona (page,buscar,criterio){
                let me=this;
                /**
                 * Lo que hacemos es crear la variable "url" que contiene la direccion mas el parametro "page","buscar" 
                 * y "criterio" por medio del verbo "get" y le asignamos el valor que recibe a traves del metodo
                 */
                var url=this.ruta +'/user?page=' + page + '&buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    /**
                     * Se crea una variable llamada "me" y esto lo que hace es guardar en el arrayPersona los datos 
                     * por medio del objeto "response"
                     */
                    var respuesta= response.data;
                    /**
                     * Se presentaba un error a la hora de mostrar la data ya que antes se le estaba asignando al 
                     * arreglo "arrayPersona" respuesta.personas.data lo cual no trae ningun registro
                     * Se cambio por respuesta.proveedores.data, esto se nota cuando lo revisamos por console
                     * y nos muestras como van viniendo los datos
                     */
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            /**
             * Con esto mediante axios hacemos referencia a la ruta que llama la funcion "selectRol" de nuestro 
             * controlador y devuelve una lista de todos los roles activos, la capturamos y la guardamos en el 
             * arreglo arrayRol
             */
            selectRol(){
                let me=this;
                var url=this.ruta + '/rol/selectRol';
                axios.get(url).then(function (response) {
                    /**
                     * Se crea una variable llamada "me" y esto lo que hace es guardar en el arrayPersona los datos 
                     * por medio del objeto "response"
                     */
                    //console.log(response);
                    var respuesta= response.data;
                    /**
                    *¿ Por que es "respuesta.roles" ?
                    *Porque en nuestro controllador RolController de nuestra funcion "selectRol" estamos retornando
                    *el arreglo "roles"
                    */
                    me.arrayRol = respuesta.roles;
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
                me.listarPersona(page,buscar,criterio);
            },
            /**
             * En este metodo usamos axios pero con verbo "post" y en este caso vamos a enviar dos parametros
             * 1. la ruta que en este caso seria "/categoria/registrar" y este hace referencia a nuestro metodo "store" de 
             * nuestro controlador de categoria
             * 2. Vamos enviar los valores que va recibir el controlador en este caso vamos a enviar el "nombre" y la
             * "descripcion"
             */
            registrarPersona(){
                /**
                 * Con esto validamos que no se presente un error
                 * Si el metodo devuelve un 1 significa que hay un error y se sale del metodo por lo que no permite guardar
                 */
                if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.post(this.ruta +'/user/registrar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'idrol' : this.idrol,
                    'usuario': this.usuario,
                    'password': this.password

                }).then(function (response) {
                    me.cerrarModal();//Si todo se cumple y no hay error, llamamos al metodo cerrar modal
                    /**
                     * Despues de registar inicializamos el metodo "listarCategoria" de esta manera que cuando
                     * terminemos un registro en el primer parametro que es "1" nos mande a la primera pagina
                     * El segundo parametro de buscar sea vacio
                     * Y el tercero que el criterio sea por el nombre
                     */
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                });
            },
            /**
             * Similar al metodo registrar persona salvo que ahora usaremos el verbo "put" y el primer parametro tendra
             * la ruta que hace referencia al controlador de persona "personaController" que tiene como accion "update"
             * Tambien vamos a enviar para este caso el nombre, la descripcion y el "id" para indicar cual sera el "id"
             * del registro que quiero modificar 
             */
            actualizarPersona(){
               if (this.validarPersona()){
                    return;
                }
                
                let me = this;

                axios.put(this.ruta +'/user/actualizar',{
                    'nombre': this.nombre,
                    'tipo_documento': this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'direccion' : this.direccion,
                    'telefono' : this.telefono,
                    'email' : this.email,
                    'idrol' : this.idrol,
                    'usuario': this.usuario,
                    'password': this.password,
                    'id': this.persona_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarPersona(1,'','nombre');
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.nombre) this.errorMostrarMsjPersona.push("El nombre de la pesona no puede estar vacío.");
                if (!this.usuario) this.errorMostrarMsjPersona.push("El nombre de usuario no puede estar vacío.");
                if (!this.password) this.errorMostrarMsjPersona.push("La password del usuario no puede estar vacía.");
                if (this.idrol==0) this.errorMostrarMsjPersona.push("Seleccione una Role.");
                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            /**
             * Con este metodo indicamos que la variable modal sera 0 y se cerrara la ventana modal ademas de inicializar
             * los valores
             */
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                this.nombre='';
                this.tipo_documento='CEDULA';
                this.num_documento='';
                this.direccion='';
                this.telefono='';
                this.email='';
                this.usuario='';
                this.password='';
                this.idrol=0;
                this.errorPersona=0;
            },
            /**
             * Este metodo contiene 3 parametros
             * 1.El modelo que en este caso sera persona
             * 2.La accion que tendra dos posibles acciones "registrar" o "actualizar"
             * 3.El objeto de esa fila de la tabla de persona de la tabla de la base de datos
             */
            abrirModal(modelo, accion, data = []){
                /**
                 * Se llama el metodo "selectRol" para mostrar la lista de roles despues que se abra la ventana modal
                 */
                this.selectRol();
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;//Con esto indicamos que se debe mostrar la ventana modal
                                this.tituloModal = 'Registrar Usuario';
                                this.nombre= '';
                                this.tipo_documento='CEDULA';
                                this.num_documento='';
                                this.direccion='';
                                this.telefono='';
                                this.email='';
                                this.usuario='';
                                this.password='';
                                this.idrol=0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                //console.log(data);
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;
                                /**
                                 * Esto es para obtener el id de la persona que quiero actualizar
                                 */
                                this.persona_id=data['id'];
                                /**
                                 * Ahora en la variable "nombre" debemos guardar el "nombre" del objeto que seleccion
                                 * y lo hacemos de la siguiente manera "this.nombre = data['nombre']"
                                 * Lo mismo pasa con la descripcion
                                 */
                                this.nombre = data['nombre'];
                                this.tipo_documento = data['tipo_documento'];
                                this.num_documento = data['num_documento'];
                                this.direccion = data['direccion'];
                                this.telefono = data['telefono'];
                                this.email = data['email'];
                                this.usuario = data['usuario'];
                                this.password=data['password'];
                                this.idrol=data['idrol'];
                                break;
                            }
                        }
                    }
                }
            },
            desactivarUsuario(id){
               swal({
                title: 'Esta seguro de desactivar este usuario?',
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

                    axios.put(this.ruta +'/user/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1,'','nombre');
                        swal(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
            activarUsuario(id){
               swal({
                title: 'Esta seguro de activar este usuario?',
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

                    axios.put(this.ruta +'/user/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(1,'','nombre');
                        swal(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
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
        * Le enviaremos al metodo "listarCategoria" los valores que tenga la propiedad data en ese momento
        */
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio);
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
</style>
