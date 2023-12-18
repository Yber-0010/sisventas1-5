<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Articulo;
use DB;
use Livewire\WithFileUploads;
use Carbon\Carbon;

class CreateArticulo extends Component
{
    use WithFileUploads;    
    
    protected $listeners = ['render' => 'render'];

    protected $rules = [
        'nombre'=>'required|max:100',
        'idcategoria'=>'required',
        'codigo'=>'required|max:50',
        'stock'=>'required|numeric',
        'descripcion'=>'max:512',
        'peso'=>'required',
        'imagen' => 'mimes:jpeg,jpg,png | max:1000',
        'empresa'=>'required',
        'stock_min'=>'required',
        'stock_max'=>'required'
    ];

    public $identificador;

    public $nombre;
    public $idcategoria;
    public $codigo;
    public $stock = 0;
    public $precio_compra = 0;
    public $precio_venta = 0;
    public $estado ='Activo';
    public $descripcion;
    public $peso;
    public $empresa;
    public $imagen;
    public $stock_min;
    public $stock_max;
    /* public function updated($propertyName){
        $this->validateOnly($propertyName);
    } */

    public function mount() {
        $this->identificador = rand();
    }

    public function render()
    {
        if ($this->imagen) {
            $this->emit('show');
        }
        $categorias=DB::table('categoria')->where('condicion','=','1')->get();
        $personas=DB::table('persona')
            ->where('tipo_persona','=','Proveedor')
            ->orderBy('idpersona','desc')
            ->get();
        return view('livewire.create-articulo',['categorias'=>$categorias,'personas'=>$personas]);
        
    }
    public function save()
    {
        $this->validate();
        
        $imageName = $this->imagen->getClientOriginalName();
        $image = $this->imagen->storeAs('imagenes/articulos/',$imageName,'public_uploads');
        //dd($image);
        $mytime = Carbon::now('America/La_Paz');
        Articulo::create([
            'nombre' => $this->nombre,
            'stock' => $this->stock,
            'precio_compra' => $this->precio_compra,
            'precio_venta' => $this->precio_venta,
            'estado' => $this->estado,
            'idcategoria' => $this->idcategoria,
            'codigo' => $this->codigo,
            'descripcion' => $this->descripcion,
            'peso' => $this->peso,
            'empresa' => $this->empresa,
            'imagen' => $imageName,
            'created_at'=> $mytime,
            'stock_min'=>$this->stock_min,
            'stock_max'=>$this->stock_max
             
        ]);
        
        $this->reset(['nombre','stock','precio_compra','precio_venta','estado','idcategoria','codigo','descripcion','peso','empresa','imagen','stock_min','stock_max']);

        $this->identificador = rand();

        $this->emitTo('show-articulos','render');

        $this->emitTo('lista-articulos','render');

        $this->emit('alert','el articulo se creo satisfactoriamente');

    }
}
