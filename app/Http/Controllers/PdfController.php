<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\FormRequests;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade as PDF;

use Illuminate\Support\Facades\Redirect;
use App\Exports\UsersExport;
use App\User;
use App\Caja;
use App\Articulo;
use DB;

class PdfController extends Controller{
    
    public function exportPdf(){
        
        $users = User::get();
        $pdf = PDF::loadView('reportes.pdf.pdf1',compact('users'));
        return $pdf->stream('user-list.dpf'); // ->stream() genera el pdf en una vista antse de descargarla

    }
    public function exportPdfCaja(Request $request){
        
        $caja=DB::table('caja as c')
        ->join('tiene_i as ti','c.idcaja','=','ti.idcaja')
        ->join('tiene_v as tv','c.idcaja','=','tv.idcaja')
        ->join('users as u','c.encargado','=','u.id')
        ->select('c.idcaja','c.fecha_apertura','c.fecha_cierre','u.name','c.inicio','c.cierre_real','c.ingreso','c.estado')
        ->orderBy('c.idcaja','desc')
        ->groupBy('c.idcaja','c.fecha_apertura','c.fecha_cierre','u.name','c.inicio','c.cierre_real','c.ingreso','c.estado') //la agrupacion era necesaria y tiene que ser especifica
        ->get();

        $fecha_desde = $request->get('fecha_de');
        $fecha_asta = $request->get('fecha_asta');
        if($fecha_desde == null || $fecha_asta == null)
        {
            return Redirect::to('reportes');  
        }
        else{
                // •	Suma total_ventas por (efectivo) //
                $efectivo_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Efectivo')
                ->where('fecha_hora','>=',$fecha_desde)
                ->where('fecha_hora','<=',$fecha_asta)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (efectivo) //
                // •	Suma total_ventas por (Nota de venta) //
                $nota_venta=DB::table('venta')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$fecha_desde)
                ->where('fecha_hora','<=',$fecha_asta)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Nota de venta) //
                // •	Suma total_ventas por (Con tarjeta) //
                $con_tarjeta=DB::table('venta')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$fecha_desde)
                ->where('fecha_hora','<=',$fecha_asta)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ventas por (Con tarjeta) //
                //total ventas //
                $total_ingresos = $efectivo_venta + $nota_venta + $con_tarjeta;
                // •	Suma total_ingreso por (factura) //
                $factura_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','factura')
                ->where('fecha_hora','>=',$fecha_desde)
                ->where('fecha_hora','<=',$fecha_asta)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (factura) //
                // •	Suma total_ingreso por (Nota de venta) //
                $nota_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Nota de Venta')
                ->where('fecha_hora','>=',$fecha_desde)
                ->where('fecha_hora','<=',$fecha_asta)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (nota de venta) //
                // •	Suma total_ingreso por (tarjeta) //
                $tarjeta_ingreso=DB::table('ingreso')
                ->where('tipo_comprobante','=','Con tarjeta')
                ->where('fecha_hora','>=',$fecha_desde)
                ->where('fecha_hora','<=',$fecha_asta)
                ->where('estado','=','A')
                ->sum('total_venta');
                // 	fin Suma total_ingreso por (tarjeta) //
                // total ingresos //
                $total_egresos = $factura_ingreso + $nota_ingreso + $tarjeta_ingreso;

                $negocio=DB::table('negocio')
                ->where('idnegocio','=','1')
                ->get();

            $pdf = PDF::loadView('reportes.pdf.pdfCaja',['caja'=>$caja,
            'efectivo_venta'=>$efectivo_venta,
            'nota_venta'=>$nota_venta,
            'con_tarjeta'=>$con_tarjeta,
            'total_ingresos'=>$total_ingresos,

            'factura_ingreso'=>$factura_ingreso,
            'nota_ingreso'=>$nota_ingreso,
            'tarjeta_ingreso'=>$tarjeta_ingreso,
            'total_egresos'=>$total_egresos,

            'negocio'=>$negocio,
            'fecha_desde'=>$fecha_desde,
            'fecha_asta'=>$fecha_asta
            ]);
            return $pdf->stream('caja.dpf'); // ->dowload() genera el pdf directo en una descarga
        }

    }

    
}