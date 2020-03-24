<template>

<main class="main">
    <!--Breadcrumb-->
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/">Escritorio</a></li>
    </ol>
    <div class="container-fluid">
        <div class="card compacto">
            <div class="card-header compacto text-center">
                <h4>Gráficos estadístico de los ingreso y ventas al mes</h4>
            </div>
            <div class="card-body compacto">
                <div class="row">
                    <div class="col-md-6">
                        <div class="card card-chart compacto">
                            <div class="card-header compacto text-center">
                                <h4>Ingresos</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <!--Con esta etiqueta
                                    canvas vamos a representar
                                    el grafico estadistico de 
                                    los ultimos meses de los
                                    ingresos-->
                                    <canvas id="ingresos">
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <p>Compra de los ultimos meses</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card card-chart compacto">
                            <div class="card-header compacto text-center">
                                <h4>Ventas</h4>
                            </div>
                            <div class="card-content">
                                <div class="ct-chart">
                                    <!--Con esta etiqueta
                                    canvas vamos a representar
                                    el grafico estadistico de 
                                    los ultimos meses de los
                                    ventas-->
                                    <canvas id="ventas">
                                    </canvas>
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <p>Ventas de los ultimos meses</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

</template>

<script>
export default {
    props: ['ruta'],
    data(){
        return{
            varIngreso:null,
            charIngreso:null,
            ingresos:[],
            varTotalIngreso:[],
            varMesIngreso:[],

            varVenta:null,
            charVenta:null,
            ventas:[],
            varTotalVenta:[],
            varMesVenta:[]
        }
    },
    methods: {

        getIngresos(){
            let me = this;
            var url =this.ruta + '/dashboard';
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.ingresos = respuesta.ingresos;
                //cargamos los datos del chart
                me.loadIngresos();
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        getVentas(){
            let me = this;
            var url =this.ruta + '/dashboard';
            axios.get(url).then(function(response){
                var respuesta = response.data;
                me.ventas = respuesta.ventas;
                //cargamos los datos del chart
                me.loadVentas();
            })
            .catch(function (error) {
                console.log(error);
            });
        },

        loadIngresos(){
            let me = this;
            /*
             * El metodo "map" nos permite recorrer todo el
             * arreglo
             */
            me.ingresos.map(function (x) {
                switch(x.mes){
                    case 1:
                        me.varMesIngreso.push('Enero');
                        break;
                    case 2:
                        me.varMesIngreso.push('Febrero');
                        break;
                    case 3:
                        me.varMesIngreso.push('Marzo');
                        break;
                    case 4:
                        me.varMesIngreso.push('Abril');
                        break;
                    case 5:
                        me.varMesIngreso.push('Mayo');
                        break;
                    case 6:
                        me.varMesIngreso.push('Junio');
                        break;
                    case 7:
                        me.varMesIngreso.push('Julio');
                        break;
                    case 8:
                        me.varMesIngreso.push('Agosto');
                        break;
                    case 9:
                        me.varMesIngreso.push('Septiembre');
                        break;
                    case 10:
                        me.varMesIngreso.push('Obtubre');
                        break;
                    case 11:
                        me.varMesIngreso.push('Noviembre');
                        break;
                    case 12:
                        me.varMesIngreso.push('Diciembre');
                        break;
                }
                me.varTotalIngreso.push(x.total);
            });
            /**
             * Con esto establecemos el lugar donde mostraremos
             * el grafico de ingresos
             */
            me.varIngreso = document.getElementById('ingresos').getContext('2d');

            /**
             * Copiamos el codigo de ejemplo de la pagina de
             * chart js "https://www.chartjs.org/docs/latest/"
             */
            
             me.charIngreso = new Chart(me.varIngreso, {
                type: 'bar',
                data: {
                    /**
                     * Aqui vamos a mostrar las etiquetas que tiene nuestro 
                     * arreglo para el grafico y todo esta en el arreglo
                     * varMesIngreso
                     */
                    labels: me.varMesIngreso,
                    datasets: [{
                        label: 'Ingresos',
                        data: me.varTotalIngreso,
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',                            
                        borderColor: 'rgba(255, 99, 132, 0.2)',                            
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        },

        loadVentas(){
            let me = this;
            /*
             * El metodo "map" nos permite recorrer todo el
             * arreglo
             */
            me.ventas.map(function (x) {
                switch(x.mes){
                    case 1:
                        me.varMesVenta.push('Enero');
                        break;
                    case 2:
                        me.varMesVenta.push('Febrero');
                        break;
                    case 3:
                        me.varMesVenta.push('Marzo');
                        break;
                    case 4:
                        me.varMesVenta.push('Abril');
                        break;
                    case 5:
                        me.varMesVenta.push('Mayo');
                        break;
                    case 6:
                        me.varMesVenta.push('Junio');
                        break;
                    case 7:
                        me.varMesVenta.push('Julio');
                        break;
                    case 8:
                        me.varMesVenta.push('Agosto');
                        break;
                    case 9:
                        me.varMesVenta.push('Septiembre');
                        break;
                    case 10:
                        me.varMesVenta.push('Obtubre');
                        break;
                    case 11:
                        me.varMesVenta.push('Noviembre');
                        break;
                    case 12:
                        me.varMesVenta.push('Diciembre');
                        break;
                }
                me.varTotalVenta.push(x.total);
            });
            /**
             * Con esto establecemos el lugar donde mostraremos
             * el grafico de ventas
             */
            me.varVenta = document.getElementById('ventas').getContext('2d');

            /**
             * Copiamos el codigo de ejemplo de la pagina de
             * chart js "https://www.chartjs.org/docs/latest/"
             */
             me.charVenta = new Chart(me.varVenta, {
                type: 'bar',
                data: {
                    /**
                     * Aqui vamos a mostrar las etiquetas que tiene nuestro 
                     * arreglo para el grafico y todo esta en el arreglo
                     * varMesVenta
                     */
                    labels: me.varMesVenta,
                    datasets: [{
                        label: 'Ventas',
                        data: me.varTotalVenta,
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',                            
                        borderColor: 'rgba(54, 162, 235, 0.2)',                                                        
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
        }

    },
    mounted() {
        this.getIngresos();
        this.getVentas();
    },
}
</script>
<style>
    .compacto{
        border-radius: 10px;
    }
</style>