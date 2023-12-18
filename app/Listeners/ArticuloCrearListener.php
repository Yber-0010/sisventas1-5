<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\User;
use App\Notifications\ArticuloNotificacion;
class ArticuloCrearListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        //dd($event->articulo->idarticulo);
        $logeado = auth()->user()->id;
        User::all()
            ->except($logeado)
            ->each(function(User $user) use ($event){
                Notification::send($user, new ArticuloNotificacion($event->articulo));
            });
        

    }
}
