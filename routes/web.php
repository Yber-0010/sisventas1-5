<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('auth/login');
});

Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/articulo','ArticuloController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso','IngresoController');
Route::resource('ventas/venta','VentaController');
//Route::resource('ventas/pedidos','PedidoController');
Route::resource('pedidos/cliente-pedido','PedidoController');
Route::resource('pedidos/proveedor-pedido','PedidoProveedorController');
Route::resource('caja/cajas','CajaController');
Route::resource('porVencer/','ProximosVencimientosController');
Route::resource('negocio','SucursalController')->middleware('can:isAdmin');;
Route::resource('reportes','ExcelController');
/*************ruta reportes en excel, pdf****************/
    /**excel**/
    Route::get('user-list-excel', 'ExcelController@exportExcel')->name('users.excel');

    Route::get('markAsRead', 'MarcarLeidoController@marcarLeido')->name('markAsRead');
    Route::get('/markAsReadd/{id}', 'MarcarLeidoController@marcarLeidoo');

    Route::get('reportes.index', 'ExcelController@articuloExcel')->name('articulos.excel');
    /**pdf**/
    Route::get('user-list-pdf', 'PdfController@exportPdf')->name('users.pdf');
    Route::get('caja-pdf', 'PdfController@exportPdfCaja')->name('caja.pdf');
    Route::get('articulo-list-pdf', 'PdfController@exportPdf2')->name('articulo.pdf');
/************************************************************************/
Route::resource('seguridad/usuario','UsuarioController')->middleware('can:isAdmin');//autenticando con can el Provider isAmin

Auth::routes();
Route::get('/logout', 'Auth\LoginController@logout')->name('logout' );
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/{slug?}', 'HomeController@index')->name('home');
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

/*Route::get('reporte_prueba/', function () {
        return view('reporte_prueba/index'); 
    });*/
Route::get('/consultas/productos-vendidos','ConsultasController@productosVendidos');
Route::get('/consultas/{id}/{fecha_de}/{fecha_asta}/{nombre}/{buscarPor}','ConsultasController@show');



/* Route::middleware(['auth'])->group(function(){
    
}); */

