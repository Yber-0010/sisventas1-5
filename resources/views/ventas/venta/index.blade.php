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
         <h3>Listado de Ventas <a href="venta/create"><button class="btn btn-success">Nuevo</button></a></h3>
         @include('ventas.venta.search')
    </div> 
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
      @if(Session::has('message'))
      <div class="alert alert-warning alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        {{Session::get('message')}}
      </div>
      @endif
    </div> 
</div>

    {{-- @include('ventas.venta.charts') --}}

<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                 <th>Id enta</th>
                 <th>Fecha</th>
                 <th>Cliente</th>
                 <th>Comprobante</th>
                 <th>Impuesto</th>
                 <th>Total</th>
                 <th>Estado</th>
                 <th>Opciones</th>
               </thead>
               @foreach ($ventas as $ven)
               
                 <tr onclick="document.location = '{{URL::action('VentaController@show',$ven->idventa)}}';" id="cambia-color">
                  <td rowspan="2">{{ $ven->idventa}}</td>
                  <td rowspan="2">{{ $ven->fecha_hora}}</td>
                  <td rowspan="2">{{ $ven->nombre}}</td>
                  <td rowspan="2">{{ $ven->tipo_comprobante.':-'.$ven->serie_comprobante.'--'.$ven->num_comprobante}}</td>
                  <td rowspan="2">{{ $ven->impuesto}}</td>
                  <td rowspan="2">{{ $ven->total_venta}}</td>
                  <td rowspan="2">{{ $ven->estado}}</td>
                  {{-- <td>
                    <a href="{{URL::action('VentaController@show',$ven->idventa)}}"><button class="btn btn-primary">Detalles</button></a>
                    @can('isAdmin')
                    <a href="" data-target="#modal-delete-{{$ven->idventa}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
                    @endcan
                  </td> --}}
                </tr>
                <tr>
                  <td>
                    <a href="{{URL::action('VentaController@show',$ven->idventa)}}"><button class="btn btn-primary">Detalles</button></a>
                    @can('isAdmin')
                    <a href="" data-target="#modal-delete-{{$ven->idventa}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
                    @endcan
                  </td>
                </tr>
                
              
               @include('ventas.venta.modal')
               @endforeach  
            </table>
        </div>
        <!--configurando la manera de modificar bien la paginacion-->
        {!! $ventas->appends(["searchText"=>$query ?? $nombre]) !!}
        <!---->
      </div>
</div>
@endsection
