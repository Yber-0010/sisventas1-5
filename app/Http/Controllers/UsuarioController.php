<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\user;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UsuarioFormRequest;
use DB;
use Illuminate\Support\Facades\Gate;

class UsuarioController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function index(Request $request){
        if($request){
            $query=trim($request->get('searchText'));
            $nombre=$query;
            $usuarios=DB::table('users')
            ->where('name','like','%'.$query.'%')
            ->where('condicion','=','1')
            ->orderBy('id','desc')
            ->paginate(10);
            return view('seguridad.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query,"nombre"=>$query]);
        }
    }
    public function create(){
        return view("seguridad.usuario.create");
    }
    public function store(UsuarioFormRequest $request){
        $usuario = new User;
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        $usuario->idrol=$request->get('idrol');
        $usuario->condicion=1;
        $usuario->password=bcrypt($request->get('password'));
        $usuario->save();
        return Redirect::to('seguridad/usuario');
    }
    public function edit($id)
    {
        return view("seguridad.usuario.edit",["usuario"=>User::findOrFail($id)]);
    }
    public function update(UsuarioFormRequest $request,$id){
        ////// test de prueba de si eres usuario o no //////
       /* if (Gate::allows('isAdmin')) {
            dd('el usuario es admin');
        }else{
            dd('el usuario no es admin');
        } */
        //////////
        $usuario = User::findOrFail($id);
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        $usuario->idrol=$request->get('idrol');
        $usuario->condicion=1;
        $usuario->password=bcrypt($request->get('password'));
        $usuario->update();
        return Redirect::to('seguridad/usuario');
    }
    public function destroy($id)
    {
        $usuario = User::findOrFail($id);
        $usuario->condicion=0;
        $usuario->update();
        return Redirect::to('seguridad/usuario');
    }
    
}