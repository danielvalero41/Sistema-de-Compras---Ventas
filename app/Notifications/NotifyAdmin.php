<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NotifyAdmin extends Notification
{
    use Queueable;

    public $GlobalDatos;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Array $datos)
    {
        /**
         * Vamos a asignar el arreglo del constructor
         * en la variable "globaldatos" esto lo hacemos
         * para poder utilizar la variable global para 
         * enviar informacion a los canales seleccionados
         */

         $this->GlobalDatos = $datos;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */

     /**
      * Este metodo determina en que canales se entregaran
      * la notificacion
      */
    public function via($notifiable)
    {
        /**
         * Declaramos por cual canal se va trabajar las notificaciones
         * Si tenemos internet puedo habilitar el broadcast
         * Caso contrario eliminarlo para que no genere error al
         * registrar algun producto
         */
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'datos' => $this->GlobalDatos
        ];
    }

    public function toBroadcast($notifiable)
    {
        return [
            'data' => [
                'datos' => $this->GlobalDatos
            ]
            
        ];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
