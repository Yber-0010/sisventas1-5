<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Redirect;
use DB;

class ConsultasController extends Controller
{
    
    public function __construct() {
        $this->middleware('auth');
    }

    public function productosVendidos(Request $request) {
        if($request) {

            $nombre="";
            $fecha_de = $request->get('fecha_de');
            $fecha_asta = $request->get('fecha_asta');
            $buscarPor = $request->get('buscarPor');// 1,2,3,4
            $proveedor2 = $request->get('proveedor');
            $categoria = $request->get('categoria');
            $codigoProducto = $request->get('codigoProducto');
            $nombreProducto = $request->get('nombreProducto');
            $proveedor = DB::table('persona')
                            ->where('tipo_persona','=','Proveedor')
                            ->get();
            $categorias = DB::table('categoria')
                            ->select('nombre')
                            ->get();
            $articulos_vendidos = "";
            $articulos_pedidos = "";
            switch ($buscarPor) {
                case '1':
                    $nombre=$proveedor2;
                    /* nos quedamos aca en las consultas sql */
                    $articulos_vendidos = DB::table('detalle_venta as d')
                                            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                            ->join('venta as v','d.idventa','=','v.idventa')
                                            ->select('a.idarticulo','a.nombre as articulo','a.stock','a.precio_compra','a.peso','a.empresa','a.precio_venta',DB::raw('sum(d.cantidad)as total'))
                                            ->where( 'v.fecha_hora','>=',$fecha_de)
                                            ->where( 'v.fecha_hora','<=',$fecha_asta)
                                            ->where('a.empresa','=',$proveedor2)
                                            ->where('v.estado','=','A')
                                            ->orderBy('a.idarticulo','desc')
                                            ->groupBy('a.idarticulo','a.nombre','a.precio_venta','a.stock','a.precio_compra','a.peso','a.empresa')
                                            ->get();
                    $articulos_pedidos = DB::table('detalle_pedido as d')
                                            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                            ->join('pedido as p','d.idpedido','=','p.id')
                                            ->select('a.idarticulo','a.nombre as articulo','a.stock','a.precio_compra','a.peso','a.empresa','a.precio_venta',DB::raw('sum(d.cantidad)as total'))
                                            ->where( 'p.fecha_hora_finalizado','>=',$fecha_de)
                                            ->where( 'p.fecha_hora_finalizado','<=',$fecha_asta)
                                            ->where('a.empresa','=',$proveedor2)
                                            ->where('p.estado','=','FINALIZADO')
                                            ->orderBy('a.idarticulo','desc')
                                            ->groupBy('a.idarticulo','a.nombre','a.precio_venta','a.stock','a.precio_compra','a.peso','a.empresa')
                                            ->get();
                    break;
                case '2':
                    $nombre=$categoria;
                    $articulos_vendidos = DB::table('detalle_venta as d')
                                            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                            ->join('venta as v','d.idventa','=','v.idventa')
                                            ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                            ->select('a.idarticulo','a.nombre as articulo','a.stock','a.precio_compra','a.peso','a.empresa','a.precio_venta',DB::raw('sum(d.cantidad)as total'))
                                            ->where( 'v.fecha_hora','>=',$fecha_de)
                                            ->where( 'v.fecha_hora','<=',$fecha_asta)
                                            ->where('c.nombre','=',$categoria)
                                            ->where('v.estado','=','A')
                                            ->orderBy('a.idarticulo','desc')
                                            ->groupBy('a.idarticulo','a.nombre','a.precio_venta','a.stock','a.precio_compra','a.peso','a.empresa')
                                            ->get();
                    $articulos_pedidos = DB::table('detalle_pedido as d')
                                            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                            ->join('pedido as p','d.idpedido','=','p.id')
                                            ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                            ->select('a.idarticulo','a.nombre as articulo','a.stock','a.precio_compra','a.peso','a.empresa','a.precio_venta',DB::raw('sum(d.cantidad)as total'))
                                            ->where( 'p.fecha_hora_finalizado','>=',$fecha_de)
                                            ->where( 'p.fecha_hora_finalizado','<=',$fecha_asta)
                                            ->where('c.nombre','=',$categoria)
                                            ->where('p.estado','=','FINALIZADO')
                                            ->orderBy('a.idarticulo','desc')
                                            ->groupBy('a.idarticulo','a.nombre','a.precio_venta','a.stock','a.precio_compra','a.peso','a.empresa')
                                            ->get();
                    
                    break;
                case '3':
                    $nombre=$codigoProducto;
                    $articulos_vendidos = DB::table('detalle_venta as d')
                                            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                            ->join('venta as v','d.idventa','=','v.idventa')
                                            ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                            ->select('a.idarticulo','a.nombre as articulo','a.stock','a.precio_compra','a.peso','a.empresa','a.precio_venta',DB::raw('sum(d.cantidad)as total'))
                                            ->where( 'v.fecha_hora','>=',$fecha_de)
                                            ->where( 'v.fecha_hora','<=',$fecha_asta)
                                            ->where('a.idarticulo','=',$codigoProducto)
                                            ->where('v.estado','=','A')
                                            ->orderBy('a.idarticulo','desc')
                                            ->groupBy('a.idarticulo','a.nombre','a.precio_venta','a.stock','a.precio_compra','a.peso','a.empresa')
                                            ->get();
                    $articulos_pedidos = DB::table('detalle_pedido as d')
                                            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                            ->join('pedido as p','d.idpedido','=','p.id')
                                            ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                            ->select('a.idarticulo','a.nombre as articulo','a.stock','a.precio_compra','a.peso','a.empresa','a.precio_venta',DB::raw('sum(d.cantidad)as total'))
                                            ->where( 'p.fecha_hora_finalizado','>=',$fecha_de)
                                            ->where( 'p.fecha_hora_finalizado','<=',$fecha_asta)
                                            ->where('a.idarticulo','=',$codigoProducto)
                                            ->where('p.estado','=','FINALIZADO')
                                            ->orderBy('a.idarticulo','desc')
                                            ->groupBy('a.idarticulo','a.nombre','a.precio_venta','a.stock','a.precio_compra','a.peso','a.empresa')
                                            ->get();
                    break;
                case '4':
                    $nombre=$nombreProducto;
                    $articulos_vendidos = DB::table('detalle_venta as d')
                                            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                            ->join('venta as v','d.idventa','=','v.idventa')
                                            ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                            ->select('a.idarticulo','a.nombre as articulo','a.stock','a.precio_compra','a.peso','a.empresa','a.precio_venta',DB::raw('sum(d.cantidad)as total'))
                                            ->where( 'v.fecha_hora','>=',$fecha_de)
                                            ->where( 'v.fecha_hora','<=',$fecha_asta)
                                            ->where('a.nombre','LIKE','%'.$nombreProducto.'%')
                                            ->where('v.estado','=','A')
                                            ->orderBy('a.idarticulo','desc')
                                            ->groupBy('a.idarticulo','a.nombre','a.precio_venta','a.stock','a.precio_compra','a.peso','a.empresa')
                                            ->get();
                    $articulos_pedidos = DB::table('detalle_pedido as d')
                                            ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                            ->join('pedido as p','d.idpedido','=','p.id')
                                            ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                            ->select('a.idarticulo','a.nombre as articulo','a.stock','a.precio_compra','a.peso','a.empresa','a.precio_venta',DB::raw('sum(d.cantidad)as total'))
                                            ->where( 'p.fecha_hora_finalizado','>=',$fecha_de)
                                            ->where( 'p.fecha_hora_finalizado','<=',$fecha_asta)
                                            ->where('a.nombre','LIKE','%'.$nombreProducto.'%')
                                            ->where('p.estado','=','FINALIZADO')
                                            ->orderBy('a.idarticulo','desc')
                                            ->groupBy('a.idarticulo','a.nombre','a.precio_venta','a.stock','a.precio_compra','a.peso','a.empresa')
                                            ->get();
                    break;
                
                default:
                    $articulos_vendidos = "";
                    $articulos_pedidos = "";
                    break;
            }
            return view('/consultas/productos-vendidos', [
                "proveedor"=>$proveedor,
                "nombre"=>$nombre,
                "categorias"=>$categorias,
                "fecha_de"=>$fecha_de,
                "fecha_asta"=>$fecha_asta,
                "codigoProducto"=>$codigoProducto,
                "nombreProducto"=>$nombreProducto,
                "articulos_vendidos"=>$articulos_vendidos,
                "articulos_pedidos"=>$articulos_pedidos,
                "buscarPor"=>$buscarPor
            ]);
        }
    }
    public function show($id,$fecha_de,$fecha_asta,$nombre,$buscarPor) {

        //$fecha_de = $de;
        //$fecha_asta = $asta;
        //$proveedor2 = $pro2;
        //dd($buscarPor);
        switch ($buscarPor) {
            case '1':
                $articulos_vendidos = DB::table('detalle_venta as d')
                                        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                        ->join('venta as v','d.idventa','=','v.idventa')
                                        ->select('a.idarticulo','d.cantidad','a.nombre as articulo','a.stock','d.precio_venta','a.precio_compra','v.fecha_hora','a.peso','d.descuento','a.empresa')
                                        ->where( 'v.fecha_hora','>=',$fecha_de)
                                        ->where( 'v.fecha_hora','<=',$fecha_asta)
                                        ->where('a.empresa','=',$nombre)
                                        ->where('a.idarticulo','=',$id)
                                        ->where('v.estado','=','A')
                                        ->orderBy('a.idarticulo','desc')
                                        ->get();
                $articulos_pedidos = DB::table('detalle_pedido as d')
                                        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                        ->join('pedido as p','d.idpedido','=','p.id')
                                        ->select('a.idarticulo','d.cantidad','a.nombre as articulo','a.stock','d.precio_venta','a.precio_compra','p.fecha_hora_finalizado','a.peso','d.descuento','a.empresa')
                                        ->where( 'p.fecha_hora_finalizado','>=',$fecha_de)
                                        ->where( 'p.fecha_hora_finalizado','<=',$fecha_asta)
                                        ->where('a.idarticulo','=',$id)
                                        ->where('a.empresa','=',$nombre)
                                        ->where('p.estado','=','FINALIZADO')
                                        ->orderBy('a.idarticulo','desc')
                                        ->get();
                break;
            case '2':
                $articulos_vendidos = DB::table('detalle_venta as d')
                                        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                        ->join('venta as v','d.idventa','=','v.idventa')
                                        ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                        ->select('a.idarticulo','d.cantidad','a.nombre as articulo','a.stock','d.precio_venta','a.precio_compra','v.fecha_hora','a.peso','d.descuento','a.empresa')
                                        ->where( 'v.fecha_hora','>=',$fecha_de)
                                        ->where( 'v.fecha_hora','<=',$fecha_asta)
                                        ->where('c.nombre','=',$nombre)
                                        ->where('a.idarticulo','=',$id)
                                        ->where('v.estado','=','A')
                                        ->orderBy('a.idarticulo','desc')
                                        ->get();
                $articulos_pedidos = DB::table('detalle_pedido as d')
                                        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                        ->join('pedido as p','d.idpedido','=','p.id')
                                        ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                        ->select('a.idarticulo','d.cantidad','a.nombre as articulo','a.stock','d.precio_venta','a.precio_compra','p.fecha_hora_finalizado','a.peso','d.descuento','a.empresa')
                                        ->where( 'p.fecha_hora_finalizado','>=',$fecha_de)
                                        ->where( 'p.fecha_hora_finalizado','<=',$fecha_asta)
                                        ->where('a.idarticulo','=',$id)
                                        ->where('c.nombre','=',$nombre)
                                        ->where('p.estado','=','FINALIZADO')
                                        ->orderBy('a.idarticulo','desc')
                                        ->get();
                break;
            case '3':
                $articulos_vendidos = DB::table('detalle_venta as d')
                                        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                        ->join('venta as v','d.idventa','=','v.idventa')
                                        ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                        ->select('a.idarticulo','d.cantidad','a.nombre as articulo','a.stock','d.precio_venta','a.precio_compra','v.fecha_hora','a.peso','d.descuento','a.empresa')
                                        ->where( 'v.fecha_hora','>=',$fecha_de)
                                        ->where( 'v.fecha_hora','<=',$fecha_asta)
                                        ->where('a.idarticulo','=',$nombre)
                                        ->where('a.idarticulo','=',$nombre)
                                        ->where('v.estado','=','A')
                                        ->orderBy('a.idarticulo','desc')
                                        ->get();
                $articulos_pedidos = DB::table('detalle_pedido as d')
                                        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                        ->join('pedido as p','d.idpedido','=','p.id')
                                        ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                        ->select('a.idarticulo','d.cantidad','a.nombre as articulo','a.stock','d.precio_venta','a.precio_compra','p.fecha_hora_finalizado','a.peso','d.descuento','a.empresa')
                                        ->where( 'p.fecha_hora_finalizado','>=',$fecha_de)
                                        ->where( 'p.fecha_hora_finalizado','<=',$fecha_asta)
                                        ->where('a.idarticulo','=',$nombre)
                                        ->where('p.estado','=','FINALIZADO')
                                        ->orderBy('a.idarticulo','desc')
                                        ->get();
                break;
            case '4':
                $articulos_vendidos = DB::table('detalle_venta as d')
                                        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                        ->join('venta as v','d.idventa','=','v.idventa')
                                        ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                        ->select('a.idarticulo','d.cantidad','a.nombre as articulo','a.stock','d.precio_venta','a.precio_compra','v.fecha_hora','a.peso','d.descuento','a.empresa')
                                        ->where( 'v.fecha_hora','>=',$fecha_de)
                                        ->where( 'v.fecha_hora','<=',$fecha_asta)
                                        ->where('a.nombre','LIKE','%'.$nombre.'%')
                                        ->where('a.idarticulo','=',$id)
                                        ->where('v.estado','=','A')
                                        ->orderBy('a.idarticulo','desc')
                                        ->get();
                $articulos_pedidos = DB::table('detalle_pedido as d')
                                        ->join('articulo as a','d.idarticulo','=','a.idarticulo')
                                        ->join('pedido as p','d.idpedido','=','p.id')
                                        ->join('categoria as c','a.idcategoria','=','c.idcategoria')
                                        ->select('a.idarticulo','d.cantidad','a.nombre as articulo','a.stock','d.precio_venta','a.precio_compra','p.fecha_hora_finalizado','a.peso','d.descuento','a.empresa')
                                        ->where( 'p.fecha_hora_finalizado','>=',$fecha_de)
                                        ->where( 'p.fecha_hora_finalizado','<=',$fecha_asta)
                                        ->where('a.idarticulo','=',$id)
                                        ->where('a.nombre','LIKE','%'.$nombre.'%')
                                        ->where('p.estado','=','FINALIZADO')
                                        ->orderBy('a.idarticulo','desc')
                                        ->get();
                break;
            default:
                $articulos_vendidos = "";
                $articulos_pedidos = "";                
                break;
        }
        
        
        return view('/consultas/show', ["articulos_vendidos"=>$articulos_vendidos,"articulos_pedidos"=>$articulos_pedidos]);
    }
}
