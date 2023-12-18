<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\FormRequests;

use Barryvdh\DomPDF\Facade as PDF;

use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Gate;
use App\Exports\CajaExport;
use App\Exports\CajaListaVentasExport;
use App\Exports\CajaListaArticulosExport;
use App\Exports\CajaListaIngresosExport;
use App\Exports\CajaListaIngresosArticulosExport;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CajaFormRequest;
use App\Caja;
use App\Tiene_i;
use App\Tiene_v;
use App\Venta;
use App\Ingreso;
use App\Articulo;
use DB;
use App\Events\VencimientoEvent;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class CajaController extends Controller
{
    
    

    public function __construct()
    {
       $this->middleware('auth');    
    }
    public function index(Request $request)
    {
        
        if($request)
        {
            $users=DB::table('users')
            ->select('id','name')
            ->get();

            $query=trim($request->get('searchText'));
            $nombre=$query;
            $caja=DB::table('caja as c')
            ->join('tiene_i as ti','c.idcaja','=','ti.idcaja')
            ->join('tiene_v as tv','c.idcaja','=','tv.idcaja')
            //->join('users as u','c.encargado','=','u.id')
            ->select('c.idcaja','c.fecha_apertura','c.fecha_cierre','c.encargado','c.inicio','c.cierre_real','c.ingreso','c.estado','c.encargado_nombre')
            ->where('c.fecha_apertura','LIKE','%'.$query.'%')
            ->orderBy('c.idcaja','desc')
            ->groupBy('c.idcaja','c.fecha_apertura','c.fecha_cierre','c.encargado','c.inicio','c.cierre_real','c.ingreso','c.estado','c.encargado_nombre') //la agrupacion era necesaria y tiene que ser especifica
            ->paginate(20);
            return view('caja.cajas.index',["caja"=>$caja,"searchText"=>$query,"nombre"=>$nombre,'users'=>$users]);
        }
    }
    public function create()
    {
        
        $mytime = Carbon::now('America/La_Paz');   

        return view('caja.cajas.create',[
            'mytime'=>$mytime
        ]);
    }
    public function store(CajaFormRequest $request)
    {
        try
        {
            DB::beginTransaction();
            $caja = new Caja;
            $caja->fecha_apertura=$request->get('fecha_apertura');
            $caja->encargado = auth()->user()->id;
            $caja->encargado_nombre = auth()->user()->name;
            $caja->inicio=$request->get('inicio');
            $caja->estado='Activo';
            $caja->fecha_cierre=$request->get('fecha_cierre');
            if ($caja->fecha_cierre=="") {
                $caja->fecha_cierre=null;
            }
            $caja->cierre_real=$request->get('cierre_real');

            /* aca viene el evento */
            /* DB::table('notifications')
                ->where('type','=','App\Notifications\VencimientoNotification')
                ->delete(); */
            $articulo = Articulo::get();
            event(new VencimientoEvent($articulo));
            /*  */

            $caja->save();
    
            $Tiene_ingreso = new Tiene_i;
            $Tiene_ingreso->idcaja=$caja->idcaja;
            $Tiene_ingreso->save();
            /*$Tiene_ingreso->idingreso=null;*/

            $Tiene_venta = new Tiene_v;
            $Tiene_venta->idcaja=$caja->idcaja;
            $Tiene_venta->save();
            /*$Tiene_venta->idventa=null;*/
            
            DB::commit();

        }catch(\Exception $e)
        {
            DB::rollback();
        }

        
        return Redirect::to('caja/cajas');
    }
    public function edit($id)
    {
        $caja=Caja::findOrFail($id);

        $encargado=DB::table('users')
        ->select('id','name')
        ->get();

        //// mostrando el contenido de ventas en create ////        
        if($caja->fecha_cierre!="")
        {
            $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where( 'fecha_hora','>=',$caja->fecha_apertura)//,'and','fecha_hora','<=',$caja->fecha_cierre)
            ->where( 'fecha_hora','<=',$caja->fecha_cierre)//
            ->orderBy('v.idventa','desc')
            ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta') //la agrupacion era necesaria y tiene que ser especifica
            ->get();
            $pedidos=DB::table('pedido as ped')
           ->select('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','ped.nombre_cliente','ped.celular_cliente','ped.tipo_comprobante','ped.serie_comprobante','ped.num_comprobante','ped.impuesto')
           ->where('ped.estado','=',"FINALIZADO")
           ->where("ped.fecha_hora_finalizado",">=",$caja->fecha_apertura)
           ->where("ped.fecha_hora_finalizado","<=",$caja->fecha_cierre)
           ->orwhere('ped.estado','=',"RECHAZADO")
           ->where("ped.fecha_hora_finalizado",">=",$caja->fecha_apertura)
           ->where("ped.fecha_hora_finalizado","<=",$caja->fecha_cierre)
           ->orderBy('ped.id','desc')
           ->groupBy('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','nombre_cliente','ped.celular_cliente','ped.tipo_comprobante','ped.serie_comprobante','ped.num_comprobante','ped.impuesto')
           ->get();
            
        }
        else{
            $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where( 'fecha_hora','>=',$caja->fecha_apertura)//,'and','fecha_hora','<=',$caja->fecha_cierre)
            ->orderBy('v.idventa','desc')
            ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta') //la agrupacion era necesaria y tiene que ser especifica
            ->get();
            $pedidos=DB::table('pedido as ped')
            ->select('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','ped.nombre_cliente','ped.celular_cliente','ped.tipo_comprobante','ped.serie_comprobante','ped.num_comprobante','ped.impuesto')
            ->where('ped.estado','=','ACTIVO')
            ->orwhere('ped.estado','=',"FINALIZADO")
            ->where("ped.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->orwhere('ped.estado','=',"RECHAZADO")
            ->where("ped.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->orderBy('ped.id','desc')
            ->groupBy('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','nombre_cliente','ped.celular_cliente','ped.tipo_comprobante','ped.serie_comprobante','ped.num_comprobante','ped.impuesto')
            ->get();
        };
        ///// fin de mostrando contenido de ventas en create ////

        //// mostrando el contenido de ingresos en create ////
        if($caja->fecha_cierre!="")
        {
            $ingresos=DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.total_venta','i.obserbacion')//DB::raw('sum(di.cantidad*precio_compra)as total'))
            ->where( 'fecha_hora','>=',$caja->fecha_apertura)
            ->where('fecha_hora','<=',$caja->fecha_cierre)
            ->orderBy('i.idingreso','desc')
            ->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.total_venta','i.obserbacion')
            ->get();
        }
        else
        {
            $ingresos=DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.total_venta','i.obserbacion')//DB::raw('sum(di.cantidad*precio_compra)as total'))
            ->where( 'fecha_hora','>=',$caja->fecha_apertura)
            ->orderBy('i.idingreso','desc')
            ->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.total_venta','i.obserbacion')
            ->get();
        };
        ///// fin de mostrando contenido de ingresos en create ////

        /// consultas SQL ventas ingresos ///
            if($caja->fecha_cierre!="")
            {
                // •	Suma total_ventas por (efectivo) //
                $efectivo_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Efectivo')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (efectivo) //
                // •	Suma total_ventas por (Nota de venta) //
                $nota_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Nota de venta) //
                // •	Suma total_ventas por (Con tarjeta) //
                $con_tarjeta=DB::table('venta')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Con tarjeta) //
                /* ACA SE SACARAN LOS ESTADOS AHORA DE PEDIDOS */
                    $efectivo_venta_pedido_f=DB::table('pedido')
                    ->where('tipo_comprobante','=','Efectivo')
                    ->where('estado','=',"FINALIZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                    ->sum('a_cuenta');

                    $efectivo_venta_pedido_r=DB::table('pedido')
                    ->where('tipo_comprobante','=','Efectivo')
                    ->where('estado','=',"RECHAZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                    ->sum('a_cuenta');

                $efectivo_venta_pedido = $efectivo_venta_pedido_f + $efectivo_venta_pedido_r;
                
                    $nota_venta_pedido_f=DB::table('pedido')
                    ->where('tipo_comprobante','=','Nota de Venta')
                    ->where('estado','=',"FINALIZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                    ->sum('a_cuenta');

                    $nota_venta_pedido_r=DB::table('pedido')
                    ->where('tipo_comprobante','=','Nota de Venta')
                    ->where('estado','=',"RECHAZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                    ->sum('a_cuenta');

                $nota_venta_pedido = $nota_venta_pedido_f + $nota_venta_pedido_r;
                
                    $con_tarjeta_pedido_f=DB::table('pedido')
                    ->where('tipo_comprobante','=','Con tarjeta')
                    ->where('estado','=',"FINALIZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                    ->sum('a_cuenta');
                    $con_tarjeta_pedido_r=DB::table('pedido')
                    ->where('tipo_comprobante','=','Con tarjeta')
                    ->where('estado','=',"RECHAZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                    ->sum('a_cuenta');

                $con_tarjeta_pedido = $con_tarjeta_pedido_f + $con_tarjeta_pedido_r;

                    $deposito_pedido_f=DB::table('pedido')
                    ->where('tipo_comprobante','=','Deposito')
                    ->where('estado','=',"FINALIZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                    ->sum('a_cuenta');
                    $deposito_pedido_r=DB::table('pedido')
                    ->where('tipo_comprobante','=','Deposito')
                    ->where('estado','=',"RECHAZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                    ->sum('a_cuenta');

                $deposito_pedido = $deposito_pedido_f + $deposito_pedido_r;
                
              
                /* ***********FIN DE ESTADOS PEDIDOS********** */
            }
            else
            {
                // •	Suma total_ventas por (efectivo) //
                $efectivo_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Efectivo')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (efectivo) //
                // •	Suma total_ventas por (Nota de venta) //
                $nota_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Nota de venta) //
                // •	Suma total_ventas por (Con tarjeta) //
                $con_tarjeta=DB::table('venta')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Con tarjeta) //
                /* ACA SE SACARAN LOS ESTADOS AHORA DE PEDIDOS */
                    $efectivo_venta_pedido_f=DB::table('pedido')
                    ->where('tipo_comprobante','=','Efectivo')
                    ->where('estado','=',"FINALIZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->sum('a_cuenta');
                    $efectivo_venta_pedido_r=DB::table('pedido')
                    ->where('tipo_comprobante','=','Efectivo')
                    ->where('estado','=',"RECHAZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->sum('a_cuenta');

                $efectivo_venta_pedido = $efectivo_venta_pedido_f + $efectivo_venta_pedido_r;

                    $nota_venta_pedido_f=DB::table('pedido')
                    ->where('tipo_comprobante','=','Nota de Venta')
                    ->where('estado','=',"FINALIZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->sum('a_cuenta');
                    $nota_venta_pedido_r=DB::table('pedido')
                    ->where('tipo_comprobante','=','Nota de Venta')
                    ->where('estado','=',"RECHAZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->sum('a_cuenta');

                $nota_venta_pedido = $nota_venta_pedido_f + $nota_venta_pedido_r;

                    $con_tarjeta_pedido_f=DB::table('pedido')
                    ->where('tipo_comprobante','=','Con tarjeta')
                    ->where('estado','=',"FINALIZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->sum('a_cuenta');
                    $con_tarjeta_pedido_r=DB::table('pedido')
                    ->where('tipo_comprobante','=','Con tarjeta')
                    ->where('estado','=',"RECHAZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->sum('a_cuenta');

                $con_tarjeta_pedido = $con_tarjeta_pedido_f + $con_tarjeta_pedido_r;

                    $deposito_pedido_f=DB::table('pedido')
                    ->where('tipo_comprobante','=','Deposito')
                    ->where('estado','=',"FINALIZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->sum('a_cuenta');
                    $deposito_pedido_r=DB::table('pedido')
                    ->where('tipo_comprobante','=','Deposito')
                    ->where('estado','=',"RECHAZADO")
                    ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                    ->sum('a_cuenta');

                $deposito_pedido = $deposito_pedido_f + $deposito_pedido_r;
                /* ***********FIN DE ESTADOS PEDIDOS********** */
            };
            // suma total //
            
            $efectivo_venta = $efectivo_venta + $efectivo_venta_pedido;
            $nota_venta = $nota_venta + $nota_venta_pedido;
            $con_tarjeta = $con_tarjeta + $con_tarjeta_pedido;
            $total_ingresos = $efectivo_venta + $nota_venta + $con_tarjeta + $deposito_pedido;
            // fin suma ingresos //

            /// consultas SQL ingresos ///
            if($caja->fecha_cierre!="")
            {
                // •	Suma total_ingreso por (factura) //
                $factura_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','factura')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (factura) //
                // •	Suma total_ingreso por (Nota de venta) //
                $nota_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (nota de venta) //
                // •	Suma total_ingreso por (tarjeta) //
                $tarjeta_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (tarjeta) //
            }
            else
            {
                // •	Suma total_ingreso por (factura) //
                $factura_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','factura')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (factura) //
                // •	Suma total_ingreso por (Nota de venta) //
                $nota_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (nota de venta) //
                // •	Suma total_ingreso por (tarjeta) //
                $tarjeta_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (tarjeta) //
            };
            // suma total //
            $total_egresos = $factura_ingreso + $nota_ingreso + $tarjeta_ingreso;
            // fin suma ingresos //
        /// fin consultas sql ventas ingresos ///
        /// consulta todos los articulos vendidos ///
        if($caja->fecha_cierre!=""){
            $articulos_vendidos=DB::table('detalle_venta as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('venta as v','d.idventa','=','v.idventa')
            ->select('v.idventa','a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
            ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
            ->where( 'v.fecha_hora','<=',$caja->fecha_cierre)
            ->where('v.estado','=','A')
            ->orderBy('v.idventa','desc')
            ->get();
            $cantidad_total_ventas=DB::table('detalle_venta as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('venta as v','d.idventa','=','v.idventa')
            ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
            ->where( 'v.fecha_hora','<=',$caja->fecha_cierre)
            ->where('v.estado','=','A')
            ->sum('d.cantidad');
            $descuento_total_ventas=DB::table('detalle_venta as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('venta as v','d.idventa','=','v.idventa')
            ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
            ->where( 'v.fecha_hora','<=',$caja->fecha_cierre)
            ->where('v.estado','=','A')
            ->sum('d.descuento');
            /* todos los articulos pedidos */
            $articulos_pedidos=DB::table('detalle_pedido as dp')
            ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
            ->join('pedido as p','dp.idpedido','=','p.id')
            ->select('p.id','p.estado','a.nombre as articulo','dp.cantidad','dp.descuento','dp.precio_venta')
            ->where('p.estado','=',"FINALIZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
            ->orwhere('p.estado','=',"RECHAZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
            ->orderBy('p.id','desc')
            ->get();
            $cantidad_total_pedidos=DB::table('detalle_pedido as dp')
            ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
            ->join('pedido as p','dp.idpedido','=','p.id')
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
            ->orwhere('p.estado','=',"RECHAZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
            ->sum('dp.cantidad');
            $descuento_total_pedidos=DB::table('detalle_pedido as dp')
            ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
            ->join('pedido as p','dp.idpedido','=','p.id')
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
            ->orwhere('p.estado','=',"RECHAZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
            ->sum('dp.descuento');
            /* fin todos los articulos pedidos */
                       
        }
        else{
            $articulos_vendidos=DB::table('detalle_venta as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('venta as v','d.idventa','=','v.idventa')
            ->select('v.idventa','a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
            ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
            ->where('v.estado','=','A')
            ->orderBy('v.idventa','desc')
            ->get();
            $cantidad_total_ventas=DB::table('detalle_venta as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('venta as v','d.idventa','=','v.idventa')
            ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
            ->where('v.estado','=','A')
            ->sum('d.cantidad');
            $descuento_total_ventas=DB::table('detalle_venta as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('venta as v','d.idventa','=','v.idventa')
            ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
            ->where('v.estado','=','A')
            ->sum('d.descuento');  
            /* todos los articulos pedidos */
            $articulos_pedidos=DB::table('detalle_pedido as dp')
            ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
            ->join('pedido as p','dp.idpedido','=','p.id')
            ->select('p.id','p.estado','a.nombre as articulo','dp.cantidad','dp.descuento','dp.precio_venta')
            ->where('p.estado','=','ACTIVO')
            ->orwhere('p.estado','=',"FINALIZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->orwhere('p.estado','=',"RECHAZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->orderBy('p.id','desc')
            ->get();
            $cantidad_total_pedidos=DB::table('detalle_pedido as dp')
            ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
            ->join('pedido as p','dp.idpedido','=','p.id')
            ->where('p.estado','=','ACTIVO')
            ->orwhere('p.estado','=',"FINALIZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->orwhere('p.estado','=',"RECHAZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->sum('dp.cantidad');
            $descuento_total_pedidos=DB::table('detalle_pedido as dp')
            ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
            ->join('pedido as p','dp.idpedido','=','p.id')
            ->where('p.estado','=','ACTIVO')
            ->orwhere('p.estado','=',"FINALIZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->orwhere('p.estado','=',"RECHAZADO")
            ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->sum('dp.descuento');

        }
        /// fin todos los articulos vendidos ///
        /// consulta todos los articulos ingresados ///
        if($caja->fecha_cierre!=""){
            $detalles_ingresados=DB::table('detalle_ingreso as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('ingreso as i','d.idingreso','=','i.idingreso')
            ->select('i.idingreso','a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta','d.fecha_vencimiento')
            ->where( 'i.fecha_hora','>=',$caja->fecha_apertura)
            ->where( 'i.fecha_hora','<=',$caja->fecha_cierre)
            ->where('i.estado','=','A')
            ->orderBy('i.idingreso','desc')
            ->get();
            $cantidad_total_ingresos=DB::table('detalle_ingreso as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('ingreso as i','d.idingreso','=','i.idingreso')
            ->where( 'i.fecha_hora','>=',$caja->fecha_apertura)
            ->where( 'i.fecha_hora','<=',$caja->fecha_cierre)
            ->where('i.estado','=','A')
            ->sum('d.cantidad');
            
        }
        else{
            $detalles_ingresados=DB::table('detalle_ingreso as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('ingreso as i','d.idingreso','=','i.idingreso')
            ->select('i.idingreso','a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta','d.fecha_vencimiento')
            ->where( 'i.fecha_hora','>=',$caja->fecha_apertura)
            ->where('i.estado','=','A')
            ->orderBy('i.idingreso','desc')
            ->get();
            
            $cantidad_total_ingresos=DB::table('detalle_ingreso as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->join('ingreso as i','d.idingreso','=','i.idingreso')
            ->where( 'i.fecha_hora','>=',$caja->fecha_apertura)
            ->where('i.estado','=','A')
            ->sum('d.cantidad');

            
            
        }
        /// fin todos los articulos ingresados ///
        return view('caja.cajas.edit',[
            'caja'=>$caja,
            'encargado'=>$encargado,
            'ventas'=>$ventas,
            'ingresos'=>$ingresos,
            'pedidos'=>$pedidos,

            'efectivo_venta'=>$efectivo_venta,
            'nota_venta'=>$nota_venta,
            'con_tarjeta'=>$con_tarjeta,
            'total_ingresos'=>$total_ingresos,

            'factura_ingreso'=>$factura_ingreso,
            'nota_ingreso'=>$nota_ingreso,
            'tarjeta_ingreso'=>$tarjeta_ingreso,
            'total_egresos'=>$total_egresos,

            'articulos_vendidos'=>$articulos_vendidos,
            'articulos_pedidos'=>$articulos_pedidos,
            'cantidad_total_pedidos'=>$cantidad_total_pedidos,
            'descuento_total_pedidos'=>$descuento_total_pedidos,
            'detalles_ingresados'=>$detalles_ingresados,

            'cantidad_total_ventas'=>$cantidad_total_ventas,
            'descuento_total_ventas'=>$descuento_total_ventas,
            'cantidad_total_ingresos'=>$cantidad_total_ingresos,
            'deposito_pedido' => $deposito_pedido
            
        ]);
    }
    public function update(CajaFormRequest $request,$id)
    {
        $caja=Caja::findOrFail($id);
        $caja->inicio=$request->get('inicio');
        if(Gate::allows('isAdmin')){
            $caja->fecha_apertura=$request->get('fecha_apertura');
            $caja->fecha_cierre=$request->get('fecha_cierre');
            if ($caja->fecha_cierre == null) {
                $mytime = Carbon::now('America/La_Paz');
                $caja->fecha_cierre=$mytime;
            }
        } else {
            $mytime = Carbon::now('America/La_Paz');
            $caja->fecha_cierre=$mytime;
        }
        $caja->otros_egresos=$request->get('otros_egresos');
        $caja->detalles=$request->get('detalles');
        $caja->cierre_real=$request->get('cierre_real');
        $caja->cierre_optimo=$request->get('cierre_optimo');
        $caja->ingreso=$request->get('total_vendido');
        $caja->egreso=$request->get('total_ingresos');
        $caja->estado="Cerrado";
        $caja->update();
        
        return Redirect::to('caja/cajas');
    }
    public function show(Request $request,$id){
        
        $caja=Caja::findOrFail($id);

        $encargado=DB::table('users')
        ->select('id','name')
        ->get();

        //// mostrando el contenido de ventas en show ////        
        if($caja->fecha_cierre!="")
        {
            $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where( 'fecha_hora','>=',$caja->fecha_apertura)//,'and','fecha_hora','<=',$caja->fecha_cierre)
            ->where( 'fecha_hora','<=',$caja->fecha_cierre)//
            ->orderBy('v.idventa','desc')
            ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta') //la agrupacion era necesaria y tiene que ser especifica
            ->get();
            $pedidos=DB::table('pedido as ped')
            ->select('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','ped.nombre_cliente','ped.celular_cliente','ped.tipo_comprobante','ped.serie_comprobante','ped.num_comprobante','ped.impuesto')
            ->where('ped.estado','=',"FINALIZADO")
            ->where("ped.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->where("ped.fecha_hora_finalizado","<=",$caja->fecha_cierre)
            ->orwhere('ped.estado','=',"RECHAZADO")
            ->where("ped.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->where("ped.fecha_hora_finalizado","<=",$caja->fecha_cierre)
            ->orderBy('ped.id','desc')
            ->groupBy('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','nombre_cliente','ped.celular_cliente','ped.tipo_comprobante','ped.serie_comprobante','ped.num_comprobante','ped.impuesto')
            ->get();
        }
        else{
            $ventas=DB::table('venta as v')
            ->join('persona as p','v.idcliente','=','p.idpersona')
            ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
            ->where( 'fecha_hora','>=',$caja->fecha_apertura)//,'and','fecha_hora','<=',$caja->fecha_cierre)
            ->orderBy('v.idventa','desc')
            ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta') //la agrupacion era necesaria y tiene que ser especifica
            ->get();
            $pedidos=DB::table('pedido as ped')
            ->select('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','ped.nombre_cliente','ped.celular_cliente','ped.tipo_comprobante','ped.serie_comprobante','ped.num_comprobante','ped.impuesto')
            ->where('ped.estado','=','ACTIVO')
            ->orwhere('ped.estado','=',"FINALIZADO")
            ->where("ped.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->orwhere('ped.estado','=',"RECHAZADO")
            ->where("ped.fecha_hora_finalizado",">=",$caja->fecha_apertura)
            ->orderBy('ped.id','desc')
            ->groupBy('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','nombre_cliente','ped.celular_cliente','ped.tipo_comprobante','ped.serie_comprobante','ped.num_comprobante','ped.impuesto')
            ->get();
        };
        ///// fin de mostrando contenido de ventas en show ////

        //// mostrando el contenido de ingresos en show ////
        if($caja->fecha_cierre!="")
        {
            $ingresos=DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.total_venta','i.obserbacion','i.detalles')//DB::raw('sum(di.cantidad*precio_compra)as total'))
            ->where( 'fecha_hora','>=',$caja->fecha_apertura)
            ->where('fecha_hora','<=',$caja->fecha_cierre)
            ->orderBy('i.idingreso','desc')
            ->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.total_venta','i.obserbacion','i.detalles')
            ->get();
        }
        else
        {
            $ingresos=DB::table('ingreso as i')
            ->join('persona as p','i.idproveedor','=','p.idpersona')
            ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
            ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.total_venta','i.obserbacion','i.detalles')//DB::raw('sum(di.cantidad*precio_compra)as total'))
            ->where( 'fecha_hora','>=',$caja->fecha_apertura)
            ->orderBy('i.idingreso','desc')
            ->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','i.total_venta','i.obserbacion','i.detalles')
            ->get();
        };
        
        ///// fin de mostrando contenido de ingresos en show ////

        /// consultas SQL e ingresos ///
            if($caja->fecha_cierre!="")
            {
                // •	Suma total_ventas por (efectivo) //
                $efectivo_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Efectivo')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (efectivo) //
                // •	Suma total_ventas por (Nota de venta) //
                $nota_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Nota de venta) //
                // •	Suma total_ventas por (Con tarjeta) //
                $con_tarjeta=DB::table('venta')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Con tarjeta) //
            /* ACA SE SACARAN LOS ESTADOS AHORA DE PEDIDOS */
                $efectivo_venta_pedido_f=DB::table('pedido')
                ->where('tipo_comprobante','=','Efectivo')
                ->where('estado','=',"FINALIZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('a_cuenta');

                $efectivo_venta_pedido_r=DB::table('pedido')
                ->where('tipo_comprobante','=','Efectivo')
                ->where('estado','=',"RECHAZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('a_cuenta');

            $efectivo_venta_pedido = $efectivo_venta_pedido_f + $efectivo_venta_pedido_r;
            
                $nota_venta_pedido_f=DB::table('pedido')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('estado','=',"FINALIZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('a_cuenta');

                $nota_venta_pedido_r=DB::table('pedido')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('estado','=',"RECHAZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('a_cuenta');

            $nota_venta_pedido = $nota_venta_pedido_f + $nota_venta_pedido_r;
            
                $con_tarjeta_pedido_f=DB::table('pedido')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('estado','=',"FINALIZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('a_cuenta');
                $con_tarjeta_pedido_r=DB::table('pedido')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('estado','=',"RECHAZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('a_cuenta');

            $con_tarjeta_pedido = $con_tarjeta_pedido_f + $con_tarjeta_pedido_r;

                $deposito_pedido_f=DB::table('pedido')
                ->where('tipo_comprobante','=','Deposito')
                ->where('estado','=',"FINALIZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('a_cuenta');
                $deposito_pedido_r=DB::table('pedido')
                ->where('tipo_comprobante','=','Deposito')
                ->where('estado','=',"RECHAZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('a_cuenta');

            $deposito_pedido = $deposito_pedido_f + $deposito_pedido_r;
            
          
            /* ***********FIN DE ESTADOS PEDIDOS********** */
            }
            else
            {
                // •	Suma total_ventas por (efectivo) //
                $efectivo_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Efectivo')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (efectivo) //
                // •	Suma total_ventas por (Nota de venta) //
                $nota_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Nota de venta) //
                // •	Suma total_ventas por (Con tarjeta) //
                $con_tarjeta=DB::table('venta')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Con tarjeta) //
                /* ACA SE SACARAN LOS ESTADOS AHORA DE PEDIDOS */
                $efectivo_venta_pedido_f=DB::table('pedido')
                ->where('tipo_comprobante','=','Efectivo')
                ->where('estado','=',"FINALIZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('a_cuenta');
                $efectivo_venta_pedido_r=DB::table('pedido')
                ->where('tipo_comprobante','=','Efectivo')
                ->where('estado','=',"RECHAZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('a_cuenta');

            $efectivo_venta_pedido = $efectivo_venta_pedido_f + $efectivo_venta_pedido_r;

                $nota_venta_pedido_f=DB::table('pedido')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('estado','=',"FINALIZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('a_cuenta');
                $nota_venta_pedido_r=DB::table('pedido')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('estado','=',"RECHAZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('a_cuenta');

            $nota_venta_pedido = $nota_venta_pedido_f + $nota_venta_pedido_r;

                $con_tarjeta_pedido_f=DB::table('pedido')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('estado','=',"FINALIZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('a_cuenta');
                $con_tarjeta_pedido_r=DB::table('pedido')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('estado','=',"RECHAZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('a_cuenta');

            $con_tarjeta_pedido = $con_tarjeta_pedido_f + $con_tarjeta_pedido_r;

                $deposito_pedido_f=DB::table('pedido')
                ->where('tipo_comprobante','=','Deposito')
                ->where('estado','=',"FINALIZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('a_cuenta');
                $deposito_pedido_r=DB::table('pedido')
                ->where('tipo_comprobante','=','Deposito')
                ->where('estado','=',"RECHAZADO")
                ->where("fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('a_cuenta');

            $deposito_pedido = $deposito_pedido_f + $deposito_pedido_r;
            /* ***********FIN DE ESTADOS PEDIDOS********** */
            };
            

            // suma total //
            $efectivo_venta = $efectivo_venta + $efectivo_venta_pedido;
            $nota_venta = $nota_venta + $nota_venta_pedido;
            $con_tarjeta = $con_tarjeta + $con_tarjeta_pedido;
            $total_ingresos = $efectivo_venta + $nota_venta + $con_tarjeta + $deposito_pedido;
            // fin suma ingresos //

            /// consultas SQL e egresos ///
            if($caja->fecha_cierre!="")
            {
                // •	Suma total_ingreso por (factura) //
                $factura_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','factura')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (factura) //
                // •	Suma total_ingreso por (Nota de venta) //
                $nota_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (nota de venta) //
                // •	Suma total_ingreso por (tarjeta) //
                $tarjeta_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('fecha_hora','<=',$caja->fecha_cierre)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (tarjeta) //
            }
            else
            {
                // •	Suma total_ingreso por (factura) //
                $factura_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','factura')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (factura) //
                // •	Suma total_ingreso por (Nota de venta) //
                $nota_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (nota de venta) //
                // •	Suma total_ingreso por (tarjeta) //
                $tarjeta_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$caja->fecha_apertura)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (tarjeta) //
            };
            // suma total //
            $total_egresos = $factura_ingreso + $nota_ingreso + $tarjeta_ingreso;
            // fin suma ingresos //
            /// consulta todos los articulos vendidos ///
            if($caja->fecha_cierre!=""){
                $articulos_vendidos=DB::table('detalle_venta as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('venta as v','d.idventa','=','v.idventa')
                ->select('v.idventa','a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
                ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
                ->where( 'v.fecha_hora','<=',$caja->fecha_cierre)
                ->where('v.estado','=','A')
                ->get();
                $cantidad_total_ventas=DB::table('detalle_venta as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('venta as v','d.idventa','=','v.idventa')
                ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
                ->where( 'v.fecha_hora','<=',$caja->fecha_cierre)
                ->where('v.estado','=','A')
                ->sum('d.cantidad');
                $descuento_total_ventas=DB::table('detalle_venta as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('venta as v','d.idventa','=','v.idventa')
                ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
                ->where( 'v.fecha_hora','<=',$caja->fecha_cierre)
                ->where('v.estado','=','A')
                ->sum('d.descuento');
                /* todos los articulos pedidos */
                $articulos_pedidos=DB::table('detalle_pedido as dp')
                ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
                ->join('pedido as p','dp.idpedido','=','p.id')
                ->select('p.id','p.estado','a.nombre as articulo','dp.cantidad','dp.descuento','dp.precio_venta')
                ->where('p.estado','=',"FINALIZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->orwhere('p.estado','=',"RECHAZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->orderBy('p.id','desc')
                ->get();
                $cantidad_total_pedidos=DB::table('detalle_pedido as dp')
                ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
                ->join('pedido as p','dp.idpedido','=','p.id')
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->orwhere('p.estado','=',"RECHAZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('dp.cantidad');
                $descuento_total_pedidos=DB::table('detalle_pedido as dp')
                ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
                ->join('pedido as p','dp.idpedido','=','p.id')
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->orwhere('p.estado','=',"RECHAZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->where("p.fecha_hora_finalizado","<=",$caja->fecha_cierre)
                ->sum('dp.descuento');
                /* fin todos los articulos pedidos */
                        
            }
            else{
                $articulos_vendidos=DB::table('detalle_venta as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('venta as v','d.idventa','=','v.idventa')
                ->select('v.idventa','a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
                ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
                ->where('v.estado','=','A')
                ->get();
                $cantidad_total_ventas=DB::table('detalle_venta as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('venta as v','d.idventa','=','v.idventa')
                ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
                ->where('v.estado','=','A')
                ->sum('d.cantidad');
                $descuento_total_ventas=DB::table('detalle_venta as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('venta as v','d.idventa','=','v.idventa')
                ->where( 'v.fecha_hora','>=',$caja->fecha_apertura)
                ->where('v.estado','=','A')
                ->sum('d.descuento');  
                /* todos los articulos pedidos */
                $articulos_pedidos=DB::table('detalle_pedido as dp')
                ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
                ->join('pedido as p','dp.idpedido','=','p.id')
                ->select('p.id','p.estado','a.nombre as articulo','dp.cantidad','dp.descuento','dp.precio_venta')
                ->where('p.estado','=','ACTIVO')
                ->orwhere('p.estado','=',"FINALIZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->orwhere('p.estado','=',"RECHAZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->orderBy('p.id','desc')
                ->get();
                $cantidad_total_pedidos=DB::table('detalle_pedido as dp')
                ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
                ->join('pedido as p','dp.idpedido','=','p.id')
                ->where('p.estado','=','ACTIVO')
                ->orwhere('p.estado','=',"FINALIZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->orwhere('p.estado','=',"RECHAZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('dp.cantidad');
                $descuento_total_pedidos=DB::table('detalle_pedido as dp')
                ->join('articulo as a','dp.idarticulo','=','a.idarticulo')
                ->join('pedido as p','dp.idpedido','=','p.id')
                ->where('p.estado','=','ACTIVO')
                ->orwhere('p.estado','=',"FINALIZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->orwhere('p.estado','=',"RECHAZADO")
                ->where("p.fecha_hora_finalizado",">=",$caja->fecha_apertura)
                ->sum('dp.descuento');
            }
            /// fin todos los articulos vendidos ///
            /// consulta todos los articulos ingresados ///
            if($caja->fecha_cierre!=""){
                $detalles_ingresados=DB::table('detalle_ingreso as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('ingreso as i','d.idingreso','=','i.idingreso')
                ->select('i.idingreso','a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta','d.fecha_vencimiento')
                ->where( 'i.fecha_hora','>=',$caja->fecha_apertura)
                ->where( 'i.fecha_hora','<=',$caja->fecha_cierre)
                ->where('i.estado','=','A')
                ->get();
                $cantidad_total_ingresos=DB::table('detalle_ingreso as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('ingreso as i','d.idingreso','=','i.idingreso')
                ->where( 'i.fecha_hora','>=',$caja->fecha_apertura)
                ->where( 'i.fecha_hora','<=',$caja->fecha_cierre)
                ->where('i.estado','=','A')
                ->sum('d.cantidad');
                
            }
            else{
                $detalles_ingresados=DB::table('detalle_ingreso as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('ingreso as i','d.idingreso','=','i.idingreso')
                ->select('i.idingreso','a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta','d.fecha_vencimiento')
                ->where( 'i.fecha_hora','>=',$caja->fecha_apertura)
                ->where('i.estado','=','A')
                ->get();
                
                $cantidad_total_ingresos=DB::table('detalle_ingreso as d')
                ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                ->join('ingreso as i','d.idingreso','=','i.idingreso')
                ->where( 'i.fecha_hora','>=',$caja->fecha_apertura)
                ->where('i.estado','=','A')
                ->sum('d.cantidad');

                
                
            }
            /// fin todos los articulos ingresados ///

        $descargar=$request->get('descargar_lista');
        if ($descargar == "todoExcel") {
            return (new CajaExport)->datos($caja,$encargado,$ventas,$efectivo_venta,$nota_venta,$con_tarjeta,$pedidos,$deposito_pedido,$total_ingresos,$articulos_vendidos,$cantidad_total_ventas,$descuento_total_ventas,$cantidad_total_ingresos,$ingresos,$factura_ingreso,$nota_ingreso,$tarjeta_ingreso,$detalles_ingresados,$total_egresos
                )->download('caja-'.$caja->idcaja.'.xlsx');
        } elseif ($descargar == "todo") {
            /* descargar todo */
            $pdf = PDF::loadView('caja.cajas.reporte-caja',[
                /* ventas */
                'caja'=>$caja,
                'encargado'=>$encargado,
                'ventas'=>$ventas,
                'efectivo_venta'=>$efectivo_venta,
                'nota_venta'=>$nota_venta,
                'con_tarjeta'=>$con_tarjeta,
                /* pedidos */
                'pedidos'=>$pedidos,
                'deposito_pedido' => $deposito_pedido,
                'articulos_pedidos'=>$articulos_pedidos,
                'cantidad_total_pedidos'=>$cantidad_total_pedidos,
                'descuento_total_pedidos'=>$descuento_total_pedidos,
                /* ventas articulos */
                'total_ingresos'=>$total_ingresos,
                'articulos_vendidos'=>$articulos_vendidos,
                'cantidad_total_ventas'=>$cantidad_total_ventas,
                'descuento_total_ventas'=>$descuento_total_ventas,
                'cantidad_total_ingresos'=>$cantidad_total_ingresos,
                /* ingresos */
                'ingresos'=>$ingresos,
                'factura_ingreso'=>$factura_ingreso,
                'nota_ingreso'=>$nota_ingreso,
                'tarjeta_ingreso'=>$tarjeta_ingreso,
                /* ingresos articulos */
                'detalles_ingresados'=>$detalles_ingresados,
                /* caja */
                'total_egresos'=>$total_egresos
            ]);
            return $pdf->stream('reporte-caja-'.$caja->idcaja.'.pdf');
            /* fin descargar todo */
        } elseif($descargar == 1){
            $pdf = PDF::loadView('caja.partial1.sventas_articulo',[
            'caja'=>$caja,
            'total_ingresos'=>$total_ingresos,
            'articulos_vendidos'=>$articulos_vendidos,
            'cantidad_total_ventas'=>$cantidad_total_ventas,
            'descuento_total_ventas'=>$descuento_total_ventas,
            'cantidad_total_ingresos'=>$cantidad_total_ingresos,
            /* pedidos */
            'pedidos'=>$pedidos,
            'deposito_pedido' => $deposito_pedido,
            'articulos_pedidos'=>$articulos_pedidos,
            'cantidad_total_pedidos'=>$cantidad_total_pedidos,
            'descuento_total_pedidos'=>$descuento_total_pedidos,
            ]);
            return $pdf->stream('list-articulos.pdf');
        }elseif ($descargar == 2) {
            $pdf = PDF::loadView('caja.partial1.sventas',[
                'caja'=>$caja,
                'ventas'=>$ventas,
                'efectivo_venta'=>$efectivo_venta,
                'nota_venta'=>$nota_venta,
                'con_tarjeta'=>$con_tarjeta,
                'pedidos'=>$pedidos,
                'deposito_pedido' => $deposito_pedido

                ]);
            return $pdf->stream('list-ventas-caja-'.$caja->idcaja.'.pdf');
        }elseif ($descargar == 3) {

            return (new CajaListaVentasExport)->datos(
                $caja,
                $ventas,
                $efectivo_venta,
                $nota_venta,
                $con_tarjeta,
                $pedidos,
                $deposito_pedido
                )->download('lista-ventas-caja-'.$caja->idcaja.'.xlsx');

        }elseif ($descargar == 4) {

            return (new CajaListaArticulosExport)->datos(
                $caja,
                $total_ingresos,
                $articulos_vendidos,
                $cantidad_total_ventas,
                $descuento_total_ventas,
                $cantidad_total_ingresos,
                $pedidos,
                $deposito_pedido,
                $articulos_pedidos,
                $cantidad_total_pedidos,
                $descuento_total_pedidos,
                )->download('lista-ventas-articulos-caja-'.$caja->idcaja.'.xlsx');
        }elseif ($descargar == 5){
            $pdf = PDF::loadView('caja.partial1.singresos',[
                'caja'=>$caja,
                'ingresos'=>$ingresos,
                'factura_ingreso'=>$factura_ingreso,
                'nota_ingreso'=>$nota_ingreso,
                'tarjeta_ingreso'=>$tarjeta_ingreso
                ]);
                return $pdf->stream('list-ingresos-caja-'.$caja->idcaja.'.pdf');
        }elseif ($descargar == 6) {
            return (new CajaListaIngresosExport)->datos(
                $caja,
                $ingresos,
                $factura_ingreso,
                $nota_ingreso,
                $tarjeta_ingreso
                )->download('lista-ingresos-caja-'.$caja->idcaja.'.xlsx');
        }elseif ($descargar == 7) {
            $pdf = PDF::loadView('caja.partial1.singresos_articulo',[
                'caja'=>$caja,
                'detalles_ingresados'=>$detalles_ingresados,
                'cantidad_total_ingresos'=>$cantidad_total_ingresos
                ]);
                return $pdf->stream('list-articulos-ingresos-caja-'.$caja->idcaja.'.pdf');
        }elseif ($descargar == 8) {
            return (new CajaListaIngresosArticulosExport)->datos(
                $caja,
                $detalles_ingresados,
                $cantidad_total_ingresos
            )->download('lista-ingresos-articulos-caja-'.$caja->idcaja.'.xlsx');
        }
        else {

            return view('caja.cajas.show',[
                'caja'=>$caja,
                'encargado'=>$encargado,
                'ventas'=>$ventas,
                'ingresos'=>$ingresos,
                'pedidos'=>$pedidos,

                'efectivo_venta'=>$efectivo_venta,
                'nota_venta'=>$nota_venta,
                'con_tarjeta'=>$con_tarjeta,
                'total_ingresos'=>$total_ingresos,

                'factura_ingreso'=>$factura_ingreso,
                'nota_ingreso'=>$nota_ingreso,
                'tarjeta_ingreso'=>$tarjeta_ingreso,
                'total_egresos'=>$total_egresos,

                'articulos_vendidos'=>$articulos_vendidos,
                'articulos_pedidos'=>$articulos_pedidos,
                'cantidad_total_pedidos'=>$cantidad_total_pedidos,
                'descuento_total_pedidos'=>$descuento_total_pedidos,
                'detalles_ingresados'=>$detalles_ingresados,

                'cantidad_total_ventas'=>$cantidad_total_ventas,
                'descuento_total_ventas'=>$descuento_total_ventas,
                'cantidad_total_ingresos'=>$cantidad_total_ingresos,
                'deposito_pedido' => $deposito_pedido
                
            ]);
        }
    }
    public function destroy($id)
    {
        return Redirect::to('caja/cajas');
    }
    public function exportList()
    {
        $pdf = PDF::loadView('caja.partial1.sventas_articulo');
        return $pdf->stream('list-articulos.dpf'); // ->stream() genera el pdf en una vista antse de descargarla
    }
}
