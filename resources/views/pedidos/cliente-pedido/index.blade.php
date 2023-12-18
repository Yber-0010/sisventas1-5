@extends ('layouts.admin')
@section ('contenido')

<div class="row">
  
  
  <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
    <h3> 
      Listado clientes Pedidos <a href="cliente-pedido/create"><button class="btn btn-success">Nuevo</button></a>
    </h3>
      @include('pedidos.cliente-pedido.search')
  </div>
  <div class="col-lg-4 col-md-2 col-sm-2 col-xs-12">
    <div class="badge badge-primary text-wrap pull-right bg-blue" style="border: 2px solid ;">
      <h3>pedidos: <strong>{{ $cantidadPedidos }}</strong></h3>
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
                 <th>Para</th>
                 <th>hora</th>
                 <th>Cliente</th>
                 <th>Celular</th>
                 <th>A cuenta</th>
                 <th>Saldo</th>
                 <th>Total</th>
                 <th>Estado</th>
                 <th>Recogio</th>
               </thead>
               @foreach ($pedidos as $ped)
               <tr onclick="document.location = '{{URL::action('PedidoController@show',$ped->id)}}';" id="cambia-color">              
                 <td rowspan="2">{{ $ped->id }}</td>
                 <td rowspan="2">
                   <p>inicio: &nbsp;{{ $ped->fecha_hora_inicio}}</p>
                   <p>fin: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $ped->fecha_hora_finalizado}}</p>
                 </td>
                 <td rowspan="2">{{ $ped->fecha_hora_entrega}}</td>
                 <td rowspan="2">{{ $ped->hora}}</td>
                 <td rowspan="2">
                    Pidió: {{ $ped->encargado_pedido}}<br>
                    Para: {{ $ped->nombre_cliente}}
                </td>
                 <td rowspan="2">{{ $ped->celular_cliente}}</td>
                 <td rowspan="2">{{ $ped->a_cuenta}}</td>
                 <td rowspan="2">{{ $ped->saldo}}</td>
                 <td rowspan="2">{{ $ped->total_venta}}</td>        
              @if ($ped->estado=='ACTIVO')
                 <td rowspan="2">
                  <a href="{{URL::action('PedidoController@edit',$ped->id)}}"><button  class="badge badge-primary text-wrap" style="width: 6rem; background: rgb(51, 93, 184)">{{$ped->estado}}</button></a>
                 </td>
              @endif
              @if ($ped->estado=='FINALIZADO')
                  <td rowspan="2">
                    @can('isUser')
                      <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(2, 99, 31)">{{$ped->estado}}</button>  
                    @endcan                 
                    @can('isAdmin')
                    <a href="{{URL::action('PedidoController@edit',$ped->id)}}">
                      <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(2, 99, 31)">{{$ped->estado}}</button>
                    </a>  
                    @endcan
                  </td>    
              @endif
              @if ($ped->estado=='RECHAZADO')
                  <td rowspan="2">  
                    @can('isUser')
                      <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(199, 58, 58)">{{$ped->estado}}</button>  
                    @endcan
                    @can('isAdmin', Model::class)
                    <a href="{{URL::action('PedidoController@edit',$ped->id)}}">               
                      <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(199, 58, 58)">{{$ped->estado}}</button>
                      </a>
                    @endcan
                  </td>    
              @endif
              @if ($ped->recogio=="no recogio")
                <td rowspan="2" class="bg-red">{{ $ped->recogio }}</td>
              @endif
              @if ($ped->recogio=="entregado")
                <td rowspan="2" class="bg-green">{{ $ped->recogio }}</td>
              @endif
              @if ($ped->recogio== null)
                <td rowspan="2">...</td>
              @endif
                 
               </tr>
               <tr>
                  <td>
                    <a href="{{URL::action('PedidoController@show',$ped->id)}}"><button class="btn btn-primary">Detalles</button></a>
                  </td>
                  <td>
                    <form action="{{URL::action('PedidoController@show',$ped->id)}}" target="_blank">
                      <button class="btn btn-primary  bg-blue">PDF</button>
                      <input type="hidden" value="2" id="descargar_detalles" name="descargar_detalles">
                    </form>
                  </td>
               </tr>
               {{--@include('ventas.venta.modal')--}}
               @endforeach  
            </table>
        </div>
        <!--configurando la manera de modificar bien la paginacion-->
        {!! $pedidos->appends(["searchText"=>$query ?? $nombre]) !!}
        <!---->
      </div>
</div>
@endsection
