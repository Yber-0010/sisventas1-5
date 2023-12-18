<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;

class PedidoProveedor extends Component
{
    public $query ="ejemplo_proveedor";
    public $proveedor = "";
    public function render() {
        $personas = DB::table( 'persona' )
        ->where( 'tipo_persona','=','Proveedor' )
        ->get();
        $articulos = DB::table( 'articulo as a' )
        ->join( 'categoria as c','a.idcategoria','=','c.idcategoria' )
        ->select( 'a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado','a.precio_venta','a.precio_compra','a.empresa','a.peso' )
        ->where( 'a.empresa','LIKE','%'.$this->query.'%' )
        ->orderBy('a.idarticulo','desc')
        ->get();
        return view('livewire.pedido-proveedor',['articulos'=>$articulos,'personas'=>$personas]);
    }
    public function buscar(){
        $this->query = $this->proveedor;
    }
}
