<template>
    <li class="nav-item d-md-down-none">
        <a class="nav-link" href="#" data-toggle="dropdown">
            <i class="icon-bell"></i>
            <!--Aqui vamos a mostrar la cantidad de notificaciones
            o la cantidad de elementos que tiene el arreglo
            notifications-->
            <span class="badge badge-pill badge-danger">{{notifications.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
                <strong>Notificaciones</strong>
            </div>
            <div v-if="notifications.length">
                <!--Con el metodo listar de propiedad
                computada podemos recorrer todo el
                arrary que nos retorna esta funcion y
                ya no sera necesario llamar los valores
                desde data.datos-->
                <li v-for="item in listar" :key="item.id">
                <a class="dropdown-item" href="#">
                    <!--El item.data llega como una cadena y esto
                    debemos convertirlo en objeto js para eso
                    usamos JSON.parse
                    
                    Ya despues tenerlo como objeto ahora lo que hacemos
                    es acceder a sus datos y para eso empezamos desde
                    datos.ingresos.msj
                    
                    Recordemos que este arreglo de datos esta declarado
                    en el controlador IngresoController en la funcion
                    store-->
                    <i class="fa fa-envelope-o"></i> {{item.ingresos.msj}}
                    <span class="badge badge-success">{{item.ingresos.numero}}</span>
                </a>
                <a class="dropdown-item" href="#">
                    <i class="fa fa-tasks"></i> {{item.ventas.msj}}
                    <span class="badge badge-danger">{{item.ventas.numero}}</span>
                </a>
                </li>
            </div>
            <div v-else>
                <a><span>No tiene notificaciones</span></a>
            </div>
        </div>
    </li>
</template>

<script>
export default {
    /**
     * Con esto estamos declaramos todos los props
     */
    props: ['notifications'],
    data() {
        return {
            arrayNotificaciones: []
        }
    
    },
    computed: {
        /**
         * Lo que queremos ahora es mostrar solo
         * la ultima notificacion y para eso
         * tomamos el indice 0 de "notifications"
         * recordemos que el props: notifications
         * se toma como un arreglo mas
         */
        listar: function(){
            /**
             * Con esto en la pestaña vue comprobamos 
             * que estamos obteniendo el ultimo registro
             * de nuestro arreglo notifications
             */
            //return this.notifications[0];

            /**
             * Ahora lo que hacemos es guardar el arreglo
             * de notifications en el arreglo arraynotificaciones
             * mediante la clase Object y el metodo values
             */
            this.arrayNotificaciones = Object.values(this.notifications[0]);

            /**
             * Y ahora lo que hacemos es retorna todo el arreglo
             */
            if(this.notifications == ''){
                return this.arrayNotificaciones = [];
            }else{
                /**
                 * Capturo la ultima notificacion agregada
                 */
                this.arrayNotificaciones = Object.values(this.notifications[0]);
                if(this.arrayNotificaciones.length > 3){
                    /**
                     * Si el tamaño es > 3 Es cuando las notificaciones son
                     * obtenidas desde el mismo servidor por medio de una
                     * consulta axios
                     */
                    return Object.values(this.arrayNotificaciones[4]);
                }else{
                    /**
                     * Si el tamaño es < 3 Es cuando las notificaciones son
                     * obtenidas desde Laravel echo
                     */
                    return Object.values(this.arrayNotificaciones[0]);
                }
            }
        }
    },
}
</script>