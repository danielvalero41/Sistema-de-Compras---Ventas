<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Siguiendo la convencion de laravel llamamos a la funcion "shwoLoginForm" aunque podemos tambien colocar
     * cualquier nombre
     */
    public function showLoginForm(){
        /**
        * Lo que hacemos es retorna la vista que se encuentra en la carpeta "auth" y el archivo se llama
        * login
        */
        return view('auth.login');
    }

    /**
    * En esta funcion lo que hacemos es verificar las credenciales del usuario para poder ingresar al sistema
    */
    public function login(Request $request){
        /**
        * Con esta validamos la peticion del inicio de sesion del usuario
        * Dentro del metodo "validate" le vamos a enviar dos parametros
        * El primero sera el objeto "$request" y el segundo un arreglo
        */
        $this->validateLogin($request);        

        /**
         * Hacemo esta condicion para comprobar las credenciales del usuario
         * Y para esto usamos el modelo "Auth" para usar sus metodos, en este caso usamos el metodo
         * "attempt" y dentro de ella le vamos a pasar un arreglo que son las variables que queremos comprobar
         * y que la condicion sea igual a 1, osea que el usuario este activo para acceder al sistema
         */
        if (Auth::attempt(['usuario' => $request->usuario,'password' => $request->password,'condicion'=>1])){
            /**
             * Si se cumple la condicion vamos a redireccionar a la ruta main
             */
            return redirect()->route('main');
        }

        /**
        * Sino cumple la condicion lo que hacemos es regresar otra vez a la pagina login
        * Pero con el metodo "withErrors" esta esperando un parametro este necesita el identificador
        * de la plantilla donde vamos a mostrar el error,
        * hacemos el llamado el metodo "trans" y dentro de el mostrara el mensaje de error pero este
        * mostrara el mensaje en ingles y para eso debemos a "resoucer>lang>en>auth.php" y en la seccion
        * "failed" podemos traducir el mensaje
        */
        return back()
        ->withErrors(['usuario' => trans('auth.failed')])
        ->withInput(request(['usuario']));

    }

    protected function validateLogin(Request $request){
            /**
            * En este arreglo vamos a validar los valores que son el "usuario" y el "password"
            * lo que hacemos es que sea de campo obligatorio (required) y de tipo "string"
            */
        $this->validate($request,[
            'usuario' => 'required|string',
            'password' => 'required|string'
        ]);

    }

    /**
    * Metodo que nos permite el cierre de sesion de un usuario
    */
    public function logout(Request $request){
        /**
        * Llamamos en este caso con la clase "Auth" el metodo logout()
        */
        Auth::logout();
        /**
         * Despues por medio del objeto "request" llamamos al metodo session() y luego al metodo invalidated()
         */
        $request->session()->invalidate();
        /**
         * Y para finalizar retornamos a la ruta principal que en esta nos llevara a la pagina principal
         * para acceder de nuevo al sistema
         */
        return redirect('/');
    }
}
