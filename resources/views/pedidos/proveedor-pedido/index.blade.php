@extends ('layouts.admin')
@section ('contenido')
<style>
    #cambia-color{
      background: rgb(243, 243, 243);
    }
    #cambia-color:hover{
      background: rgb(227, 227, 255);
      
    }
</style>
<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
        <h2>Listado de Pedidos Proveedor
            <a href="proveedor-pedido/create">
                <button class="btn btn-success">Nuevo</button>
            </a>
        </h2>
        @include('pedidos.proveedor-pedido.search')
    </div>
    <div class="col-lg-4 col-md-2 col-sm-2 col-xs-12">
        <div class="badge badge-primary text-wrap pull-right bg-blue" style="border: 2px solid ;">
          <h3>pedidos: <strong>{{$cantidadPedidos}}</strong></h3>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
                <thead>
                    <th>Id</th>
                    <th>fecha</th>
                    <th>Proveedor</th>
                    <th>Estado</th>
                    <th>Recibido</th>
                    <th>Opciones</th>
                </thead>
                @foreach ($pedidos as $pedido)
                <tr onclick="document.location = '{{URL::action('PedidoProveedorController@show',$pedido->id)}}';" id="cambia-color">              
                    <td rowspan="2">{{$pedido->id}}</td>
                    <td rowspan="2">
                        inicio: {{\Carbon\Carbon::parse($pedido->fecha_inicio)->format('d-m-y h:i')}}
                        <br>fin:
                        @if ($pedido->fecha_fin==null)
                            
                        @else
                        fin: {{\Carbon\Carbon::parse($pedido->fecha_fin)->format('d-m-y h:i')}}    
                        @endif
                        
                    </td>
                    <td rowspan="2">
                        proveedor: {{$pedido->nombre}}
                        <br>
                        pidio: {{$pedido->name}}
                    </td>
                    @if ($pedido->estado == 'ACTIVO')
                    <td rowspan="2">
                        <a href="{{URL::action('PedidoProveedorController@edit',$pedido->id)}}">
                            <button  class="badge badge-primary text-wrap" style="width: 6rem; background: rgb(51, 93, 184)">{{$pedido->estado}}</button>
                        </a>
                    </td>
                    @endif
                    @if ($pedido->estado == 'FINALIZADO')
                    <td rowspan="2">
                        @can('isUser')
                        <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(2, 99, 31)">{{$pedido->estado}}</button>  
                        @endcan                 
                        @can('isAdmin')
                        <a href="{{URL::action('PedidoProveedorController@edit',$pedido->id)}}">
                        <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(2, 99, 31)">{{$pedido->estado}}</button>
                        </a>  
                        @endcan
                    </td>
                    @endif
                    @if ($pedido->estado == 'RECHAZADO')
                    <td rowspan="2">  
                        @can('isUser')
                        <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(199, 58, 58)">{{$pedido->estado}}</button>  
                        @endcan
                        @can('isAdmin', Model::class)
                        <a href="{{URL::action('PedidoProveedorController@edit',$pedido->id)}}">               
                        <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(199, 58, 58)">{{$pedido->estado}}</button>
                        </a>
                        @endcan
                    </td>    
                    @endif
                    
                    @if ($pedido->recibido =="no recibido")
                        <td rowspan="2" class="bg-red">{{ $pedido->recibido }}</td>
                    @endif
                    @if ($pedido->recibido =="recibido")
                        <td rowspan="2" class="bg-green">{{ $pedido->recibido }}</td>
                    @endif
                    @if ($pedido->recibido == null)
                        <td rowspan="2">...</td>
                    @endif
                    
                </tr>
                <tr>
                    {{-- <td>
                        <a href="{{URL::action('PedidoProveedorController@show',$pedido->id)}}"><button class="btn btn-primary">Detalles</button></a>
                    </td> --}}
                    <td>
                        <form action="{{URL::action('PedidoProveedorController@show',$pedido->id)}}" target="_blank">
                            <button class="btn btn-primary pull-right bg-red">PDF</button>
                            <input type="hidden" value="2" id="descargar_detalles" name="descargar_detalles">
                        </form>
                        <form action="{{URL::action('PedidoProveedorController@show',$pedido->id)}}">
                            <button class="btn btn-primary pull-right bg-green" >EXCEL</button>
                            <input type="hidden" value="1" id="descargar_detalles" name="descargar_detalles">
                        </form>
                    </td>
                </tr>
                @endforeach  
          </table>
      </div>
      
      {!! $pedidos->appends(["searchText"=>$query ?? $nombre]) !!}
      {{-- {{ $pedidos->links() }} --}}
    </div>
</div>

@endsection
