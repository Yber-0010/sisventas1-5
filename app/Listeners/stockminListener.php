<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use App\User;
use App\Articulo;
use App\Notifications\stockminNotification;
class stockminListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        
        //dd($event->articulo);
        /* $users = User::all();
        Articulo::where([['estado','=','Activo'],['idarticulo','=',$event->articulo->idarticulo]])->get()->each(function($articulo) use ($users) {
            if($articulo->stock<=$articulo->stock_min){
            auth()->user()->notify(new stockminNotification($articulo));
            Notification::send($users, new stockminNotification($articulo));    
            }
        });
 */
        if($event->articulo->stock<=$event->articulo->stock_min){
            $logeado = auth()->user()->id;
            User::all()
            //->except($logeado)
            ->each(function(User $user) use ($event){
                Notification::send($user, new stockminNotification($event->articulo));
            });
        }
    }
}
