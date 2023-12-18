<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Requests;

use App\Persona;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\PersonaFormRequest;
use DB;
class ProveedorController extends Controller
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
           $nombre = $query;
           $personas=DB::table('persona')
           ->where('nombre','LIKE','%'.$query.'%')
           ->where('tipo_persona','=','Proveedor')
           ->orwhere('num_documento','LIKE','%'.$query.'%')
           ->where('tipo_persona','=','Proveedor')
           ->orwhere('telefono','LIKE','%'.$query.'%')
           ->where('tipo_persona','=','Proveedor')
           ->orderBy('idpersona','desc')
           ->paginate(20);
           return view('compras.proveedor.index',["personas"=>$personas,"searchText"=>$query,"nombre"=>$nombre]);

       }
    }
    public function create()
    {
        return view("compras.proveedor.create");
    }
    public function store(PersonaFormRequest $request)
    {
        $persona = new Persona;
        $persona->tipo_persona='Proveedor';
        $persona->nombre=$request->get('nombre');
        $persona->tiene_cambio=$request->get('tiene_cambio');
        $persona->detalles=$request->get('detalles');
        $persona->tipo_documento=$request->get('tipo_documento');
        $persona->num_documento=$request->get('num_documento');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->save();
        //Obtencion de ruta desde la vista con exito
        $ruta=$request->get('ruta');
        if($ruta==''){
            return Redirect::to('compras/proveedor');  
        }
        else{
            return Redirect::to($ruta);  
        }
        ////////////// fin obtencion de la ruta/////
        //$ruta=$request->path();///obtencion de la ruta de esta vista en base a la funcion
    }
    public function show($id)
    {
        return view("compras.proveedor.show",["persona"=>Persona::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("compras.proveedor.edit",["persona"=>Persona::findOrFail($id)]);
    }
    public function update(PersonaFormRequest $request,$id)
    {
        $persona=Persona::findOrFail($id);
        $persona->nombre=$request->get('nombre');
        $persona->detalles=$request->get('detalles');
        $persona->tipo_documento=$request->get('tipo_documento');
        $persona->num_documento=$request->get('num_documento');
        $persona->tiene_cambio=$request->get('tiene_cambio');
        $persona->direccion=$request->get('direccion');
        $persona->telefono=$request->get('telefono');
        $persona->email=$request->get('email');
        $persona->update();
        return Redirect::to('compras/proveedor');
    }
    public function destroy($id)
    {
        $persona=Persona::findOrFail($id);
        $persona->tipo_persona='inactivo';
        $persona->update();
        return Redirect::to('compras/proveedor');
    }
}
