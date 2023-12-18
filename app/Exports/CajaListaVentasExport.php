<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class CajaListaVentasExport implements FromView, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $caja, $ventas, $efectivo_venta, $nota_venta, $con_tarjeta, $pedidos, $deposito_pedido;

    public function datos($caja, $ventas, $efectivo_venta, $nota_venta, $con_tarjeta, $pedidos, $deposito_pedido){
        $this->caja = $caja;
        $this->ventas = $ventas;
        $this->efectivo_venta = $efectivo_venta;
        $this->nota_venta = $nota_venta;
        $this->con_tarjeta = $con_tarjeta;
        $this->pedidos = $pedidos;
        $this->deposito_pedido = $deposito_pedido;
        return $this;
    }

    public function view(): View
    {
        return view('caja.partial1.sventas',[
            'caja'=>$this->caja,
            'ventas'=>$this->ventas,
            'efectivo_venta'=>$this->efectivo_venta,
            'nota_venta'=>$this->nota_venta,
            'con_tarjeta'=>$this->con_tarjeta,
            'pedidos'=>$this->pedidos,
            'deposito_pedido'=>$this->deposito_pedido
        ]);
    }
}
