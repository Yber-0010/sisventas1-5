<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\DetallesVentaExport;
use Illuminate\Support\Facades\Redirect;
Use Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\VentaFormRequest;
use App\Venta;
use App\DetalleVenta;
use App\Articulo;
use DB;
use App\Events\stockminEvent;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class VentaController extends Controller
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
           $ventas=DB::table('venta as v')
           ->join('persona as p','v.idcliente','=','p.idpersona')
           ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
           ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
           ->where('v.num_comprobante','LIKE','%'.$query.'%')
           ->orwhere('v.fecha_hora','LIKE','%'.$query.'%')
           ->orwhere('p.nombre','LIKE','%'.$query.'%')
           ->orderBy('v.idventa','desc')
           ->groupBy('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta') //la agrupacion era necesaria y tiene que ser especifica
           ->paginate(20);
           return view('ventas.venta.index',["ventas"=>$ventas,"searchText"=>$query,"nombre"=>$nombre]);
       }
    }
    public function create()
    {
        $personas=DB::table('persona')
        ->where('tipo_persona','=','Cliente')
        ->get();
          $articulos=DB::table('articulo as art')
          ->join('detalle_ingreso as di','art.idarticulo','=','di.idarticulo')
          ->select(/*DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo')*/'art.nombre AS articulo','art.idarticulo','art.stock','art.precio_venta','art.imagen','art.peso','art.empresa','art.codigo')//DB::raw('MAX(di.precio_venta) as precio_promedio')
          ->where('art.estado','=','Activo')
          ->where('art.stock','>','0')
          ->groupBy('articulo','art.idarticulo','art.stock','art.precio_venta','art.imagen','art.peso','art.empresa','art.codigo')
          ->get();
          $mytime = Carbon::now('America/La_Paz');
          return view('ventas.venta.create',["personas"=>$personas,"articulos"=>$articulos,"mytime"=>$mytime]);
    }
    public function store (VentaFormRequest $request)
    {
        $caja=DB::table('caja as c')
            ->select('c.estado')
            ->where('c.estado','=','Activo')
            ->get();
        $nopasa = "0";
        foreach ($caja as $c) {
                if($c){
                    $nopasa = '1';
                }
        }
        //dd($nopasa);

        if($nopasa=="1"){
            try{
                DB::beginTransaction();
                $venta = new Venta;
                $venta->idcliente=$request->get('idcliente');
                $venta->tipo_comprobante=$request->get('tipo_comprobante');
                $venta->serie_comprobante=$request->get('serie_comprobante');
                $venta->num_comprobante=$request->get('num_comprobante');
                $venta->total_venta=$request->get('total_venta');
                if(Gate::allows('isAdmin')){
                    $venta->fecha_hora=$request->get('mytime');
                } else {
                    $mytime = Carbon::now('America/La_Paz');
                    $venta->fecha_hora=$mytime->toDateTimeString();
                }
                $venta->impuesto='0.35';
                $venta->estado='A';
                $venta->save();

                $idarticulo=$request->get('idarticulo');
                $cantidad=$request->get('cantidad');
                $descuento=$request->get('descuento');
                $precio_venta=$request->get('precio_venta');

                $cont=0;
                while($cont<count($idarticulo)){
                    $detalle = new DetalleVenta();
                    $detalle->idventa=$venta->idventa;
                    $detalle->idarticulo=$idarticulo[$cont];
                    $detalle->cantidad=$cantidad[$cont];
                    $detalle->descuento=$descuento[$cont];
                    $detalle->precio_venta=$precio_venta[$cont];
                    $detalle->save();

                    $articulo=Articulo::findOrFail($idarticulo[$cont]);
                    event(new stockminEvent($articulo));

                    $cont=$cont+1;
                }
                DB::commit();

            }catch(\Exception $e){
                DB::rollback();
            }
        } else {
            Session::flash('message','primero habra caja');
            return Redirect::to('ventas/venta');
        }
        return Redirect::to('ventas/venta');
    }
    public function show(Request $request,$id){

        $venta=DB::table('venta as v')
        ->join('persona as p','v.idcliente','=','p.idpersona')
        ->join('detalle_venta as dv','v.idventa','=','dv.idventa')
        ->select('v.idventa','v.fecha_hora','p.nombre','v.tipo_comprobante','v.serie_comprobante','v.num_comprobante','v.impuesto','v.estado','v.total_venta')
        ->where('v.idventa','=',$id)
        //->groupBy('v.idventa', 'v.fecha_hora', 'p.nombre', 'v.tipo_comprobante', 'v.serie_comprobante','v.num_comprobante', 'v.impuesto', 'v.estado','v.total_venta')//esta fila puede eliminar o configurar
        ->first();
        $detalles=DB::table('detalle_venta as d')
        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
        ->select('a.nombre as articulo','d.cantidad','d.descuento','d.precio_venta')
        ->where('d.idventa','=',$id)
        ->get();

        $idshow=$id;

        $descarga_detalles=$request->get('descargar_detalles');
        if ($descarga_detalles == 1) {
            return (new DetallesVentaExport)->datos(
            $venta,
            $detalles,
            $idshow
            )->download('Detalles-venta-'.$venta->idventa.'.xlsx');
        }elseif ($descarga_detalles == 2) {
            $pdf = PDF::loadView('ventas.venta.detalles_venta',[
            "venta"=>$venta,
            "detalles"=>$detalles,
            'idshow'=>$idshow
            ]);
            return $pdf->stream('Detalles-venta-'.$venta->idventa.'.dpf');
        }else {
            return view("ventas.venta.show",["venta"=>$venta,"detalles"=>$detalles,'idshow'=>$idshow]);
        }
    }
    public function destroy($id){
        $venta=Venta::findOrFail($id);
        if($venta->estado=='C') {
            return Redirect::to('ventas/venta');
        } else {
            $venta->Estado='C';
            $venta->update();
            return Redirect::to('ventas/venta');
        }
    }
}

