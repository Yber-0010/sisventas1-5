<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\DetallesPedidoExport;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\PedidoFormRequest;
use App\Pedido;
use App\Detalle_pedido;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;



class PedidoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
       if($request)
       {
           $query=trim($request->get('searchText'));
           $nombre=$query;
           $pedidos=DB::table('pedido as ped')
           //->join('persona as p','ped.idcliente','=','p.idpersona')
           //->join('detalle_pedido as dp','ped.id','=','dp.idpedido')
           ->select('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','ped.nombre_cliente','ped.celular_cliente',"ped.encargado_pedido")
           ->where('ped.nombre_cliente','LIKE','%'.$query.'%')
           ->orwhere('ped.celular_cliente','LIKE','%'.$query.'%')
           ->orwhere('ped.fecha_hora_inicio','LIKE','%'.$query.'%')
           ->orwhere('ped.fecha_hora_entrega','LIKE','%'.$query.'%')
           ->orderBy('ped.id','desc')
           ->groupBy('ped.id','ped.fecha_hora_inicio','ped.fecha_hora_entrega','ped.a_cuenta','ped.saldo','ped.total_venta','ped.estado','ped.recogio','ped.hora','ped.fecha_hora_finalizado','ped.detalles','ped.nombre_cliente','ped.celular_cliente',"ped.encargado_pedido")
           ->paginate(20);
           $cantidadPedidos=DB::table('pedido')
           ->where('estado','=','ACTIVO')
           ->count();
           
           return view('pedidos.cliente-pedido.index',["pedidos"=>$pedidos,"searchText"=>$query,"nombre"=>$nombre,'cantidadPedidos'=>$cantidadPedidos]);
       }
    }
    public function create()
    {
        $personas=DB::table('persona')
        ->where('tipo_persona','=','Cliente')
        ->get();
          $articulos=DB::table('articulo as art')
          ->select(/* DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo') */'art.nombre AS articulo','art.idarticulo','art.stock','art.precio_venta','art.imagen','art.peso','art.empresa')//DB::raw('MAX(di.precio_venta) as precio_promedio')
          ->where('art.estado','=','Activo')
          ->where('art.stock','>','0')
          ->groupBy('articulo','art.idarticulo','art.stock','art.precio_venta','art.imagen','art.peso','art.empresa')
          ->get();
          return view('pedidos.cliente-pedido.create',["personas"=>$personas,"articulos"=>$articulos]);
    }
    public function store (PedidoFormRequest $request)
    {
        try{
            DB::beginTransaction();

            $personas=DB::table('persona')
            ->where('tipo_persona','=','Cliente')
            ->get();
            
            
            $pedido = new Pedido;
            $pedido->idcliente=$request->get('idcliente');

            foreach ($personas as $per){
                if($per->idpersona == $pedido->idcliente){
                    $pedido->nombre_cliente = $per->nombre;
                    $pedido->celular_cliente = $per->telefono;
                }
            }
            
            $pedido->tipo_comprobante=$request->get('tipo_comprobante');
            $pedido->serie_comprobante=$request->get('serie_comprobante');
            $pedido->num_comprobante=$request->get('num_comprobante');
            $pedido->total_venta=$request->get('total_venta');
            $mytime = Carbon::now('America/La_Paz');
            $pedido->fecha_hora_inicio=$mytime->toDateTimeString();
            $pedido->fecha_hora_entrega=$request->get('fecha_entrega');
            $pedido->hora=$request->get('hora');
            $pedido->impuesto='0.35';
            $pedido->estado='ACTIVO';
            $pedido->detalles=$request->get('detalles1');
            $pedido->a_cuenta=$request->get('total1');// a cuenta
            $pedido->saldo=$request->get('saldo');
            $pedido->encargado_pedido = auth()->user()->name;
            $pedido->save();

            $otro = $request->get('otro');
            $idarticulo=$request->get('idarticulo');
            $cantidad=$request->get('cantidad');
            $descuento=$request->get('descuento');
            $precio_venta=$request->get('precio_venta');

            
            $cont=0;
            while($cont< count($idarticulo)){

                $detalle = new Detalle_pedido();
                $detalle->idpedido=$pedido->id;
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->otro=$otro[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
                $detalle->save();
                
                $cont=$cont+1;
            };
            

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
        }
        
        return Redirect::to('pedidos/cliente-pedido');
        
    }
    public function edit($id){

        $pedidos=Pedido::findOrFail($id);
        $detalles_pedido=DB::table('detalle_pedido as d')
        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
        ->select('d.iddetale_pedido','a.idarticulo','a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.idpedido','d.otro','a.peso','a.empresa')
        ->where('d.idpedido','=',$pedidos->id)
        ->get();
        $detalles_pedido_null=DB::table('detalle_pedido as d')
        ->select('d.iddetale_pedido','d.cantidad','d.descuento','d.precio_venta','d.idpedido','d.otro')
        ->where('d.idpedido','=',$pedidos->id)
        ->where('d.idarticulo','=',null)
        ->get();
        /* primero envias los buenos luego los otros */
        $persona=DB::table('persona')
        ->where('tipo_persona','=','Cliente')
        ->get();
        $articulos=DB::table('articulo as art')
        ->select('art.nombre AS articulo','art.idarticulo','art.stock','art.precio_venta','art.imagen','art.peso','art.empresa')//DB::raw('MAX(di.precio_venta) as precio_promedio')
        //->select('art.nombre as articulo','art.idarticulo','art.stock','art.precio_venta')//DB::raw('MAX(di.precio_venta) as precio_promedio')
        ->where('art.estado','=','Activo')
        ->where('art.stock','>','0')
        ->groupBy('articulo','art.idarticulo','art.stock','art.precio_venta','art.imagen','art.peso','art.empresa')
        ->get();
        
        
        return view("pedidos.cliente-pedido.edit",
        ["pedidos"=>$pedidos,
        "detalles_pedido"=>$detalles_pedido,
        "detalles_pedido_null"=>$detalles_pedido_null,
        "persona"=>$persona,
        "articulos"=>$articulos
        ]);
        
    }
    public function update(Request $request ,$id ) {  
       
        $personas=DB::table('persona')
        ->where('tipo_persona','=','Cliente')
        ->get();
        
        $pedido=Pedido::findOrFail($id);
        $pedido->idcliente=$request->get('idcliente');

        foreach ($personas as $per){
            if($per->idpersona == $pedido->idcliente){
                $pedido->nombre_cliente = $per->nombre;
                $pedido->celular_cliente = $per->telefono;
            }
        }

        $pedido->tipo_comprobante=$request->get('tipo_comprobante');
        $pedido->serie_comprobante=$request->get('serie_comprobante');
        $pedido->num_comprobante=$request->get('num_comprobante');
        $pedido->total_venta=$request->get('total_venta');
        
        $pedido->fecha_hora_entrega=$request->get('fecha_entrega');
        $pedido->hora=$request->get('hora');
        $pedido->impuesto='0.35';

        $estadoPedido = $request->get('estadoPedido');
        
        if($estadoPedido == 1){
            $pedido->estado='FINALIZADO';
            $mytime = Carbon::now('America/La_Paz');
            $pedido->fecha_hora_finalizado=$mytime->toDateTimeString();    
        } elseif ($estadoPedido == 2) {
            $pedido->estado='RECHAZADO';
            /* $pedido->total_venta= null; */
            $mytime = Carbon::now('America/La_Paz');
            $pedido->fecha_hora_finalizado=$mytime->toDateTimeString();    
        }else {
            $pedido->estado='ACTIVO';
            $pedido->fecha_hora_finalizado=null;
        }
        $recogio = $request->get('recogio');
        if($recogio == 1 ){
            $pedido->recogio = 'entregado';
        }elseif ($recogio == 2) {
            $pedido->recogio = 'no recogio';
        }else {
            $pedido->recogio = null;
        };
        $pedido->detalles=$request->get('detalles1');
        $pedido->a_cuenta=$request->get('total1');// a cuenta
        $pedido->saldo=$request->get('saldo');
        $pedido->update();
        

        $estadoPedido = $request->get('estadoPedido');
        $otro = $request->get('otro');
        $idarticulo=$request->get('idarticulo');
        //$idarticulo=$request->get('idarticulo');
        $cantidad=$request->get('cantidad');
        $descuento=$request->get('descuento');
        $precio_venta=$request->get('precio_venta');
        
        
        /*  RECHAZO DEL PEDIDO */
        if($estadoPedido == 1){/* FINALIZADO*/
            $detallePedido = DB::table('detalle_pedido')
            ->where('idpedido','=',$id)->delete();
            
            $cont=0;
            while($cont<count($idarticulo)){
                $detalle = new Detalle_pedido();
                $detalle->idpedido=$pedido->id;
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->otro=$otro[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
                $detalle->save();
                $cont=$cont+1;
            };
        }elseif ($estadoPedido == 2){/* RECHAZADO */
            $detallePedido = DB::table('detalle_pedido')
            ->where('idpedido','=',$id)->delete();
        }else{
            $detallePedido = DB::table('detalle_pedido')
            ->where('idpedido','=',$id)->delete();
            
            $cont=0;
            while($cont<count($idarticulo)){
                $detalle = new Detalle_pedido();
                $detalle->idpedido=$pedido->id;
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->otro=$otro[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
                $detalle->save();
                $cont=$cont+1;
            };
        }
        /* PROBADNO EL RECHAZO DEL PEDIDO */
        
        return Redirect::to('pedidos/cliente-pedido');
            
    }
    public function show(Request $request,$id){
        $pedidos=Pedido::findOrFail($id);
        $detalles_pedido=DB::table('detalle_pedido as d')
        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
        ->select('d.iddetale_pedido','a.idarticulo','a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta','d.idpedido')
        ->where('d.idpedido','=',$pedidos->id)
        ->get();
        $detalles_pedido_null=DB::table('detalle_pedido as d')
        ->select('d.iddetale_pedido','d.cantidad','d.descuento','d.precio_venta','d.idpedido','d.otro')
        ->where('d.idpedido','=',$pedidos->id)
        ->where('d.idarticulo','=',null)
        ->get();
        $idshow=$id;

        $descarga_detalles=$request->get('descargar_detalles');
        if ($descarga_detalles == 1) {
            return (new DetallesPedidoExport)->datos(
            $pedidos,
            $detalles_pedido,
            $detalles_pedido_null,
            $idshow
            )->download('Detalles-pedido-'.$pedidos->id.'.xlsx');
        }elseif ($descarga_detalles == 2) {
            $pdf = PDF::loadView('pedidos.cliente-pedido.detalles_pedidos',[
            "pedidos"=>$pedidos,
            "detalles_pedido"=>$detalles_pedido,
            "detalles_pedido_null"=>$detalles_pedido_null,
            'idshow'=>$idshow
            ]);
            return $pdf->stream('Detalles-pedido-'.$pedidos->id.'.pdf');
        }else {
            return view("pedidos.cliente-pedido.show",[
                "pedidos"=>$pedidos,
                "detalles_pedido"=>$detalles_pedido,
                "detalles_pedido_null"=>$detalles_pedido_null,
                'idshow'=>$idshow
            ]);
        }

    }

}
