<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use DB;
use App\User;
use App\Articulo;
use Carbon\Carbon;
use Illuminate\Support\Facades\Notification;
use App\Notifications\VencimientoNotification;
class VencimientoListener
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
        $maximo_dias=DB::table('articulo as a')
                    ->max('a.alerta_dias');
        $fecha_actual = date('Y-m-d');
        //$fecha_actual = "2022-02-01";
        $fecha = date('Y-m-d',strtotime($fecha_actual."+ ".$maximo_dias." days"));
        
        $detalles=DB::table('detalle_ingreso as d')
        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
        ->join('ingreso as i','d.idingreso','=','i.idingreso')
        ->select('a.nombre as articulo','a.stock','d.precio_compra','d.precio_venta','d.fecha_vencimiento','i.idingreso','d.cantidad','a.idarticulo')
        ->where('d.fecha_vencimiento','>=',$fecha_actual)
        ->where('d.fecha_vencimiento','<=',$fecha)
        ->where('a.stock','>=','1')
        ->orderBy('d.fecha_vencimiento','asc')
        ->groupBy('a.nombre','a.stock','d.precio_compra','d.precio_venta','d.fecha_vencimiento','i.idingreso','d.cantidad','a.idarticulo')
        ->get();

        $array = [];
        $i=0;
        //$fecha_actual="2022-02-01";
        $notificacion=DB::table('notifications as n')
                        ->where('n.created_at','>=',$fecha_actual)
                        ->where('n.type','=','App\Notifications\VencimientoNotification')
                        ->get();

                        
        $menos_un_dia = 1;
        $fecha_ayer = date('Y-m-d',strtotime($fecha_actual."- ".$menos_un_dia." days"));
        $mas_un_dia = 1;
        $fecha_manana = date('Y-m-d',strtotime($fecha_ayer."+ ".$mas_un_dia." days"));
        //dd($fecha_manana);
        $notificacion_mas_ayer=DB::table('notifications as n')
                        ->where('n.created_at','>=',$fecha_ayer)
                        ->where('n.created_at','<=',$fecha_manana)
                        ->where('n.type','=','App\Notifications\VencimientoNotification')
                        ->get();
        //dd(count($notificacion_mas_ayer));

        /* if( count($notificacion) == 0 ) {

            foreach ($detalles as $de) {
                $articulo=Articulo::findOrFail($de->idarticulo);
                //$fecha = date('Y-m-d',strtotime($fecha_actual."+ ".$articulo->alerta_dias." days"));
                $currentDate = Carbon::createFromFormat('Y-m-d', $fecha_actual);
                $shippingDate = Carbon::createFromFormat('Y-m-d', $de->fecha_vencimiento);
                $diferencia_en_dias = $currentDate->diffInDays($shippingDate);
                if($fecha_actual <= $de->fecha_vencimiento && $diferencia_en_dias<=$articulo->alerta_dias) {
                    $array[$i] = "si vence en ".$diferencia_en_dias." dias";
                    $logeado = auth()->user()->id;
                    User::all()
                    
                    ->each(function(User $user) use ($articulo,$de,$diferencia_en_dias){
                    Notification::send($user, new VencimientoNotification($articulo,$de,$diferencia_en_dias));
                    });
                }
                else {
                    $array[$i] = "no";
                }
                $i++;
            }
        } */
        
        
        if( count($notificacion) == 0 ) {

            if (count($notificacion_mas_ayer)==0) {
                $menos_uno =1;
                $fecha_ayer1 = date('Y-m-d',strtotime($fecha_actual."- ".$menos_uno." days"));

                $detalles11=DB::table('detalle_ingreso as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('ingreso as i','d.idingreso','=','i.idingreso')
                ->select('a.nombre as articulo','a.stock','d.precio_compra','d.precio_venta','d.fecha_vencimiento','i.idingreso','d.cantidad','a.idarticulo')
                ->where('d.fecha_vencimiento','>=',$fecha_ayer1)
                ->where('d.fecha_vencimiento','<=',$fecha)
                ->where('a.stock','>=','1')
                ->orderBy('d.fecha_vencimiento','asc')
                ->groupBy('a.nombre','a.stock','d.precio_compra','d.precio_venta','d.fecha_vencimiento','i.idingreso','d.cantidad','a.idarticulo')
                ->get();
                foreach ($detalles11 as $de) {
                    $articulo=Articulo::findOrFail($de->idarticulo);
                    $fecha11 = date('Y-m-d',strtotime($fecha_ayer1."+ ".$articulo->alerta_dias." days"));
                    if($fecha11 == $de->fecha_vencimiento) {
                        $logeado = auth()->user()->id;
                        User::all()
                        ->each(function(User $user) use ($articulo,$de){
                        Notification::send($user, new VencimientoNotification($articulo,$de));
                        });
                    }
                }
                foreach ($detalles as $de) {
                    $articulo=Articulo::findOrFail($de->idarticulo);
                    $fecha = date('Y-m-d',strtotime($fecha_actual."+ ".$articulo->alerta_dias." days"));
                    if($fecha == $de->fecha_vencimiento) {
                        $logeado = auth()->user()->id;
                        User::all()
                        ->each(function(User $user) use ($articulo,$de){
                        Notification::send($user, new VencimientoNotification($articulo,$de));
                        });
                    }
                }

            }
            else {
                foreach ($detalles as $de) {
                    $articulo=Articulo::findOrFail($de->idarticulo);
                    $fecha = date('Y-m-d',strtotime($fecha_actual."+ ".$articulo->alerta_dias." days"));
                    if($fecha == $de->fecha_vencimiento) {
                        $logeado = auth()->user()->id;
                        User::all()
                        ->each(function(User $user) use ($articulo,$de){
                        Notification::send($user, new VencimientoNotification($articulo,$de));
                        });
                    }
                }
            }
            
        }
        /*  */
        /* if( count($notificacion) == 0 ) {
                        
            foreach ($detalles as $de) {
                $articulo=Articulo::findOrFail($de->idarticulo);
                $fecha = date('Y-m-d',strtotime($fecha_actual."+ ".$articulo->alerta_dias." days"));
                if($fecha == $de->fecha_vencimiento) {
                    $array[$i] = "si";
                    $logeado = auth()->user()->id;
                    User::all()
                    
                    ->each(function(User $user) use ($articulo,$de){
                    Notification::send($user, new VencimientoNotification($articulo,$de));
                    });
                }
                else {
                    $array[$i] = "no";
                }
                $i++;
            }
        } */

        /*  */
    }
}
