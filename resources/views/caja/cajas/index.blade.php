@extends ('layouts.admin')
@section ('contenido')

<div class="row">
    <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
         <h3>Listado de Cajas <a href="cajas/create"><button class="btn btn-success">Nuevo</button></a></h3>
         @include('caja.cajas.search')
    </div> 
</div>

<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                 <th>Id Caja</th>
                 <th>Fecha Aperertura</th>
                 <th>Fecha Cierre</th>
                 <th>Usuario</th>
                 <th>Inicio</th>
                 <th>Cierre</th>
                 @can('isAdmin') 
                 <th>vendido</th>
                 @endcan
                 <th>Estado</th>
                 <th>Detalle</th>
               </thead>
               @foreach ($caja as $ca)
               <tr onclick="document.location = '{{URL::action('CajaController@show',$ca->idcaja)}}';" id="cambia-color">              
                  <td rowspan="2">{{ $ca->idcaja}}</td>
                  <td rowspan="2">{{ $ca->fecha_apertura}}</td>
                  <td rowspan="2">{{ $ca->fecha_cierre}}</td>

                  {{-- ME QUEDE ACA --}}
                  @if ($ca->encargado_nombre == null)
                    <td rowspan="2">
                    @foreach ($users as $us)
                        @if ($us->id == $ca->encargado)
                            {{$us->name}}
                        @endif
                    @endforeach
                    </td>
                  @else
                      <td rowspan="2">{{ $ca->encargado_nombre}}</td>
                  @endif
                  
                  {{-- <td>{{ $ca->encargado}}</td> --}}
                  <td rowspan="2">{{ $ca->inicio}}</td>
                  <td rowspan="2">{{ $ca->cierre_real}}</td>
                  @can('isAdmin') 
                  <td rowspan="2">{{ $ca->ingreso}}</td>
                  @endcan
                 @if ($ca->estado=='Activo')
                  <td rowspan="2">
                    <a href="{{URL::action('CajaController@edit',$ca->idcaja)}}"><button  class="badge badge-primary text-wrap" style="width: 6rem; background: rgb(13, 133, 13)">{{$ca->estado}}</button></a>
                 </td>    
                 @else
                  <td rowspan="2">
                    @can('isUser')
                    <button  class="badge badge-primary text-wrap" style="width: 6rem; background: rgb(218, 38, 38)">{{$ca->estado}}</button>
                    @endcan
                    @can('isAdmin')
                    <a href="{{URL::action('CajaController@edit',$ca->idcaja)}}"><button  class="badge badge-primary text-wrap" style="width: 6rem; background: rgb(218, 38, 38)">{{$ca->estado}}</button></a>
                    @endcan
                    
                  </td>    
                 @endif
                  
               </tr>
               <tr>
                  <td>
                    <a href="{{URL::action('CajaController@show',$ca->idcaja)}}"><button class="btn btn-primary">Detalles</button></a>
                  </td>
               </tr>
               @endforeach  
            </table>
        </div>
        <!--configurando la manera de modificar bien la paginacion-->
        {!! $caja->appends(["searchText"=>$query ?? $nombre]) !!}
        <!---->
      </div>
</div>
@endsection
