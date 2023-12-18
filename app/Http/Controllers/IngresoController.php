<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Barryvdh\DomPDF\Facade as PDF;
use App\Exports\DetallesIngresoExport;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\IngresoFormRequest;
use App\Articulo;
use App\Ingreso;
use App\DetalleIngreso;
use DB;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

class IngresoController extends Controller
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
           $ingresos=DB::table('ingreso as i')
           ->join('persona as p','i.idproveedor','=','p.idpersona')
           ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
           ->join('users as u','i.idusuario','=','u.id')
           // ACA CAMBIAR EL SELECT CCON EL NUEVO TOTALVENTA
           ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','total_venta','i.obserbacion','i.detalles',DB::raw('sum(di.cantidad*precio_compra)as total'),'u.name','i.anuladopor')
           ->where('i.num_comprobante','LIKE','%'.$query.'%')
           ->orwhere('p.nombre','LIKE','%'.$query.'%')
           ->orwhere('i.idingreso','LIKE','%'.$query.'%')
           ->orwhere('i.fecha_hora','LIKE','%'.$query.'%')
           ->orderBy('i.idingreso','desc')
           // ACA CAMBIAR EL GROUP BY CCON EL NUEVO TOTALVENTA
           ->groupBy('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','total_venta','i.obserbacion','i.detalles','u.name','i.anuladopor')
           ->paginate(20);
           return view('compras.ingreso.index',["ingresos"=>$ingresos,"searchText"=>$query,"nombre"=>$query]);
       }
    }
    public function create()
    {
        $categorias=DB::table('categoria')->where('condicion','=','1')->get();
        $personas=DB::table('persona')
        ->where('tipo_persona','=','Proveedor')
        ->get();
        $articulos=DB::table('articulo as art')
          ->select(/*DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo')*/'art.nombre AS articulo','art.idarticulo','art.precio_venta','art.precio_compra','art.peso','art.stock','art.empresa')
          ->where('art.estado','=','Activo')
          ->get();
        $mytime = Carbon::now('America/La_Paz');
          return view('compras.ingreso.create',["personas"=>$personas,"articulos"=>$articulos,"categorias"=>$categorias,"mytime"=>$mytime]);
    }
    public function store (IngresoFormRequest $request)
    {
        try{
            DB::beginTransaction();
            $proveedor=$request->get('idproveedor');
            
            $ingreso=new Ingreso;
            $obserbacion=0;
            $no_obserbado=0;
            $ingreso->idproveedor=$request->get('idproveedor');
            $ingreso->idusuario = auth()->user()->id;
            $ingreso->tipo_comprobante=$request->get('tipo_comprobante');
            $ingreso->serie_comprobante=$request->get('serie_comprobante');
            $ingreso->num_comprobante=$request->get('num_comprobante');
            $ingreso->total_venta=$request->get('total_venta');
            $ingreso->detalles=$request->get('detalles-ingreso');
            $no_obserbado=$request->get('total_ventaO');
            $obserbacion=$request->get('total_venta');
            if( $obserbacion > $no_obserbado or $obserbacion < $no_obserbado){
                $ingreso->obserbacion="observado";
            }
            else{
                $ingreso->obserbacion="";
            };
            if(Gate::allows('isAdmin')){
                $ingreso->fecha_hora=$request->get('mytime');
            } else {
                $mytime = Carbon::now('America/La_Paz');
                $ingreso->fecha_hora=$mytime->toDateTimeString();
            }
            $ingreso->impuesto='0.35';
            $ingreso->estado='A';
            
            $ingreso->save();

            $idarticulo=$request->get('idarticulo');
            $cantidad=$request->get('cantidad');
            $precio_compra=$request->get('precio_compra');
            $precio_venta=$request->get('precio_venta');
            $fecha_vencimiento=$request->get('fecha_vencimiento');
            $peso=$request->get('peso');
            
            $personas=DB::table('persona')
            ->where('tipo_persona','=','Proveedor')
            ->get();
            foreach ($personas as $per){
                if($per->idpersona == $proveedor){
                    $proveedor = $per->nombre;
                }
            }
            $cont=0;
            while($cont<count($idarticulo)){
                $detalle = new DetalleIngreso();
                $detalle->idingreso=$ingreso->idingreso;
                $detalle->idarticulo=$idarticulo[$cont];
                $detalle->cantidad=$cantidad[$cont];
                $detalle->precio_compra=$precio_compra[$cont];
                $detalle->precio_venta=$precio_venta[$cont];
                $detalle->fecha_vencimiento=$fecha_vencimiento[$cont];
                $detalle->peso=$peso[$cont];
                $detalle->proveedor=$proveedor;
                $articulo=Articulo::findOrFail($idarticulo[$cont]);
                $detalle->habia_stock=$articulo->stock;
                $detalle->total_stock=$articulo->stock+$cantidad[$cont];
                $detalle->save();
                $cont=$cont+1;
            }
            DB::commit();
        
        }catch(\Exception $e){
            DB::rollback();
            print("error");
        }
        return Redirect::to('compras/ingreso');
    }
    public function show(Request $request,$id){
        $ingreso=DB::table('ingreso as i')
        ->join('persona as p','i.idproveedor','=','p.idpersona')
        ->join('detalle_ingreso as di','i.idingreso','=','di.idingreso')
        ->select('i.idingreso','i.fecha_hora','p.nombre','i.tipo_comprobante','i.serie_comprobante','i.num_comprobante','i.impuesto','i.estado','total_venta','i.detalles')//,DB::raw('sum(di.cantidad*precio_compra)as total'))        
        ->where('i.idingreso','=',$id)
        ->groupBy('i.idingreso', 'i.fecha_hora', 'p.nombre', 'i.tipo_comprobante', 'i.serie_comprobante','i.num_comprobante', 'i.impuesto', 'i.estado','total_venta','i.detalles')
        ->first();
        $detalles=DB::table('detalle_ingreso as d')
        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
        ->select('a.idarticulo','a.nombre as articulo','d.cantidad','d.precio_compra','d.precio_venta','d.fecha_vencimiento','a.peso','d.habia_stock','d.total_stock')
        ->where('d.idingreso','=',$id)
        ->get();

        $idshow=$id;

        $descarga_detalles=$request->get('descargar_detalles');
        if ($descarga_detalles == 1) {
            return (new DetallesIngresoExport)->datos(
            $ingreso,
            $detalles,
            $idshow
            )->download('Detalles-ingreso-'.$ingreso->idingreso.'.xlsx');
        }elseif ($descarga_detalles == 2) {
            $pdf = PDF::loadView('compras.ingreso.detalles_ingreso',[
            "ingreso"=>$ingreso,
            "detalles"=>$detalles,
            'idshow'=>$idshow
            ]);
            return $pdf->stream('Detalles-ingreso-'.$ingreso->idingreso.'.pdf');
        }else {
            return view("compras.ingreso.show",["ingreso"=>$ingreso,"detalles"=>$detalles,'idshow'=>$idshow]);
        }
    }
    public function destroy($id){
        $ingreso=Ingreso::findOrFail($id);
        if($ingreso->estado=='C') {
            return Redirect::to('compras/ingreso');
        } else {
            $ingreso->Estado='C';
            $ingreso->anuladopor = auth()->user()->name;
            $ingreso->update();

            $detalles=DB::table('detalle_ingreso as d')
            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
            ->select('a.idarticulo','a.nombre as articulo','d.cantidad',DB::raw('sum(d.cantidad)as total'))
            ->where('d.idingreso','=',$id)
            ->orderBy('a.idarticulo','desc')
            ->groupBy('a.idarticulo','a.nombre','d.cantidad')
            ->get();
            foreach ($detalles as $de) {
                $articulo=Articulo::findOrFail($de->idarticulo);
                $articulo->stock=$articulo->stock-$de->total;
                $articulo->update();
            }
            return Redirect::to('compras/ingreso');
        }
        
    }
}
