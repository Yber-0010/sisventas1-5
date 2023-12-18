<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Requests;

use App\Persona;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;
use DB;

class ClienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
       if($request)
       {
           $query=trim($request->get('searchText'));
           $nombre=$query;
           $personas=DB::table('persona')
           ->where('nombre','LIKE','%'.$query.'%')
           ->where('tipo_persona','=','Cliente')
           ->orwhere('num_documento','LIKE','%'.$query.'%')
           ->where('tipo_persona','=','Cliente')
           ->orwhere('telefono','LIKE','%'.$query.'%')
           ->where('tipo_persona','=','Cliente')
           ->orderBy('idpersona','desc')
           ->paginate(20);
           return view('ventas.cliente.index',["personas"=>$personas,"searchText"=>$query,"nombre"=>$nombre]);

       }
    }
    public function create()
    {
        return view("ventas.cliente.create");
    }
    public function store(PersonaFormRequest $request)
    {
        $persona = new Persona;
        $persona->tipo_persona='cliente';
        $persona->nombre=$request->get('nombre');
        $persona->tipo_documento=$request->get('tipo_documento');
        $persona->num_documento=$request->get('num_documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->save();
        //Obtencion de ruta desde la vista con exito
        $ruta=$request->get('ruta');
        if($ruta==''){
            return Redirect::to('ventas/cliente');  
        }
        else{
            return Redirect::to($ruta);  
        }
        ////////////// fin obtencion de la ruta/////
        //$ruta=$request->path();///obtencion de la ruta de esta vista en base a la funcion
    }
    public function show($id)
    {
        return view("ventas.cliente.show",["persona"=>Persona::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("ventas.cliente.edit",["persona"=>Persona::findOrFail($id)]);
    }
    public function update(PersonaFormRequest $request,$id)
    {
        $persona=Persona::findOrFail($id);
        $persona->nombre=$request->get('nombre');
        $persona->tipo_documento=$request->get('tipo_documento');
        $persona->num_documento=$request->get('num_documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->update();
        return Redirect::to('ventas/cliente');
    }
    public function destroy($id)
    {
        $persona=Persona::findOrFail($id);
        $persona->tipo_persona='inactivo';
        $persona->update();
        return Redirect::to('ventas/cliente');
    }
    
}
