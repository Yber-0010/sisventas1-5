<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class DetallesPedidoProveedorExport implements FromView, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private 
    $persona,
    $pedidos,
    $detalles_pedido_proveedor,
    $detalles_pedido_proveedor_null,
    $idshow,
    $sum_pedido,
    $total;

    public function datos(
        $persona,
        $pedidos,
        $detalles_pedido_proveedor,
        $detalles_pedido_proveedor_null,
        $idshow,
        $sum_pedido,
        $total
    ){
        $this->persona = $persona;
        $this->pedidos = $pedidos;
        $this->detalles_pedido_proveedor = $detalles_pedido_proveedor;
        $this->detalles_pedido_proveedor_null = $detalles_pedido_proveedor_null;
        $this->idshow = $idshow;
        $this->sum_pedido = $sum_pedido;
        $this->total = $total;
        return $this;
    }

    public function view(): View
    {
        return view('pedidos.proveedor-pedido.detalles_pedidos_proveedor',[
            'persona'=>$this->persona,
            'pedidos'=>$this->pedidos,
            'detalles_pedido'=>$this->detalles_pedido_proveedor,
            'detalles_pedido_null'=>$this->detalles_pedido_proveedor_null,
            'idshow'=>$this->idshow,
            'sum_pedido'=>$this->sum_pedido,
            'total'=>$this->total,
        ]);
    }
}
