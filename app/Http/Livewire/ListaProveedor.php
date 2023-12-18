<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;

class ListaProveedor extends Component
{
    public $pro = "";
    protected $listeners = ['render' => 'render'];
    public function render()
    {
        $pro2="";
        $personas=DB::table('persona')
        ->where('tipo_persona','=','Proveedor')
        ->get();
        foreach ($personas as $p) {
            if($this->pro == ($p->nombre.' : '.$p->telefono)){
              $pro2 = $p->idpersona;            
            }
        }
        return view('livewire.lista-proveedor',['personas'=>$personas,'pro2'=>$pro2]);
    }
}
