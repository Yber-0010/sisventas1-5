@extends('layouts.admin')

@section('contenido')
    <div class="row">
        <div class="col-xs-6">
        <h3>Caja {{$caja->idcaja}}</h1>
            @if (count ($errors)>0)
                <div class="alert alert-danger">
                   <ul>
                        @foreach ($errors->all() as $error)
                               <li>{{$error}}</li>
                        @endforeach
                   </ul>
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="Encargado">Encargado</label>
                @if ($caja->encargado_nombre == null)
                    @foreach ($encargado as $enca)
                        @if ($enca->id==$caja->encargado)
                            <input type="text" name="encargado" value="{{ $enca->name}}" class="form-control" readonly="readonly">        
                        @endif
                    @endforeach
                @else
                    <input type="text" name="encargado" value="{{ $caja->encargado_nombre }}" class="form-control" readonly="readonly">
                @endif    
            </div>
        </div>   
        
        @can('isUser')
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="Fecha Apertura">Fecha Apertura</label>
                <input type="text"  name="fecha_apertura" class="form-control" readonly="readonly" value="{{ $caja->fecha_apertura }}">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="Fecha Apertura">Fecha Cierre</label>
                
                <input type="text"  name="fecha_cierre" class="form-control" readonly="readonly" value="{{$caja->fecha_cierre}}">
            </div>
        </div>    
        @endcan
    </div>

    

    <div class="row">

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <label for="Ventas">Ventas</label>
            {{-- ACA LISTAMOS TODAS LAS VENTAS DE CAJA --}}
                {{--BOTONES--}}
                <div class="row">
                    <div class="col-md-6">
                    <button class="btn btn-secondary" id="mostrar_todos_ventas" name="mostrar_todos_ventas">todos</button></button>    
                    <button class="btn btn-secondary" id="mostrar_todos_ventas_articulo" name="mostrar_todos_ventas_articulo">articulos</button></button>
                    </div>
                </div>
            <div class="panel panel-primary">
                <div id="todoventas" name="todoventas">
                    {{-- para descargar en EXCEL y en PDF --}}
                    <form action="{{URL::action('CajaController@show',$caja->idcaja)}}">
                        <input type="hidden" value="3" id="descargar_lista" name="descargar_lista">
                        <button class="label pull-right bg-green" >EXCEL</button>
                    </form>
                    <form action="{{URL::action('CajaController@show',$caja->idcaja)}}" target="_blank">
                        <input type="hidden" value="2" id="descargar_lista" name="descargar_lista">
                        <button class="label pull-right bg-red">PDF</button>
                        Descargar Ventas
                    </form>
                    {{-- FIN para descargar en EXCEL y en PDF --}}
                    @include('caja.partial.ventas')
                </div>
                <div id="todoventasarticulo" name="todoventasarticulo">
                    {{--DESCARGA DE LA LISTA DE LOS ARTICULOS VENDIDOS--}}
                    <form action="{{URL::action('CajaController@show',$caja->idcaja)}}">
                        <input type="hidden" value="4" id="descargar_lista" name="descargar_lista">
                        <button class="label pull-right bg-green" >EXCEL</button>
                    </form>
                    <form action="{{URL::action('CajaController@show',$caja->idcaja)}}" target="_blank">
                        <input type="hidden" value="1" id="descargar_lista" name="descargar_lista">
                        <button class="label pull-right bg-red">PDF</button>
                        Descargar Articulos
                    </form>
                    @include('caja.partial.ventas_articulo')
                </div>
            </div>
            {{-- FIN DE LISTAR VENTAS DE CAJA--}}    
        </div>

        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <label for="Ingresos">Ingresos</label>
            {{-- ACA LISTAMOS LOS INGRESOS DE CAJA --}}
                {{--BOTONES--}}
                <div class="row">
                    <div class="col-md-6">
                    <button class="btn btn-secondary" id="mostrar_todos_ingresos" name="mostrar_todos_ingresos">todos</button></button>    
                    <button class="btn btn-secondary" id="mostrar_todos_ingresos_articulo" name="mostrar_todos_ingresos_articulo">articulos</button></button>
                    </div>
                </div>
            <div class="panel panel-primary">
                <div id="todoingresos" name="todoingresos">
                    {{-- para descargar en EXCEL y en PDF --}}
                    <form action="{{URL::action('CajaController@show',$caja->idcaja)}}">
                        <input type="hidden" value="6" id="descargar_lista" name="descargar_lista">
                        <button class="label pull-right bg-green" >EXCEL</button>
                    </form>
                    <form action="{{URL::action('CajaController@show',$caja->idcaja)}}" target="_blank">
                        <input type="hidden" value="5" id="descargar_lista" name="descargar_lista">
                        <button class="label pull-right bg-red">PDF</button>
                        Descargar Ingresos
                    </form>
                    {{-- FIN para descargar en EXCEL y en PDF --}}
                    @include('caja.partial.ingresos')
                </div>
                <div id="todoingresosarticulo" name="todoingresosarticulo">
                    {{-- para descargar en EXCEL y en PDF --}}
                    <form action="{{URL::action('CajaController@show',$caja->idcaja)}}">
                        <input type="hidden" value="8" id="descargar_lista" name="descargar_lista">
                        <button class="label pull-right bg-green" >EXCEL</button>
                    </form>
                    <form action="{{URL::action('CajaController@show',$caja->idcaja)}}" target="_blank">
                        <input type="hidden" value="7" id="descargar_lista" name="descargar_lista">
                        <button class="label pull-right bg-red">PDF</button>
                        Descargar Articulos
                    </form>
                    {{-- FIN para descargar en EXCEL y en PDF --}}
                    @include('caja.partial.ingresos_articulo')
                </div>
            </div>
            {{-- FIN DE LISTAR LOS INGRESOS DE CAJA--}}
        </div>
    </div>
    {!!Form::model($caja,['method'=>'PATCH','route'=>['cajas.update',$caja->idcaja]])!!}
    {{Form::token()}} 

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <label for="Ventas">Ventas</label>
            <div class="panel panel-primary">
                <div class="table-responsive">
                    {{--BOTONES SUMAS DE VENTAS--}}
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
                        <div class="form-group">
                            <label for="efectivo">Efectivo</label>
                        <input type="number" name="efectivo" value="{{ $efectivo_venta }}" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
                        <div class="form-group">
                            <label for="Nota de venta">N de venta</label>
                        <input type="number" name="efectivo" value="{{ $nota_venta }}" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
                        <div class="form-group">
                            <label for="Con tarjeta">Con tarjeta</label>
                        <input type="number" name="efectivo" value="{{ $con_tarjeta }}" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
                        <div class="form-group">
                            <label for="Deposito">Deposito</label>
                        <input type="number" name="efectivo" value="{{ $deposito_pedido }}" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    {{--FIN BOTONES VENTAS--}}
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <label for="Ingresos">Ingresos</label>
            <div class="panel panel-primary">
                <div class="table-responsive">
                    {{--BOTONES SUMAS DE INGRESOS--}}
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
                        <div class="form-group">
                            <label for="efectivo">Factura</label>                            
                            <input type="number" name="factura" value={{ $factura_ingreso }} class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
                        <div class="form-group">
                            <label for="Nota de venta">Nota Ingreso</label>
                            <input type="number" name="nota_venta" value={{ $nota_ingreso }} class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
                        <div class="form-group">
                            <label for="Con tarjeta">Con tarjeta</label>
                            <input type="number" name="con_tarjeta" value={{ $tarjeta_ingreso }} class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    {{--FIN BOTONES INGRESOS--}}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
            <div class="form-group">
                <label for="inicio">Inicio</label>
            <input type="number" name="inicio" id="inicio" value="{{ $caja->inicio}}" class="form-control"  min="0" step=".01">
            <input type="hidden" name="idcaja" id="idcaja" value="{{ $caja->idcaja}}" class="form-control"  min="0" step=".01">
            </div>
        </div>
        @can('isAdmin')
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="Fecha Apertura">Fecha Apertura</label>
                <input type="text"  name="fecha_apertura" class="form-control"  value="{{ $caja->fecha_apertura }}">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="Fecha Apertura">Fecha Cierre</label>
                
                <input type="text"  name="fecha_cierre" class="form-control"  value="{{$caja->fecha_cierre}}">
            </div>
        </div>    
        @endcan
        
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="total Vendido">Toltal Vendido</label>
                <input type="number" name="total_vendido" id="total_vendido" value={{ $total_ingresos}} class="form-control" min="0" step=".01" readonly="readonly">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="total egresos">Toltal ingresos</label>
                <input type="number" name="total_ingresos" id="total_ingresos" value={{ $total_egresos }} class="form-control" min="0" step=".01" readonly="readonly">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="otros egresos">Otros (egresos)</label>
                <input type="number" name="otros_egresos" id="otros_egresos" value="{{$caja->otros_egresos}}" class="form-control" min="0" step=".01">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            {{-- <div class="form-group">
                <label for="Detalles egresos">Detalles (egresos)</label>
                <input type="text" name="detalles" class="form-control" value="{{$caja->detalles}}">
            </div> --}}
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="Cierre optimo">Cierre Optimo</label>
            <input type="number" name="cierre_optimo" id="cierre_optimo" value="{{$caja->cierre_optimo}}" class="form-control" min="0" step=".01" readonly="readonly" style="border: rgb(153, 153, 201) 2px solid;">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="Cierre real">Cierre real</label>
            <input type="number" name="cierre_real" value="{{$caja->cierre_real}}" class="form-control" min="0" step=".01" style="border: rgb(153, 153, 201) 2px solid;">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="Detalles egresos">Detalles (egresos)</label>
                {{-- <input type="text" name="detalles" class="form-control" value="{{$caja->detalles}}"> --}}
                <textarea class="form-control" name="detalles" id="detalles" cols="30" rows="10">{{$caja->detalles}}</textarea>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <a href="" data-target="#modal_cerrar" data-toggle="modal">
                    <button class="btn btn-primary">Cerrar</button>
                </a>
            </div>
        </div>
    </div>
    @include('caja.cajas.modal_cerrar')
    {!!Form::close()!!}
    
<button id="habilitar" class="btn btn-secondary">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
    <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
    <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg>
</button>

@endsection
@push('scripts')
<script>

    $(document).ready(function(){

        agregar();
        mostrar_todos_ventas();
        mostrar_todos_ingresos();
        agregar_otros();

        $("#otros_egresos").change(function()
        {
            agregar_otros();
        });
        $("#otros_egresos").keyup(function()
        {
            agregar_otros();
        });
        $("#mostrar_todos_ventas").click(function()
        {
            mostrar_todos_ventas();
        });
        $("#mostrar_todos_ventas_articulo").click(function()
        {
            mostrar_todos_ventas_articulo();
        });
        $("#mostrar_todos_ingresos").click(function()
        {
            mostrar_todos_ingresos();
        });
        $("#mostrar_todos_ingresos_articulo").click(function()
        {
            mostrar_todos_ingresos_articulo();
        });
       
    });
    function mostrar_todos_ventas(){
        var btn = document.getElementById("mostrar_todos_ventas");
        btn.style.backgroundColor="#3c8dbc";
        var btn = document.getElementById("mostrar_todos_ventas_articulo");
        btn.style.backgroundColor="";
        $("#todoventas").show();
        $("#todoventasarticulo").hide();
    }
    function mostrar_todos_ventas_articulo(){
        var btn = document.getElementById("mostrar_todos_ventas_articulo");
        btn.style.backgroundColor="#3c8dbc";
        var btn = document.getElementById("mostrar_todos_ventas");
        btn.style.backgroundColor="";
        $("#todoventas").hide();
        $("#todoventasarticulo").show();
    }
    function mostrar_todos_ingresos(){
        var btn = document.getElementById("mostrar_todos_ingresos");
        btn.style.backgroundColor="#3c8dbc";
        var btn = document.getElementById("mostrar_todos_ingresos_articulo");
        btn.style.backgroundColor="";
        $("#todoingresos").show();
        $("#todoingresosarticulo").hide();
    }
    function mostrar_todos_ingresos_articulo(){
        var btn = document.getElementById("mostrar_todos_ingresos_articulo");
        btn.style.backgroundColor="#3c8dbc";
        var btn = document.getElementById("mostrar_todos_ingresos");
        btn.style.backgroundColor="";
        $("#todoingresos").hide();
        $("#todoingresosarticulo").show();
    }

    function agregar(){
        total=0;
        inicio=0;
        inicio=$("#inicio").val();
        inicio=parseFloat(inicio);
        total_vendido=0;
        total_vendido=$("#total_vendido").val();
        total_vendido=parseFloat(total_vendido);
        ingresos=0;
        ingresos=$("#total_ingresos").val();
        ingresos=parseFloat(ingresos);
        total=inicio+total_vendido-ingresos;
        $("#cierre_optimo").val(total);
    }
    function agregar_otros(){
        total=0;
        inicio=0;
        inicio=$("#inicio").val();
        inicio=parseFloat(inicio);
        total_vendido=0;
        total_vendido=$("#total_vendido").val();
        total_vendido=parseFloat(total_vendido);
        ingresos=0;
        ingresos=$("#total_ingresos").val();
        ingresos=parseFloat(ingresos);
        egresos=0;
        egresos=$("#otros_egresos").val();
        if(egresos==""){
            egresos=0;
        }
        egresos=parseFloat(egresos);
        total=inicio+total_vendido-ingresos-egresos;
        $("#cierre_optimo").val(total);
    }
 </script>
@endpush
