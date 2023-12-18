<?php

namespace App\Exports;

use App\Articulo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;

class ArticuloTodoExports implements FromQuery, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    private $array;

    public function todo($array){
        $this->array = $array;
        return $this;
    }
    public function query()
    {
        $articulos=DB::table('articulo as a')
        ->join('categoria as c','a.idcategoria','=','c.idcategoria')
        ->select($this->array)
        ->orderBy('a.idarticulo','desc');
     
     return $articulos;
    }
}
