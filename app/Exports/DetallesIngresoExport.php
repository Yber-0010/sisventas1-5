<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class DetallesIngresoExport implements FromView, ShouldAutoSize 
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private 
    $ingreso,
    $detalles,
    $idshow;

    public function datos(
        $ingreso,
        $detalles,
        $idshow
    ){
        $this->ingreso = $ingreso;
        $this->detalles = $detalles;
        $this->idshow = $idshow;
        return $this;
    }

    public function view(): View
    {
        return view('compras.ingreso.detalles_ingreso',[
            'ingreso'=>$this->ingreso,
            'detalles'=>$this->detalles,
            'idshow'=>$this->idshow,
        ]);
    }
}
