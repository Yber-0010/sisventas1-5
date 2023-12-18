<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;
use Barryvdh\DomPDF\Facade as PDF;

use App\Http\Requests\PedidoProveedorFormRequest;
use App\Exports\DetallesPedidoProveedorExport;
use DB;
use App\Pedido_proveedor;
use App\Detalle_pedido_proveedor;


class PedidoProveedorController extends Controller
{
    public function __construct() {
        $this->middleware( 'auth' );
    }
    /* index */
    public function index( Request $request ) {
        if( $request ) {
            $query = trim( $request->get( 'searchText' ) );
            $nombre=$query;
            $pedidos = DB::table( 'pedido_proveedor as pp' )
            ->join( 'persona as p','pp.id_proveedor','=','p.idpersona' )
            ->join( 'users as u','pp.id_usuario','=','u.id' )
            ->select( 'pp.id','pp.fecha_inicio','pp.fecha_fin','pp.detalles','pp.estado','pp.recibido','p.nombre','p.telefono','u.name' )
            ->where( 'p.tipo_persona','=','Proveedor' )
            ->where( 'p.nombre','LIKE','%'.$query.'%' )
            ->orwhere( 'pp.id','LIKE','%'.$query.'%' )
            ->orwhere( 'p.telefono','LIKE','%'.$query.'%' )
            ->orwhere( 'pp.fecha_inicio','LIKE','%'.$query.'%' )
            ->orwhere( 'pp.fecha_fin','LIKE','%'.$query.'%' )
            ->orderBy( 'pp.id','desc' )
            ->groupBy( 'pp.id','pp.fecha_inicio','pp.fecha_fin','pp.detalles','pp.estado','pp.recibido','p.nombre','p.telefono','u.name' )
            ->paginate(10);
            $cantidadPedidos=DB::table( 'pedido_proveedor' )
            ->where( 'estado','=','ACTIVO' )
            ->count();
        }
        return view('pedidos.proveedor-pedido.index',[ "pedidos"=>$pedidos,"searchText"=>$query,"nombre"=>$nombre,'cantidadPedidos'=>$cantidadPedidos]);
    }
    /* create */
    public function create () {
        $personas=DB::table( 'persona' )
        ->where( 'tipo_persona','=','Proveedor' )
        ->get();
        $articulos=DB::table('articulo as art')
          ->select('art.nombre AS articulo','art.idarticulo','art.stock','art.precio_venta','art.precio_compra','art.imagen','art.peso','art.empresa')
          ->where('art.estado','=','Activo')
          ->where('art.stock','>=','0')
          ->groupBy('articulo','art.idarticulo','art.stock','art.precio_venta','art.precio_compra','art.imagen','art.peso','art.empresa')
          ->get();
        return view('pedidos.proveedor-pedido.create',["personas"=>$personas,"articulos"=>$articulos]);
    }
    public function store (PedidoProveedorFormRequest $request)
    {
        try{
            DB::beginTransaction();

            $personas=DB::table('persona')
            ->where('tipo_persona','=','Proveedor')
            ->get();
            
            $pedido = new Pedido_proveedor;

            $name_proveedor=$request->get('name_proveedor');

            foreach ($personas as $per){
                if($per->nombre == $name_proveedor){
                    $pedido->id_proveedor = $per->idpersona;
                }
            }

            $mytime = Carbon::now('America/La_Paz');
            $pedido->fecha_inicio=$mytime->toDateTimeString();
            $pedido->estado='ACTIVO';
            $pedido->detalles=$request->get('detalles1');
            $pedido->id_usuario = auth()->user()->id;
            $pedido->save();

            $otro          = $request->get('otro');
            $idarticulo    = $request->get('idarticulo');
            $cantidad      = $request->get('cantidad');
            $descuento     = $request->get('descuento');
            $precio_compra = $request->get('precio_compra');
            $stock         = $request->get('stock');

            
            $cont = 0;
            while($cont< count($idarticulo)){

                $detalle = new Detalle_pedido_proveedor();
                $detalle->id_pedido=$pedido->id;
                $detalle->id_articulo=$idarticulo[$cont];
                $detalle->otro=$otro[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_compra=$precio_compra[$cont];
                $detalle->stock=$stock[$cont];
                $detalle->save();
                
                $cont=$cont+1;
            };
            

            DB::commit();

        }catch(\Exception $e){
            DB::rollback();
        }
        
        return Redirect::to('pedidos/proveedor-pedido');
        
    }
    public function edit($id){

        $pedidos_proveedor=Pedido_proveedor::findOrFail($id);
        $detalles_pedido_proveedor=DB::table('detalle_pedido_proveedor as d')
        ->join('articulo as a','d.id_articulo','=','a.idarticulo')
        ->select('d.id_detalle','a.idarticulo','a.nombre as articulo','d.cantidad','d.descuento','d.precio_compra','d.id_pedido','d.otro','a.peso','a.empresa','d.stock')
        ->where('d.id_pedido','=',$pedidos_proveedor->id)
        ->get();
        $detalles_pedido_proveedor_null=DB::table('detalle_pedido_proveedor as d')
        ->select('d.id_detalle','d.cantidad','d.descuento','d.precio_compra','d.id_pedido','d.otro')
        ->where('d.id_pedido','=',$pedidos_proveedor->id)
        ->where('d.id_articulo','=',null)
        ->get();
        /* primero envias los buenos luego los otros */
        $persona=DB::table('persona')
        ->where('tipo_persona','=','Proveedor')
        ->get();
        $articulos=DB::table('articulo as art')
          ->select('art.nombre AS articulo','art.idarticulo','art.stock','art.precio_venta','art.precio_compra','art.imagen','art.peso','art.empresa')
          ->where('art.estado','=','Activo')
          ->where('art.stock','>=','0')
          ->groupBy('articulo','art.idarticulo','art.stock','art.precio_venta','art.precio_compra','art.imagen','art.peso','art.empresa')
          ->get();
        
        return view("pedidos.proveedor-pedido.edit",[
            "pedidos"=>$pedidos_proveedor,
            "detalles_pedido_proveedor"=>$detalles_pedido_proveedor,
            "detalles_pedido_proveedor_null"=>$detalles_pedido_proveedor_null,
            "persona"=>$persona,
            "articulos"=>$articulos
        ]);
        
    }
    public function update(Request $request ,$id ) {  
       
        $personas=DB::table('persona')
        ->where('tipo_persona','=','Proveedor')
        ->get();

        $pedido=Pedido_proveedor::findOrFail($id);

        $pedido->id_usuario = auth()->user()->id;

        $name_proveedor=$request->get('name_proveedor');

        foreach ($personas as $per){
            if($per->nombre == $name_proveedor){
                $pedido->id_proveedor = $per->idpersona;
            }
        }

        $estadoPedido = $request->get('estadoPedido');
        
        if($estadoPedido == 1){
            $pedido->estado='FINALIZADO';
            $mytime = Carbon::now('America/La_Paz');
            $pedido->fecha_fin=$mytime->toDateTimeString();    
        } elseif ($estadoPedido == 2) {
            $pedido->estado='RECHAZADO';
            $mytime = Carbon::now('America/La_Paz');
            $pedido->fecha_fin=$mytime->toDateTimeString();
        }else {
            $pedido->estado='ACTIVO';
            $mytime = Carbon::now('America/La_Paz');
            $pedido->fecha_inicio=$mytime->toDateTimeString();
            $pedido->fecha_fin=null;
        }
        $recogio = $request->get('recibido');
        if($recogio == 1 ){
            $pedido->recibido = 'recibido';
        }elseif ($recogio == 2) {
            $pedido->recibido = 'no recibido';
        }else {
            $pedido->recibido = null;
        };
        $pedido->detalles=$request->get('detalles1');
        $pedido->update();
        

        $estadoPedido  = $request->get('estadoPedido');
        $otro          = $request->get('otro');
        $idarticulo    = $request->get('idarticulo');
        $cantidad      = $request->get('cantidad');
        $descuento     = $request->get('descuento');
        $precio_compra = $request->get('precio_compra');
        $stock         = $request->get('stock');
        
        /*  RECHAZO DEL PEDIDO */
        if($estadoPedido == 1){/* FINALIZADO*/
            $detallePedido = DB::table('detalle_pedido_proveedor')
            ->where('id_pedido','=',$id)->delete();
            
            $cont=0;
            while($cont<count($idarticulo)){
                $detalle = new Detalle_pedido_proveedor();
                $detalle->id_pedido=$pedido->id;
                $detalle->id_articulo=$idarticulo[$cont];
                $detalle->otro=$otro[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_compra=$precio_compra[$cont];
                $detalle->stock=$stock[$cont];
                $detalle->save();
                $cont=$cont+1;
            };
        }elseif ($estadoPedido == 2){/* RECHAZADO */
            $detallePedido = DB::table('detalle_pedido_proveedor')
            ->where('id_pedido','=',$id)->delete();
        }else{
            $detallePedido = DB::table('detalle_pedido_proveedor')
            ->where('id_pedido','=',$id)->delete();
            
            $cont=0;
            while($cont<count($idarticulo)){
                $detalle = new Detalle_pedido_proveedor();
                $detalle->id_pedido=$pedido->id;
                $detalle->id_articulo=$idarticulo[$cont];
                $detalle->otro=$otro[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->descuento=$descuento[$cont];
                $detalle->precio_compra=$precio_compra[$cont];
                $detalle->stock=$stock[$cont];
                $detalle->save();
                $cont=$cont+1;
            };
        }
        /* PROBADNO EL RECHAZO DEL PEDIDO */
        
        return Redirect::to('pedidos/proveedor-pedido');
            
    }
    public function show(Request $request,$id){
        $pedidos=Pedido_proveedor::findOrFail($id);
        $persona=DB::table('persona')
        ->where('tipo_persona','=','Proveedor')
        ->get();
        $detalles_pedido_proveedor=DB::table('detalle_pedido_proveedor as d')
        ->join('articulo as a','d.id_articulo','=','a.idarticulo')
        ->select('d.id_detalle','a.idarticulo','a.nombre as articulo','d.cantidad','d.descuento','d.precio_compra','d.id_pedido','d.otro','a.peso','a.empresa','d.stock')
        ->where('d.id_pedido','=',$pedidos->id)
        ->get();
        $detalles_pedido_proveedor_null=DB::table('detalle_pedido_proveedor as d')
        ->select('d.id_detalle','d.cantidad','d.descuento','d.precio_compra','d.id_pedido','d.otro')
        ->where('d.id_pedido','=',$pedidos->id)
        ->where('d.id_articulo','=',null)
        ->get();
        $sum_pedido=DB::table('detalle_pedido_proveedor')
        ->select('cantidad','descuento','precio_compra')
        ->where('id_pedido','=',$pedidos->id)
        ->get();
        $idshow=$id;
        $total = 0;
        foreach ($sum_pedido as $sum) {
            $cantidad = $sum->cantidad;
            $precio_compra = $sum->precio_compra;
            $descuento = $sum->descuento;
            $total = $total+($cantidad*$precio_compra-$descuento);
        }
        foreach ($persona as $per){
            if($per->idpersona == $pedidos->id_proveedor){
                $proveedor = $per->nombre;
            }
        }
        $descarga_detalles=$request->get('descargar_detalles');
        if ($descarga_detalles == 1) {
            return (new DetallesPedidoProveedorExport)->datos(
                $persona,
                $pedidos,
                $detalles_pedido_proveedor,
                $detalles_pedido_proveedor_null,
                $idshow,
                $sum_pedido,
                $total
            )->download('Pedido-'.$pedidos->id.'-proveedor-'.$proveedor.'.xlsx');
        }elseif ($descarga_detalles == 2) {
            $pdf = PDF::loadView('pedidos.proveedor-pedido.detalles_pedidos_proveedor',[
                "persona"=>$persona,
                "pedidos"=>$pedidos,
                "detalles_pedido"=>$detalles_pedido_proveedor,
                "detalles_pedido_null"=>$detalles_pedido_proveedor_null,
                'idshow'=>$idshow,
                'sum_pedido'=>$sum_pedido,
                'total'=>$total
            ]);
            return $pdf->stream('Pedido-'.$pedidos->id.'-proveedor-'.$proveedor.'.pdf');
        }else {
            return view("pedidos.proveedor-pedido.show",[
                "persona"=>$persona,
                "pedidos"=>$pedidos,
                "detalles_pedido"=>$detalles_pedido_proveedor,
                "detalles_pedido_null"=>$detalles_pedido_proveedor_null,
                'idshow'=>$idshow,
                'sum_pedido'=>$sum_pedido,
                'total'=>$total
            ]);
        }

    }
}
