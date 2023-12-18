<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class CajaListaIngresosArticulosExport implements FromView, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private 
    $caja,
    $detalles_ingresados,
    $cantidad_total_ingresos;

    public function datos(
    $caja,
    $detalles_ingresados,
    $cantidad_total_ingresos
    )
    {
        $this->caja = $caja;
        $this->detalles_ingresados = $detalles_ingresados;
        $this->cantidad_total_ingresos = $cantidad_total_ingresos;
        return $this;
    }

    public function view(): View
    {
        return view('caja.partial1.singresos_articulo',[
            'caja'=>$this->caja,
            'detalles_ingresados'=>$this->detalles_ingresados, 
            'cantidad_total_ingresos'=>$this->cantidad_total_ingresos
        ]);
    }
}
