<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use Livewire\WithPagination;


class IndexArticulos extends Component
{
    use WithPagination;
    
    protected $paginationTheme = 'bootstrap';

    public $searchText = '';
    public $estado = '1';
    public $query;

    public function updatingsearchText()
    {
        $this->resetPage();
    }
    public function render()
    {
        $this->query = $this->searchText;
        if ( $this->estado == '1' ) 
        {
            /* ACTIVOS */
            $articulos=DB::table('articulo as a')
            ->join('categoria as c','a.idcategoria','=','c.idcategoria')
            ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado','a.precio_venta','a.precio_compra','a.empresa','a.peso')
            ->where([['a.nombre','LIKE','%'.$this->query.'%'],['a.estado','=','Activo'],])
            ->orwhere([['a.idarticulo','LIKE','%'.$this->query.'%'],['a.estado','=','Activo'],])
            ->orwhere([['c.nombre','LIKE','%'.$this->query.'%'],['a.estado','=','Activo'],])// por nombre de articulo se debe mejorar pero
            ->orwhere([['a.empresa','LIKE','%'.$this->query.'%'],['a.estado','=','Activo'],])
            ->orderBy('a.idarticulo','desc')
            ->paginate(10);    
        } elseif ( $this->estado == '2') 
        {
            /* INACTIVOS */
            $articulos=DB::table('articulo as a')
            ->join('categoria as c','a.idcategoria','=','c.idcategoria')
            ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado','a.precio_venta','a.precio_compra','a.empresa','a.peso')
            ->where([['a.nombre','LIKE','%'.$this->query.'%'],['a.estado','=','Inactivo'],])
            ->orwhere([['a.idarticulo','LIKE','%'.$this->query.'%'],['a.estado','=','Inactivo'],])
            ->orwhere([['c.nombre','LIKE','%'.$this->query.'%'],['a.estado','=','Inactivo'],])// por nombre de articulo se debe mejorar pero
            ->orwhere([['a.empresa','LIKE','%'.$this->query.'%'],['a.estado','=','Inactivo'],])
            ->orderBy('a.idarticulo','desc')
            ->paginate(10);
        } else 
        {
           /* activos e inactivos */
           $articulos=DB::table('articulo as a')
           ->join('categoria as c','a.idcategoria','=','c.idcategoria')
           ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado','a.precio_venta','a.precio_compra','a.empresa','a.peso')
           ->where('a.nombre','LIKE','%'.$this->query.'%')
           ->orwhere('a.idarticulo','LIKE','%'.$this->query.'%')
           ->orwhere('c.nombre','LIKE','%'.$this->query.'%')// por nombre de articulo se debe mejorar pero
           ->orwhere('a.empresa','LIKE','%'.$this->query.'%')
           ->orderBy('a.idarticulo','desc')
           ->paginate(10);
        }
        return view('livewire.index-articulos',['articulos'=>$articulos]);
    }
    public function selecEstado ($estado) 
    {
        if ( $estado == '1') {
            $this->estado = '1';
        }
        if ( $estado == '2') {
            $this->estado = '2';
        }
    }
}
