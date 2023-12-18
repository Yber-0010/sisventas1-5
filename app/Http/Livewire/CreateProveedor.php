<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;
use App\Persona;

class CreateProveedor extends Component
{
    protected $rules = [
        'nombre' => 'required|max:100',
        'tipo_documento' => 'required|max:20',
        //'num_documento' => 'required|max:15',
        'direccion' => 'max:70',
        'telefono' => 'required|max:15',
        'email' => 'max:50',
    ];

    public $identificador;

    public $nombre;
    public $tipo_documento;
    public $num_documento;
    public $direccion;
    public $telefono;
    public $email;
    public $tiene_cambio;
    public $detalles;

    public function mount() {
        $this->identificador = rand();
    }

    public function render()
    {
        return view('livewire.create-proveedor');
    }

    public function save()
    {
        $this->validate();
        
        Persona::create([
            'tipo_persona'=>'Proveedor',
            'nombre'=> $this->nombre,
            'tipo_documento'=>$this->tipo_documento,
            'num_documento'=>$this->num_documento,
            'direccion'=>$this->direccion,
            'telefono'=>$this->telefono,
            'email'=>$this->email,
            'tiene_cambio'=>$this->tiene_cambio,
            'detalles'=>$this->detalles
        ]);
        
        $this->reset(['nombre','tipo_documento','num_documento','direccion','telefono','email','tiene_cambio','detalles']);

        $this->identificador = rand();

        $this->emitTo('lista-articulos','render');

        $this->emitTo('create-articulo','render');

        $this->emitTo('lista-proveedor','render');

        $this->emit('alert','el proveedor se creo satisfactoriamente');

    }
}
