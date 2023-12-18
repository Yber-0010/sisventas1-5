<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class CajaExport implements FromView, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private 
    $caja,
    $encargado,
    $ventas,
    $efectivo_venta,
    $nota_venta,
    $con_tarjeta,
    $pedidos,
    $deposito_pedido,
    /* ventas articulos */
    $total_ingresos,
    $articulos_vendidos,
    $cantidad_total_ventas,
    $descuento_total_ventas,
    $cantidad_total_ingresos,
    /* ingresos */
    $ingresos,
    $factura_ingreso,
    $nota_ingreso,
    $tarjeta_ingreso,
    /* ingresos articulos */
    $detalles_ingresados,
    /* caja */
    $total_egresos;

    public function datos(
        $caja,
        $encargado,
        $ventas,
        $efectivo_venta,
        $nota_venta,
        $con_tarjeta,
        $pedidos,
        $deposito_pedido,
        /* ventas articulos */
        $total_ingresos,
        $articulos_vendidos,
        $cantidad_total_ventas,
        $descuento_total_ventas,
        $cantidad_total_ingresos,
        /* ingresos */
        $ingresos,
        $factura_ingreso,
        $nota_ingreso,
        $tarjeta_ingreso,
        /* ingresos articulos */
        $detalles_ingresados,
        /* caja */
        $total_egresos
    ){
        $this->caja=$caja;
        $this->encargado=$encargado;
        $this->ventas=$ventas;
        $this->efectivo_venta=$efectivo_venta;
        $this->nota_venta=$nota_venta;
        $this->con_tarjeta=$con_tarjeta;
        $this->pedidos=$pedidos;
        $this->deposito_pedido=$deposito_pedido;
        /* ventas articulos */
        $this->total_ingresos=$total_ingresos;
        $this->articulos_vendidos=$articulos_vendidos;
        $this->cantidad_total_ventas=$cantidad_total_ventas;
        $this->descuento_total_ventas=$descuento_total_ventas;
        $this->cantidad_total_ingresos=$cantidad_total_ingresos;
        /* ingresos */
        $this->ingresos=$ingresos;
        $this->factura_ingreso=$factura_ingreso;
        $this->nota_ingreso=$nota_ingreso;
        $this->tarjeta_ingreso=$tarjeta_ingreso;
        /* ingresos articulos */
        $this->detalles_ingresados=$detalles_ingresados;
        /* caja */
        $this->total_egresos=$total_egresos;
        return $this;
    }

    public function view(): View
    {
        return view('caja.cajas.reporte-caja',[
            'caja'=>$this->caja,
            'encargado'=>$this->encargado,
            'ventas'=>$this->ventas,
            'efectivo_venta'=>$this->efectivo_venta,
            'nota_venta'=>$this->nota_venta,
            'con_tarjeta'=>$this->con_tarjeta,
            'pedidos'=>$this->pedidos,
            'deposito_pedido'=>$this->deposito_pedido,
            /* ventas articulos */
            'total_ingresos'=>$this->total_ingresos,
            'articulos_vendidos'=>$this->articulos_vendidos,
            'cantidad_total_ventas'=>$this->cantidad_total_ventas,
            'descuento_total_ventas'=>$this->descuento_total_ventas,
            'cantidad_total_ingresos'=>$this->cantidad_total_ingresos,
            /* ingresos */
            'ingresos'=>$this->ingresos,
            'factura_ingreso'=>$this->factura_ingreso,
            'nota_ingreso'=>$this->nota_ingreso,
            'tarjeta_ingreso'=>$this->tarjeta_ingreso,
            /* ingresos articulos */
            'detalles_ingresados'=>$this->detalles_ingresados,
            /* caja */
            'total_egresos'=>$this->total_egresos
        ]);
    }
}
