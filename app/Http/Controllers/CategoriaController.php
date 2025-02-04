<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\FormRequests;

use App\Categoria;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CategoriaFormRequest;
use DB;

class CategoriaController extends Controller
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
           $categorias=DB::table('categoria')
           ->where('nombre','LIKE','%'.$query.'%')
           ->where('condicion','=','1')
           ->orderBy('idcategoria','desc')
           ->paginate(20);
           return view('almacen.categoria.index',["categorias"=>$categorias,"searchText"=>$query,"nombre"=>$query]);

       }
    }
    public function create()
    {
        return view("almacen.categoria.create");
    }
    public function store(CategoriaFormRequest $request)
    {
        $categoria= new Categoria;
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->condicion='1';
        $categoria->save();
        //Obtencion de ruta desde la vista con exito
        $ruta=$request->get('ruta');
        if($ruta==''){
            return Redirect::to('almacen/categoria');
        }
        else{
            return Redirect::to($ruta);  
        }
        ////////////// fin obtencion de la ruta/////
        //$ruta=$request->path();///obtencion de la ruta de esta vista en base a la funcion
        
    }
    public function show($id)
    {
        return view("almacen.categoria.show",["categoria"=>Categoria::findOrFail($id)]);
    }
    public function edit($id)
    {
        return view("almacen.categoria.edit",["categoria"=>Categoria::findOrFail($id)]);
    }
    public function update(CategoriaFormRequest $request,$id)
    {
        $categoria=Categoria::findOrFail($id);
        $categoria->nombre=$request->get('nombre');
        $categoria->descripcion=$request->get('descripcion');
        $categoria->update();
        return Redirect::to('almacen/categoria');
    }
    public function destroy($id)
    {
        $categoria=Categoria::findOrFail($id);
        $categoria->condicion='0';
        $categoria->update();
        return Redirect::to('almacen/categoria');
    }
}
