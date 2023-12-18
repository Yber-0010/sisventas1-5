@extends ('layouts.admin')
@section ('contenido')

<div class="panel panel-primary">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <h2>Productos Vendidos</h2>
                </div>
            </div>

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="titulo" id="titulo">Lista de productos vendidos</label>
                    
                    {{-- tabla --}}
                    <div class="table-responsive">
                        <div id="taula">
                            <table class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                <th>Id Articulo</th>
                                <th>Articulo</th>
                                <th>Peso</th>
                                <th>Empresa</th>
                                <th>cantidad</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>Descuento</th>
                                <th>fecha vendido</th>
                                </thead>
                                @if ($articulos_vendidos!="")
                                    @foreach ($articulos_vendidos as $art_v)
                                            <tr>            
                                                <td>{{ $art_v->idarticulo}}</td>
                                                <td>{{ $art_v->articulo}}</td>
                                                <td>{{ $art_v->peso }}</td>
                                                <td>{{ $art_v->empresa}}</td>
                                                <td>{{ $art_v->cantidad}}</td>
                                                <td>{{ $art_v->precio_compra}}</td>
                                                <td>{{ $art_v->precio_venta}}</td>
                                                <td>{{ $art_v->descuento}}</td>
                                                <td>{{ $art_v->fecha_hora}}</td>
                                                <td>
                                                    {{-- <a href="/consultas/{{ $art_v->idarticulo }}"><i class="fa fa-eye"></i></a> --}}
                                                    {{-- <a href="{{URL::action('ConsultasController@show',$art_v->idarticulo)}}"><button class="btn btn-primary">Detalles</button></a> --}}
                                                </td>
                                                {{-- <td>{{$art_v->cantidad*$art_v->precio_venta-$art_v->descuento}}</td> --}}
                                            </tr>
                                    @endforeach 
                                @endif
                            </table>
                            {{--------------------------------}}
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="" id="titulo">Lista de productos pedidos vendidos</label>
                    
                    {{-- tabla --}}
                    <div class="table-responsive">
                        <div id="taula">
                            <table class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                    <th>Id Articulo</th>
                                    <th>Articulo</th>
                                    <th>Peso</th>
                                    <th>Empresa</th>
                                    <th>cantidad</th>
                                    <th>Precio Compra</th>
                                    <th>Precio Venta</th>
                                    <th>Descuento</th>
                                    <th>fecha pedido vendido</th>
                                </thead>
                                @if ($articulos_pedidos!="")
                                    @foreach ($articulos_pedidos as $art_p)
                                            <tr>            
                                                <td>{{ $art_p->idarticulo}}</td>
                                                <td>{{ $art_p->articulo}}</td>
                                                <td>{{ $art_p->peso }}</td>
                                                <td>{{ $art_p->empresa}}</td>
                                                <td>{{ $art_p->cantidad}}</td>
                                                <td>{{ $art_p->precio_compra}}</td>
                                                <td>{{ $art_p->precio_venta}}</td>
                                                <td>{{ $art_p->descuento}}</td>
                                                <td>{{ $art_p->fecha_hora_finalizado}}</td>
                                                
                                            </tr>
                                    @endforeach 
                                @endif
                            </table>
                            {{--------------------------------}}
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
@endsection