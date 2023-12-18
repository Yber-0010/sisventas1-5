<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Articulo;
use DB;

class EditArticulo extends Component
{
    public $articulo;
    //public $ida1;

    public function mount($art) {
        //dd($art->idarticulo);
        $articulo=Articulo::findOrFail($art->idarticulo);
        $this->articulo=$articulo;
    } 
    public function render()
    {
        //$articulo=Articulo::findOrFail($this->idA);
        $categorias=DB::table('categoria')->where('condicion','=','1')->get();   
        $personas=DB::table('persona')
        ->where('tipo_persona','=','Proveedor')
        ->orderBy('idpersona','desc')
        ->get();

        return view('livewire.edit-articulo',[/* 'articulo'=>$articulo, */'categorias'=>$categorias,'personas'=>$personas]);
    }
}
