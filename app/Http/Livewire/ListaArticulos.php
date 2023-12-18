<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;

class ListaArticulos extends Component
{
  public $art = "";
  /* public $art2 = "uwu"; */

  protected $listeners = ['render' => 'render'];
    
    public function render()
    {
        $art2="";
        $art3=$this->art;
        $articulos=DB::table('articulo as art')
          ->select(/*DB::raw('CONCAT(art.codigo, " ",art.nombre) AS articulo')*/'art.nombre AS articulo','art.idarticulo','art.precio_venta','art.precio_compra','art.peso','art.stock','art.empresa')
          ->where('art.estado','=','Activo')
          ->get();
        foreach ($articulos as $a) {
          if($this->art ==('+'.$a->idarticulo.'+ '.$a->articulo.' '.$a->peso.' '.$a->empresa)){
            $art2 = $a->idarticulo.'_'.$a->precio_compra.'_'.$a->precio_venta.'_'.$a->peso.'_'.$a->stock;            
          }
        }
        /* if($this->art =='+38+ harina de haba 300 gr fuente de vida'){
          $this->art2='hola';
        } */
        
        
        return view('livewire.lista-articulos',["articulos"=>$articulos,"art2"=>$art2,"art3"=>$art3]);
    }
}
