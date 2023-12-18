<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Articulo;
use DB;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ShowArticulos extends Component
{
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    
    protected $listeners = ['render' => 'render'];

    public $query;
    public $estado;
    public $nombre;
    public $sort = 'idarticulo';
    public $direction = 'desc';

    
    public function updatingquery()
    {
        $this->resetPage();
    }

    public function render()
    {
        $articulos=DB::table('articulo as a')
               ->join('categoria as c','a.idcategoria','=','c.idcategoria')
               ->select('a.idarticulo','a.nombre','a.codigo','a.stock','c.nombre as categoria','a.descripcion','a.imagen','a.estado','a.precio_venta','a.precio_compra','a.empresa','a.peso')
               ->where('a.nombre','LIKE','%'.$this->query.'%')
               ->orwhere('a.idarticulo','LIKE','%'.$this->query.'%')
               ->orwhere('c.nombre','LIKE','%'.$this->query.'%')// por nombre de articulo se debe mejorar pero
               ->orwhere('a.empresa','LIKE','%'.$this->query.'%')
               ->orderBy($this->sort, $this->direction)
               ->paginate(10);

        return view('livewire.show-articulos',["articulos"=>$articulos]);
    }

    public function order($sort){
        if ($this->sort == $sort) {
            if ( $this->direction == 'desc' ) {
                 $this->direction = 'asc';
            } else {
                 $this->direction = 'desc';
            }
        } else {
            $this->sort = $sort;
            $this->direction = 'asc';
        }
        
    }
}
