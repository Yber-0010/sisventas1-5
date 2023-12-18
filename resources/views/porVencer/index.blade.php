@extends ('layouts.admin')
@section ('contenido')

<div class="row">
    <h3 style="margin-left: 15px; ">Proximos vencimientos de aca a un mes apartir de la fecha:</h3>
</div>
<div class="row">
    <div class="panel panel-primary">
        <div class="table-responsive">
            <div class="panel-body">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            
                            <th>Articulo</th>
                            <th>Idingreso</th>
                            <th>cantidad que pueden vencer</th>
                            <th>Stock actial</th>
                            <th>Precio_compra</th>
                            <th>Precio_venta</th>
                            <th>fecha_vencimiento</th>
                        </thead>
                        <tfoot>
                            
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tfoot>
                        <tbody>
                        @foreach($detalles as $det)
                        <tr>
                            <td>{{$det->articulo}}</td>
                            <td>
                                <a href="{{URL::action('IngresoController@show',$det->idingreso)}}">
                                    {{$det->idingreso}}
                                </a>
                            </td>
                            <td>{{$det->cantidad}}</td>
                            <td>{{$det->stock}}</td>
                            <td>{{$det->precio_compra}}</td>
                            <td>{{$det->precio_venta}}</td>
                            <td>{{$det->fecha_vencimiento}}</td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>    
    </div>  
</div>
@endsection