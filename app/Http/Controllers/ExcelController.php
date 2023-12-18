<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\FormRequests;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Redirect;
use App\Exports\UsersExport;
use App\Exports\ArticuloExport;
use App\Exports\ArticuloTodoExports;
use App\User;
use DB;
class ExcelController extends Controller{


    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request){

            $categorias=DB::table('categoria')
            ->select('nombre')
            ->where('condicion','=','1')
            ->orderBy('idcategoria','desc')
            ->get();
            return view('reportes.index',["categorias"=>$categorias]);
        
 
    }
    public function exportExcel(){
        return Excel::download(new UsersExport, 'user-list.xlsx');
    }
    public function articuloExcel(Request $request){
        
        $id = $request->get('id');
        $nombre = $request->get('nombre');
        $codigo=$request->get('codigo');
        $stock1 = $request->get('stock1');
        $categoria1=$request->get('categoria1');
        $descripccion=$request->get('descripccion');
        $imagen=$request->get('imagen');
        $estado1=$request->get('estado1');
        $precio_venta=$request->get('precio_venta');
        $precio_compra=$request->get('precio_compra');

        $array = array($id,$nombre,$codigo,$stock1,$categoria1,$descripccion,$imagen,$estado1,$precio_compra,$precio_venta);
            $asta = count($array);
            $a=0;
            for($j=0;$j<$asta;$j++){
                if($array[$j] == null){
                    unset($array[$j]);
                };
            };

        
        $personalizar = $request->get('personalizar');

        if($array == null)
        {
            return Redirect::to('reportes');
        }
        else
        {
            if($personalizar == 'todos')
            {
                return (new ArticuloTodoExports)->todo($array)->download('articulo-list.xlsx');
            }
            else
            {
                $por_categoria = $request->get('por_categorias');
                $comparativa = $request->get('comparativa');
                $stock = $request->get('stock');
                if($stock == ""){$stock=0;};
                $estado = $request->get('estado');
                return (new ArticuloExport)->porEstado(
                    $estado,
                    $stock,
                    $comparativa,
                    $array,
                    $por_categoria)->download('articulo-list.xlsx');
            }
        }
    }

}