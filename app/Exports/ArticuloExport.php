<?php

namespace App\Exports;

use App\Articulo;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use DB;



class ArticuloExport implements FromQuery, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    private $estado,$stock,$comparativa,$por_categoria;

    private $array;

    public function porEstado($estado,$stock,$comparativa,$array,$por_categoria){
        $this->por_categoria = $por_categoria;
        $this->comparativa = $comparativa;
        $this->stock = $stock;
        $this->estado = $estado;
        $this->array = $array;
        return $this;
    }

    public function query()//collection()// view(): View//
    {
        
        $articulos=DB::table('articulo as a')
           ->join('categoria as c','a.idcategoria','=','c.idcategoria')
           //->select('a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado','a.precio_venta','a.precio_compra')
           ->select($this->array)
           ->where('a.estado','=',$this->estado)// por nombre de articulo se debe mejorar pero
           ->where('a.stock',$this->comparativa,$this->stock)
           ->where('c.nombre','=',$this->por_categoria)
           ->orderBy('a.idarticulo','desc');
        
        return $articulos;
    }
}

/*
class ArticuloExport implements FromView, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /*
    public function view(): View//query()//collection()//
    {
        //RETORNO POR VISTA
        return view('reporte_prueba.excel.excel1',[
            'articulos'=>Articulo::all()
        ]);
    }
}

/* original
class ArticuloExport implements FromCollection, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    /* 
    public function collection()
    {
        return Articulo::select('nombre','stock','precio_compra','precio_venta','estado')->get();
    }
    
} */
