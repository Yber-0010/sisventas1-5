@extends ('layouts.admin')
@section ('contenido')
<style>
    #titulo{
        font-size: 150%;
    }
</style>
<div class="panel panel-primary">
    <div class="row">
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <h2>Productos Vendidos</h2>
                </div>
            </div>

            {!! Form::open(array('url'=>'consultas/productos-vendidos','method'=>'GET','autocomplete'=>'off','role'=>'search'))!!}
            {{Form::token()}}
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                        <label for="fecha_entrega">De</label>
                        <input type="date" name="fecha_de" class="form-control" value="{{$fecha_de}}"required>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                        <label for="fecha_entrega">Asta</label>
                        <input type="date" name="fecha_asta" class="form-control" value="{{$fecha_asta}}" required>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="tipo">Buscar por:</label>
                            <select name="buscarPor" id="buscarPor" class="form-control selectpicker">
                                <option value=""></option>
                                <option value="1">Proveedor</option>
                                <option value="2">Categoria</option>
                                <option value="3">Codigo del producto</option>
                                <option value="4">Nombre del producto</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div id="ocultarTodo">
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="form-group">
                        {{-- por proveedor --}}
                        <div id="1">
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="tipo">Proveedor</label>
                                    <select name="proveedor" id="proveedor" class="form-control selectpicker" data-live-search="true">
                                        <option value=""></option>
                                        @foreach($proveedor as $provee)
                                        <option  value="{{$provee->nombre}}">{{$provee->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- por categoria --}}
                        <div id="2">
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="tipo">Categoria</label>
                                    <select name="categoria" id="categoria" class="form-control selectpicker">
                                        <option value=""></option>
                                        @foreach ($categorias as $cat)
                                        <option value="{{$cat->nombre}}">{{$cat->nombre}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- por codigo del producto --}}
                        <div id="3">
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="tipo">Codigo del producto</label>
                                    <input type="text" name="codigoProducto" id="codigoProducto" class="form-control" value="{{$codigoProducto}}">
                                </div>
                            </div>
                        </div>
                        {{-- por nombre del producto --}}
                        <div id="4">
                            <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                                <div class="form-group">
                                    <label for="tipo">Nombre del producto</label>
                                    <input type="text" name="nombreProducto" id="nombreProducto" class="form-control" value="{{$nombreProducto}}">
                                </div>
                            </div>
                        </div>
                        {{-- buscar --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <button type="submit" id="buscar" class="btn btn-success" style="margin-top: 25px;">Buscar</button>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{Form::close()}}

            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <label for="" id="titulo">Lista de productos vendidos</label>
                    
                    {{-- tabla --}}
                    <div class="table-responsive">
                        <div id="taula">
                            <table class="table table-striped table-bordered table-condensed table-hover">
                                <thead>
                                <th>Id Articulo</th>
                                <th>Articulo</th>
                                <th>Peso</th>
                                <th>Empresa</th>
                                <th>stock</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>total vendidos</th>
                                </thead>
                                @if ($articulos_vendidos!="")
                                    @foreach ($articulos_vendidos as $art_v)
                                            <tr>            
                                                <td>{{ $art_v->idarticulo}}</td>
                                                <td>{{ $art_v->articulo}}</td>
                                                <td>{{ $art_v->peso }}</td>
                                                <td>{{ $art_v->empresa}}</td>
                                                <td>{{ $art_v->stock}}</td>
                                                <td>{{ $art_v->precio_compra}}</td>
                                                <td>{{ $art_v->precio_venta}}</td>
                                                {{-- <td>{{ $art_v->fecha_hora}}</td> --}}
                                                <td>{{ $art_v->total}}</td>
                                                <td>
                                                    <a href="/consultas/{{ $art_v->idarticulo}}/{{$fecha_de}}/{{$fecha_asta}}/{{$nombre}}/{{$buscarPor}}"><i class="fa fa-eye"></i></a>
                                                    {{-- <a href="{{URL::action('ConsultasController@show',$art_v->idarticulo)}}"><i class="fa fa-eye"></i></a> --}}
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
                                <th>stock</th>
                                <th>Precio Compra</th>
                                <th>Precio Venta</th>
                                <th>total vendidos</th>
                                </thead>
                                @if ($articulos_pedidos!="")
                                    @foreach ($articulos_pedidos as $art_p)
                                            <tr>            
                                                <td>{{ $art_p->idarticulo}}</td>
                                                <td>{{ $art_p->articulo}}</td>
                                                <td>{{ $art_p->peso }}</td>
                                                <td>{{ $art_p->empresa}}</td>
                                                <td>{{ $art_p->stock}}</td>
                                                <td>{{ $art_p->precio_compra}}</td>
                                                <td>{{ $art_p->precio_venta}}</td>
                                                {{-- <td>{{ $art_v->fecha_hora}}</td> --}}
                                                <td>{{ $art_p->total}}</td>
                                                <td>
                                                    <a href="/consultas/{{ $art_p->idarticulo}}/{{$fecha_de}}/{{$fecha_asta}}/{{$nombre}}/{{$buscarPor}}"><i class="fa fa-eye"></i></a>
                                                    {{-- <a href="{{URL::action('ConsultasController@show',$art_v->idarticulo)}}"><i class="fa fa-eye"></i></a> --}}
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

        </div>
    </div>
</div>
@endsection

@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
$(document).ready(function(){
    $("#proveedor").select2({
        width: '100%'
    });    
    $("#categoria").select2({
        width: '100%'
    });    
});
</script>
<script>
    $(document).ready(function(){
        $("#buscarPor").change(function()
        { 
            agregar();
        });
        ocultarTodo();
    });
    function agregar() {

        buscarPor = $("#buscarPor").val();

        switch (buscarPor) {
            case '1':
                $("#ocultarTodo").show();
                $("#1").show();
                $("#2").hide();
                $("#3").hide();
                $("#4").hide();
                break;
            case '2':
                $("#ocultarTodo").show();
                $("#1").hide();
                $("#2").show();
                $("#3").hide();
                $("#4").hide();
                break;
            case '3':
                $("#ocultarTodo").show();
                $("#1").hide();
                $("#2").hide();
                $("#3").show();
                $("#4").hide();
                break;
            case '4':
                $("#ocultarTodo").show();
                $("#1").hide();
                $("#2").hide();
                $("#3").hide();
                $("#4").show();
                break;
            default:
                break;
        }
        
    }
    function ocultarTodo() {
        $("#ocultarTodo").hide();
    }

</script>
@endpush