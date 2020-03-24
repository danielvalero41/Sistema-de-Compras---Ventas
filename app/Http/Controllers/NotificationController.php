<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notification;
use Auth;

class NotificationController extends Controller
{
    public function get()
    {
        //return Notification::all();
        /**
         * Vamos a crear una variable para que solo se
         * muestre las notificaciones de ese dia en especifico
         */
        $unreadNotifications = Auth::user()->unreadNotifications;        
        
        /**
         * Lo que hacemos es que si la notificion no es de la
         * fecha actual la vamos a tomar como leida
         */
        foreach($unreadNotifications as $notification){
            $fechaActual = date('Y-m-d');
            if($fechaActual != $notification->created_at->toDateString()){
                $notification->markAsRead();
            }
        }

        return Auth::user()->unreadNotifications;
    }
}
