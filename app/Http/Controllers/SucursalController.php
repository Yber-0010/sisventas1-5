<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SucursalFromRequest;
use App\Negocio;
use DB;


class SucursalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        if($request)
       {
           $sucursal=DB::table('negocio as n')
           ->select('n.idnegocio','n.nombre_negocio','n.direccion_negocio','n.telefono_negocio','n.imagen_negocio')
           ->get();
           return view('negocio.index',['sucursal'=>$sucursal]);

       }
    }

    public function edit($id)
    {
        $sucursal=Negocio::findOrFail($id);  
    
        return view("negocio.edit",["sucursal"=>$sucursal]);
    }
    public function update(SucursalFromRequest $request,$id)
    {
        $sucursal=Negocio::findOrFail($id);
        $sucursal->telefono_negocio=$request->get('telefono_negocio');
        $sucursal->nombre_negocio=$request->get('nombre_negocio');
        $sucursal->direccion_negocio=$request->get('direccion_negocio');
        if($request->file('imagen_negocio'))
        {
            $file = $request->file('imagen_negocio');
            $file->move('imagenes/articulos/',$file->getClientOriginalName());
            $sucursal->imagen_negocio=$file->getClientOriginalName();
        }
        $sucursal->update();
        
        return Redirect::to('negocio');

    }
}
