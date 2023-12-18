<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class CajaListaIngresosExport implements FromView, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private 
    $caja,
    $ingresos,
    $factura_ingreso,
    $nota_ingreso,
    $tarjeta_ingreso;

    public function datos(
    $caja,
    $ingresos,
    $factura_ingreso,
    $nota_ingreso,
    $tarjeta_ingreso
    )
    {
        $this->caja = $caja;
        $this->ingresos = $ingresos;
        $this->factura_ingreso = $factura_ingreso;
        $this->nota_ingreso = $nota_ingreso;
        $this->tarjeta_ingresos = $tarjeta_ingreso;
        return $this;
    }

    public function view(): View
    {
        return view('caja.partial1.singresos',[
            'caja'=>$this->caja,
            'ingresos'=>$this->ingresos,
            'factura_ingreso'=>$this->factura_ingreso,
            'nota_ingreso'=>$this->nota_ingreso,
            'tarjeta_ingreso'=>$this->tarjeta_ingresos
        ]);
    }
}
