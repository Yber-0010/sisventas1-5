@extends ('layouts.admin')
@section ('contenido')

<form action="{{URL::action('PedidoProveedorController@show',$idshow)}}">
  <input type="hidden" value="1" id="descargar_detalles" name="descargar_detalles">
  <button class="label pull-right bg-green" >EXCEL</button>
</form>
<form action="{{URL::action('PedidoProveedorController@show',$idshow)}}" target="_blank">
  <input type="hidden" value="2" id="descargar_detalles" name="descargar_detalles">
  <button class="label pull-right bg-red">PDF</button>
</form>

@include('pedidos.proveedor-pedido.detalles_pedidos_proveedor')
          
@endsection