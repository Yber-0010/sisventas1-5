<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class DetallesPedidoExport implements FromView, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private 
    $pedidos,
    $detalles_pedido,
    $detalles_pedido_null,
    $idshow;

    public function datos(
        $pedidos,
        $detalles_pedido,
        $detalles_pedido_null,
        $idshow
    ){
        $this->pedidos = $pedidos;
        $this->detalles_pedido = $detalles_pedido;
        $this->detalles_pedido_null = $detalles_pedido_null;
        $this->idshow = $idshow;
        return $this;
    }

    public function view(): View
    {
        return view('pedidos.cliente-pedido.detalles_pedidos',[
            'pedidos'=>$this->pedidos,
            'detalles_pedido'=>$this->detalles_pedido,
            'detalles_pedido_null'=>$this->detalles_pedido_null,
            'idshow'=>$this->idshow,
        ]);
    }
}
