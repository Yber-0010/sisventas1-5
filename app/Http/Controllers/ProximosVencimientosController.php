<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Ingreso;
use App\DetalleIngreso;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class ProximosVencimientosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $maximo_dias=DB::table('articulo as a')
                ->max('a.alerta_dias');
        
        $fecha=Carbon::now();
        $hoy = $fecha->format('y-m-d');

        $fecha_actual = date('y-m-d');
        $fecha = date('y-m-d',strtotime($fecha_actual."+ ".$maximo_dias." days"));
        
        //dd($fecha_actual." +".$maximo_dias."= ".$fecha);
        
        //dd(date("d-m-Y",strtotime($fecha_actual."+ 1 month")));
        //dd($maximo_dias);

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

        return view('porVencer.index',["detalles"=>$detalles]);
    }

}
