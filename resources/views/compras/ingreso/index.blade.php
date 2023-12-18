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
         <h3>Listado de Ingresos<a href="ingreso/create"><button class="btn btn-success">Nuevo</button></a></h3>
         @include('compras.ingreso.search')
    </div> 
</div>

<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
              <thead>
                 <th>Id ingreso</th>
                 <th>Fecha</th>
                 <th>Datos</th>
                 <th>Proveedor</th>
                 <th>Comprobante</th>
                 <th>Impuesto</th>
                 <th>Total</th>
                 <th>Estado</th>
                 <th>Opciones</th>
               </thead>
               @foreach ($ingresos as $ing)
               <tr onclick="document.location = '{{URL::action('IngresoController@show',$ing->idingreso)}}';" id="cambia-color">              
                 <td rowspan="2">{{ $ing->idingreso }}</td>
                 <td rowspan="2">{{ $ing->fecha_hora}}</td>
                 <td rowspan="2">
                       <p>ingresado por: {{ $ing->name}}</p>
                   @if ($ing->anuladopor!=null)
                       <p>anulado por: {{ $ing->anuladopor}}</p>
                   @endif
                </td>
                 <td rowspan="2">{{ $ing->nombre}}</td>
                 <td rowspan="2">{{ $ing->tipo_comprobante.':-'.$ing->serie_comprobante.'--'.$ing->num_comprobante}}</td>
                 <td rowspan="2">{{ $ing->impuesto}}</td>
                 <td rowspan="2">{{ $ing->total}}</td>
                 <td rowspan="2">{{ $ing->estado}}
                  @if ($ing->obserbacion)
                      <span style="color:rgb(170, 47, 47);">{{$ing->obserbacion}}</span>    
                  @endif
                  @if ($ing->detalles)
                      <span style="color: blue;">d</span>
                  @endif
                </td>
               </tr>
               <tr>
                <td>
                  <a href="{{URL::action('IngresoController@show',$ing->idingreso)}}"><button class="btn btn-primary">Detalles</button></a>
                  @can('isAdmin')
                    <a href="" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
                  @endcan                     
                </td>
               </tr>
               @include('compras.ingreso.modal')
               @endforeach  
            </table>
        </div>
        {!! $ingresos->appends(["searchText"=>$query ?? $nombre]) !!}
      </div>
</div>
@endsection
