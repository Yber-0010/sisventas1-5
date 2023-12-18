<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Categoria;
use DB;

class CreateCategoria extends Component
{

    protected $rules = [
        'nombre'=>'required|max:50',
        'descripcion'=>'max:255',
    ];

    public $identificador;

    public $nombre;
    public $descripcion;

    public function mount() {
        $this->identificador = rand();
    }

    public function render()
    {

        return view('livewire.create-categoria');
    }

    public function save()
    {
        $this->validate();
        
        Categoria::create([
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion, 
            'condicion'=>'1',
        ]);
        
        $this->reset(['nombre','descripcion']);

        $this->identificador = rand();

        $this->emitTo('lista-articulos','render');

        $this->emitTo('create-articulo','render');

        $this->emit('alert','la categoria se creo satisfactoriamente');

    }
}
