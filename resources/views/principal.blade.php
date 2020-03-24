<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Sistema Ventas Laravel Vue Js- IncanatoIT">
    <meta name="author" content="Incanatoit.com">
    <meta name="keyword" content="Sistema ventas Laravel Vue Js, Sistema compras Laravel Vue Js">
    <link rel="shortcut icon" href="img/favicon.png">
    <title>Sistema de Compras - Ventas</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--Si se ha autenticado un usuario enviamos el id de ese
    usuario sino enviamos la cadena vacia-->
    <meta name="userId" content="{{ Auth::check() ? Auth::user()->id : ''}}">
    <!-- Icons -->
    <link href="css/plantilla.css" rel="stylesheet">
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js">
</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed aside-menu-hidden">
    <div id="app">
    <header class="app-header navbar">
        <button class="navbar-toggler mobile-sidebar-toggler d-lg-none mr-auto" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button">
          <span class="navbar-toggler-icon"></span>
        </button>
        <ul class="nav navbar-nav d-md-down-none">
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Escritorio</a>
            </li>
            <li class="nav-item px-3">
                <a class="nav-link" href="#">Configuraciones</a>
            </li>
        </ul>
        <ul class="nav navbar-nav ml-auto">
        <!--Estamos recibiendo mediante un "props" de js el arreglo
        "notifications" que este se encuentra en el archivo app.js-->
            <notification :notifications="notifications"></notification>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                    <!--<img src="img/avatars/6.jpg" class="img-avatar" alt="admin@bootstrapmaster.com">-->
                    <!--En este caso habia un nombre estatico con lo cual con codigo Laravel vamos a indicarle
                    el nombre del usuario que haya ingresado al sistema-->
                    <span class="d-md-down-none">{{Auth::user()->usuario}} </span>
                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Cuenta</strong>
                    </div>
                    <!--En este codigo indicaremos la ruta para cuando el usuario de click en Cerrar sesión
                    este se ubicara en la ruta 'logout' haciendo referencia al controlador "LoginController"
                    y a su funcion 'logout'-->
                    <!--Tambien vamos a agregar el evento "onclick" con el siguiente codigo javascript-->
                    <a class="dropdown-item" href="{{ route('logout') }}" 
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-lock"></i> Cerrar sesión</a>
                    <!--Creamos el formulario con el id "logout-form" que tiene la accion la ruta que hace la
                    referencia al controlador "LoginController", el metodo "POST" para enviar los datos del
                    usuario autenticado y agregamos el campo de codigo "style" para agregar un display:none;
                    para que no se muestre el formulario-->
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        {{ csrf_field() }}
                    </form>
                </div>
            </li>
        </ul>
    </header>

    <div class="app-body">
        <!--Esto es para saber si el usuario esta autenticado-->
        @if(Auth::check())
        <!--Si el usuario autenticado tiene el idrol 1 significa que es un Administrador-->
            @if (Auth::user()->idrol == 1)
                <!--Si es un administrador lo que haremos un include para llamar la plantilla
                "siderbaradministrador". Recordemos el que el include lo que nos trae es el 
                codigo de la plantilla a la cual le hacemos referencia-->
                @include('plantilla.sidebaradministrador')
            @elseif (Auth::user()->idrol == 2)
                <!--Si es un vendedor lo que haremos un include para llamar la plantilla
                "sidervendedor". Recordemos el que el include lo que nos trae es el 
                codigo de la plantilla a la cual le hacemos referencia-->
                @include('plantilla.sidebarvendedor')
            @elseif (Auth::user()->idrol == 3)
                <!--Si es un almacenero lo que haremos un include para llamar la plantilla
                "sideralmacenero". Recordemos el que el include lo que nos trae es el 
                codigo de la plantilla a la cual le hacemos referencia-->
                @include('plantilla.sidebaralmacenero')
            @else

            @endif

        @endif
        <!-- Contenido Principal -->
        <!--Aqui insertamos la seccion de informacion que tenemos a traves del parametro "contenido"-->
        @yield('contenido')
        <!-- /Fin del contenido principal -->
    </div>   
    </div>
    <footer class="app-footer">        
            <span><a href="#">DanielValero</a> &copy; 2020</span>
        <span class="ml-auto">Desarrollado por <a href="#">DanielValero</a></span>
    </footer>
        
    <script src="js/app.js"></script>
    <script src="js/plantilla.js"></script>
</body>

</html>