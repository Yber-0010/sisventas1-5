<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class DetallesVentaExport implements FromView, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private 
    $venta,
    $detalles,
    $idshow;

    public function datos(
        $venta,
        $detalles,
        $idshow
    ){
        $this->venta = $venta;
        $this->detalles = $detalles;
        $this->idshow = $idshow;
        return $this;
    }

    public function view(): View
    {
        return view('ventas.venta.detalles_venta',[
            'venta'=>$this->venta,
            'detalles'=>$this->detalles,
            'idshow'=>$this->idshow,
        ]);
    }
}
