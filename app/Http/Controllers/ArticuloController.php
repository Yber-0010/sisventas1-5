<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Session;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
//use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\Http\Requests\ArticuloFormRequest;
use App\Notifications\InvoicePaid;
use App\Articulo;
use App\User;
use App\Notifications\ArticuloNotificacion;
use App\Events\ArticuloCrearEvent;
use App\Events\ArticuloActualizadoEvent;
use DB;
use Illuminate\Support\Facades\Notification;

class ArticuloController extends Controller
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
           $nombre = $query;
           $estado = $request->get('estado');
           //$estado2 = $request->get('estado2');
           
           if ($estado == '1') {
                /* ACTIVOS */
                $articulos=DB::table('articulo as a')
                ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado','a.precio_venta','a.precio_compra','a.empresa','a.peso','a.created_at','a.updated_at','a.alerta_dias')
                ->where([['a.nombre','LIKE','%'.$query.'%'],['a.estado','=','Activo'],])
                ->orwhere([['a.idarticulo','LIKE','%'.$query.'%'],['a.estado','=','Activo'],])
                ->orwhere([['c.nombre','LIKE','%'.$query.'%'],['a.estado','=','Activo'],])// por nombre de articulo se debe mejorar pero
                ->orwhere([['a.empresa','LIKE','%'.$query.'%'],['a.estado','=','Activo'],])
                ->orderBy('a.idarticulo','desc')
                ->paginate(20);    
           } elseif ($estado == '2') {
                /* INACTIVOS */
                $articulos=DB::table('articulo as a')
                ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado','a.precio_venta','a.precio_compra','a.empresa','a.peso','a.created_at','a.updated_at','a.alerta_dias')
                ->where([['a.nombre','LIKE','%'.$query.'%'],['a.estado','=','Inactivo'],])
                ->orwhere([['a.idarticulo','LIKE','%'.$query.'%'],['a.estado','=','Inactivo'],])
                ->orwhere([['c.nombre','LIKE','%'.$query.'%'],['a.estado','=','Inactivo'],])// por nombre de articulo se debe mejorar pero
                ->orwhere([['a.empresa','LIKE','%'.$query.'%'],['a.estado','=','Inactivo'],])
                ->orderBy('a.idarticulo','desc')
                ->paginate(20);
           } else {
               /* activos e inactivos */
               $articulos=DB::table('articulo as a')
               ->join('categoria as c','a.idcategoria','=','c.idcategoria')
               ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado','a.precio_venta','a.precio_compra','a.empresa','a.peso','a.created_at','a.updated_at','a.alerta_dias')
               ->where('a.nombre','LIKE','%'.$query.'%')
               ->orwhere('a.idarticulo','LIKE','%'.$query.'%')
               ->orwhere('c.nombre','LIKE','%'.$query.'%')// por nombre de articulo se debe mejorar pero
               ->orwhere('a.empresa','LIKE','%'.$query.'%')
               ->orderBy('a.idarticulo','desc')
               ->paginate(20);
           }
           

           return view('almacen.articulo.index',["articulos"=>$articulos,"searchText"=>$query,"nombre"=>$query,'estado'=>$estado]);

       }
    }
    public function create()
    {
        $categorias=DB::table('categoria')->where('condicion','=','1')->get();
        $personas=DB::table('persona')
           ->where('tipo_persona','=','Proveedor')
           ->orderBy('idpersona','desc')
           ->get();
        return view("almacen.articulo.create",["categorias"=>$categorias,"personas"=>$personas]);
    }
    public function store(ArticuloFormRequest $request)
    {

        $articulo= new Articulo;
        $mytime = Carbon::now('America/La_Paz');
        $articulo->created_at=$mytime/* ->toDateTimeString() */;
        $articulo->idcategoria=$request->get('idcategoria');
        $articulo->codigo=$request->get('codigo');
        $dias=$request->get('alerta_dias');
        if ( $dias%1==0 ) {
            $articulo->alerta_dias=$dias;
        }
        $articulo->nombre=$request->get('nombre');
        $articulo->stock_min=$request->get('stock_min');
        $articulo->stock_max=$request->get('stock_max');
        $articulo->nombre=strtolower($articulo->nombre);
        $articulo->descripcion=$request->get('descripcion');
        $articulo->stock=0;
        //$articulo->stock=$request->get('stock');
        $articulo->precio_compra=0;
        //$articulo->precio_compra=$request->get('precio_compra');
        $articulo->precio_venta=0;
        //$articulo->precio_venta=$request->get('precio_venta');
        $articulo->peso=$request->get('peso');
        $articulo->empresa=$request->get('empresa');
        $articulo->estado='Activo';
        
        //if(Input::hasFile('imagen')){
        if($request->file('imagen')){
            $file = $request->file('imagen');
            //$file=Input::file('imagen');
            $file->move('imagenes/articulos/',$file->getClientOriginalName());
            $articulo->imagen=$file->getClientOriginalName();
        }

        $articulo->save();
/*  */
 /* notifica articulo creado */
        event(new ArticuloCrearEvent($articulo));
/*  */
        //Obtencion de ruta desde la vista con exito
        $ruta=$request->get('ruta');
        if($ruta==''){
            return Redirect::to('almacen/articulo');  
        }
        else{
            return Redirect::to($ruta);  
        }
        ////////////// fin obtencion de la ruta/////
        //$ruta=$request->path();///obtencion de la ruta de esta vista en base a la funcion
    }
    public function show($id)
    {
        return view("almacen.articulo.show",["articulo"=>Articulo::findOrFail($id)]);
    }
    public function edit($id)
    {
        $articulo=Articulo::findOrFail($id);
        $categorias=DB::table('categoria')->where('condicion','=','1')->get();   
        $personas=DB::table('persona')
        ->where('tipo_persona','=','Proveedor')
        ->orderBy('idpersona','desc')
        ->get();
        return view("almacen.articulo.edit",["articulo"=>$articulo,"categorias"=>$categorias,"personas"=>$personas]);
    }
    public function update(ArticuloFormRequest $request,$id)
    {
        $articulo=Articulo::findOrFail($id);

        $articulo->idcategoria=$request->get('idcategoria');
        $articulo->stock_min=$request->get('stock_min');
        $articulo->stock_max=$request->get('stock_max');
        $articulo->codigo=$request->get('codigo');
        $dias=$request->get('alerta_dias');
        if ( $dias%1==0 ) {
            $articulo->alerta_dias=$dias;
        }
        $articulo->nombre=$request->get('nombre');
        $articulo->nombre=strtolower($articulo->nombre);
        $mytime = Carbon::now('America/La_Paz');
        $articulo->updated_at=$mytime/* ->toDateTimeString() */;
        if(Gate::allows('isAdmin')){
        $articulo->stock=$request->get('stock');
        $articulo->precio_compra=$request->get('precio_compra');
        $articulo->precio_venta=$request->get('precio_venta');
        }
        $articulo->descripcion=$request->get('descripcion');
        $articulo->peso=$request->get('peso');
        $articulo->empresa=$request->get('empresa');

        //if(Input::hasFile('imagen')){
            if($request->file('imagen')){
                
                $file = $request->file('imagen');
                //$file=Input::file('imagen');
                $file->move('imagenes/articulos/',$file->getClientOriginalName());//aca el publi_path cambie para public_html_path para ver si asi funciona en el servidor
                $articulo->imagen=$file->getClientOriginalName();
            }


        $articulo->update();
        event(new ArticuloActualizadoEvent($articulo));
        $ruta=$request->get('ruta');
        
        return Redirect::to($ruta);
    }
    public function destroy($id)
    {

        $ruta = URL::previous();
        $articulo=Articulo::findOrFail($id);

        if($articulo->estado=='Inactivo'){
            $articulo->estado='Activo';
        }else{
            $articulo->estado='Inactivo';
        }
        $articulo->update();
        //return Redirect::to('almacen/articulo');
        return Redirect::to($ruta);
    }
    
}
