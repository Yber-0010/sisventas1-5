<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class CajaListaArticulosExport implements FromView, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $caja, $total_ingresos, $articulos_vendidos, $cantidad_total_ventas, $descuento_total_ventas, $cantidad_total_ingresos, 
    $pedidos,
    $deposito_pedido,
    $articulos_pedidos,
    $cantidad_total_pedidos,
    $descuento_total_pedidos;

    public function datos($caja, $total_ingresos, $articulos_vendidos, $cantidad_total_ventas, $descuento_total_ventas, $cantidad_total_ingresos, 
    /* pedidos */
    $pedidos,
    $deposito_pedido,
    $articulos_pedidos,
    $cantidad_total_pedidos,
    $descuento_total_pedidos){
        $this->caja = $caja;
        $this->total_ingresos = $total_ingresos;
        $this->articulos_vendidos = $articulos_vendidos;
        $this->cantidad_total_ventas = $cantidad_total_ventas;
        $this->descuento_total_ventas = $descuento_total_ventas;
        $this->cantidad_total_ingresos = $cantidad_total_ingresos;
        /* pedidos */
        /* pedidos */
        $this->pedidos = $pedidos;
        $this->deposito_pedido = $deposito_pedido;
        $this->articulos_pedidos = $articulos_pedidos;
        $this->cantidad_total_pedidos = $cantidad_total_pedidos;
        $this->descuento_total_pedidos = $descuento_total_pedidos;
        return $this;
    }

    public function view(): View
    {
        return view('caja.partial1.sventas_articulo',[
            'caja'=>$this->caja,
            'total_ingresos'=>$this->total_ingresos, 
            'articulos_vendidos'=>$this->articulos_vendidos,
            'cantidad_total_ventas'=>$this->cantidad_total_ventas, 
            'descuento_total_ventas'=>$this->descuento_total_ventas, 
            'cantidad_total_ingresos'=>$this->cantidad_total_ingresos,
            'pedidos'=>$this->pedidos,
            'deposito_pedido'=>$this->deposito_pedido,
            'articulos_pedidos'=>$this->articulos_pedidos,
            'cantidad_total_pedidos'=>$this->cantidad_total_pedidos,
            'descuento_total_pedidos'=>$this->descuento_total_pedidos,
        ]);
    }
}
