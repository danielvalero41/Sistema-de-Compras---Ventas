<template>
<main class="main">
    <div class="container-fluid">
        <div class="card compacto">
            <div class="card-header compacto">
                <h4>Pruebas de formulario</h4>
            </div>
            <div class="card-body compacto">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><strong>Numero de cedula:</strong></label>
                            <input type="email" class="form-control compacto" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Ingrese numero de cedula">                            
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1"><strong>N° Factura:</strong></label>
                            <input type="text" readonly class="form-control compacto" style="background:white;" placeholder="5">
                        </div>
                    </div>                
                    
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><strong>Nombre del cliente:</strong></label>
                            <input type="email" class="form-control compacto" style="background:white;" readonly placeholder="Carlos Valero">                            
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1"><strong>Nombre del vendedor</strong></label>
                            <input type="text" class="form-control compacto" style="background:white;" readonly placeholder="Jose Rafael">
                        </div>
                    </div>           
                    
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputEmail1"><strong>Direccion:</strong></label>
                            <input type="email" class="form-control compacto" style="background:white;" readonly placeholder="Av. Las Carpas">                            
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label for="exampleInputPassword1"><strong>Fecha-Hora</strong></label>
                            <input type="text" class="form-control compacto" style="background:white;" readonly placeholder="29/01/2020 11:23 AM">
                        </div>
                    </div>                                                        
                </div>
                <div class="form-group border compacto row">
                            <div class="col-md-4">
                                <div class="form-group">                                    
                                    <label for="">Articulo <span style="color:red;" v-show="idarticulo==0">(*Seleccione)</span></label>
                                    <div class="form-inline">
                                        
                                        <input type="text" class="form-control" v-model="codigo" @keyup.enter="buscarArticulo()" placeholder="Ingrese articulo">
                                        <button @click="abrirModal()" class="btn btn-primary">...</button>
                                        <!--Este input solo sera de lectura con readonly-->
                                        <input type="text" readonly class="form-control" v-model="articulo">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for=""><span style="color:red;" v-show="precio==0">(*Ingrese)</span>Precio</label>                                    
                                    <input type="number" min="0"  step="any" class="form-control" v-model="precio">
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for=""><span style="color:red;" v-show="cantidad==0">(*Ingrese)</span>Cantidad</label>
                                    
                                    <input type="number" min="0"  class="form-control" v-model="cantidad">
                                </div>    
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                    <label for="">Descuento</label>
                                    
                                    <input type="number" min="0"  class="form-control" v-model="descuento">
                                </div>    
                            </div>
                            <div class="col-md-2">
                                <div class="form-group">
                                   <button @click="agregarDetalle()" class="btn btn-success form-control btnagregar">
                                       <i class="icon-plus"></i>
                                   </button>
                                </div>
                            </div>
                </div>
                <div class="form-group border compacto row">
                            <div class="table-responsive col-md-12">
                                <table class="table table-hover table-sm">
                                    
                                    <thead>
                                        <tr>
                                            <th class="text-center">Opciones</th>
                                            <th class="text-center">Articulo</th>
                                            <th class="text-center">Precio</th>
                                            <th class="text-center">Cantidad</th>
                                            <th class="text-center">Descuento</th>
                                            <th class="text-center">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <!--Vamos a mostar la tabla de detalles de los 
                                    articulos si se encuentra uno en el arreglo 
                                    arrayDetalle-->
                                    
                                    <!--Sino hay articulos en el arreglo mostramos
                                    el siguiente mensaje y con la propiedad colspan
                                    damos la misma dimension de 5 columnas que tiene
                                    la tabla-->
                                    <tbody>
                                        <tr>
                                            <td colspan="6">
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
                                <button type="button" class="btn btn-primary compacto" @click="registrarVenta()">Registrar Venta</button>
                            </div>
                        </div>
            </div>
        </div>
    </div>
</main>
</template>
