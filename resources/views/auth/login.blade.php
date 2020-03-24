<!--Extendemos hacia la carpeta "auth" al archivo "contenido.blade.php"-->
@extends('auth.contenido')

@section('login')
<div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
          <!--Creamos un form y dentro de el creamos la clase "form-horizontal" y la clase "was-validated" colocamos el metodo POST
            y hacemos que la action en la que vamos enviar va hacer la ruta "login" y en este caso le vamos 
            a enviar la ruta dentro para indicar que es codigo Laravel y dentro de ella colocamos
            " route('login') "-->
          <form class="form-horizontal was-validated" method="POST" action="{{ route('login')}}">
          <!--Usamos CSRF para proteger la aplicacion de falsificacion-->
          {{ csrf_field() }}
              <div class="card-body">
              <h1>Acceder</h1>
              <p class="text-muted">Control de acceso al sistema</p>
              <!--Si el usuario no coincide se le va agregar a todo este div la clase 'is-invalid' de lo contrario no se le va 
              agregar nada a esta clase-->
              <div class="form-group mb-3{{$errors->has('usuario' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input type="text" value="{{old('usuario')}}" name="usuario" id="usuario" class="form-control" placeholder="Usuario">
                <!--Ahora lo que hacemos es mostrar el error de cuando el usuario es invalido-->                
                {!!$errors->first('usuario','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="form-group mb-4{{$errors->has('password' ? 'is-invalid' : '')}}">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                {!!$errors->first('password','<span class="invalid-feedback">:message</span>')!!}
              </div>
              <div class="row">
                <div class="col-6">
                  <button type="submit" class="btn btn-primary px-4">Acceder</button>
                </div>
              </div>
            </div>
          </form>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none " style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>Sistema de Compras-Ventas</h2>
                <p class="mt-5">Sistema generalizado para trabajar en cualquier ambiente de trabajo, adaptandose a las necesidades del cliente. </p>                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
@endsection
