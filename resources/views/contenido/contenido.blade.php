    <!--Aqui vamos a extenderla a la plantilla principal-->
    @extends('principal')
    <!--Guardamos una seccion de informacion y la llamamoss en yield a traves del parametro "contenido"-->
    @section('contenido')

    <!--Con esto vamos a asignarle los componentes que van a tener acceso segun su rol
Por ejemplo el administrador tendra acceso a todos los componentes-->

    @if(Auth::check())
    <!--Si el usuario autenticado tiene el idrol 1 significa que es un Administrador-->
            @if (Auth::user()->idrol == 1)
            <!--En esta seccion decimos que si la variable "menu" de la propiedad "data" es igual
            a 0, entre en este componente que entrara a la etiqueta "example-component" que con-
            tiene el menu principal-->

            <!--NOTA:Vamos a asignarle dentro de cada menu la seccion que corresponde como por ejemplo en el menu 0
            hace referencia al escritorio con lo cual dejaremos solo el texto-->

            <!--Mas adelante debemos crear el componente "escritorio" mientras tanto dejamos solamente el texto
            con la palabra "Escritorio"-->
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>

            <template v-if="menu==1">
                <categoria :ruta="ruta"></categoria>
            </template>

            <template v-if="menu==2">
                <articulo :ruta="ruta"></articulo>
            </template>

            <template v-if="menu==3">
                <ingreso :ruta="ruta"></ingreso>
            </template>

            <template v-if="menu==4">
                <proveedor :ruta="ruta"></proveedor>
            </template>

            <template v-if="menu==5">
                <venta :ruta="ruta"></venta>
            </template>

            <template v-if="menu==6">
                <cliente :ruta="ruta"></cliente>
            </template>

            <template v-if="menu==7">
                <user :ruta="ruta"></user>
            </template>

            <template v-if="menu==8">
                <rol :ruta="ruta"></rol>
            </template>

            <template v-if="menu==9">
                <consultaingreso :ruta="ruta"></consultaingreso>
            </template>

            <template v-if="menu==10">
                <consultaventa :ruta="ruta"></consultaventa>
            </template>

            <template v-if="menu==11">
                <!--<prueba :ruta="ruta"></prueba>-->
            </template>

            <template v-if="menu==12">
                <!--<pruebavista></pruebavista>-->
            </template>
            <!--Si el usuario autenticado tiene el idrol 2 significa que es un Vendedor-->
            @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>

            <template v-if="menu==5">
            <venta :ruta="ruta"></venta>
            </template>

            <template v-if="menu==6">
                <cliente :ruta="ruta"></cliente>
            </template>
            <template v-if="menu==10">
                <consultaventa :ruta="ruta"></consultaventa>
            </template>

            <template v-if="menu==11">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==12">
                <h1>Acerca de</h1>
            </template>
            <!--Si el usuario autenticado tiene el idrol 1 significa que es un Almacenero-->
            @elseif (Auth::user()->idrol == 3)
            <template v-if="menu==0">
                <dashboard :ruta="ruta"></dashboard>
            </template>
            
            <template v-if="menu==1">
                <categoria :ruta="ruta"></categoria>
            </template>

            <template v-if="menu==2">
                <articulo :ruta="ruta"></articulo>
            </template>

            <template v-if="menu==3">
                <ingreso :ruta="ruta"></ingreso>
            </template>

            <template v-if="menu==4">
                <proveedor :ruta="ruta"></proveedor>
            </template>
            <template v-if="menu==9">
            <consultaingreso :ruta="ruta"></consultaingreso>
            </template>
            <template v-if="menu==11">
                <h1>Ayuda</h1>
            </template>

            <template v-if="menu==12">
                <h1>Acerca de</h1>
            </template>
            @else

            @endif

    @endif
       
        
    @endsection