@extends('layouts.admin')

@section('contenido')
    <div class="row">
        <div class="col-xs-6">
            <h3>Caja {{$caja->idcaja}}</h1>
            {{-- descargar toda la caja en pdf --}}
            <form action="{{URL::action('CajaController@show',$caja->idcaja)}}" target="_blank">
                <input type="hidden" value="todo" id="descargar_lista" name="descargar_lista">
                <button class="label pull-left bg-red">PDF</button>
            </form>
            {{-- <form action="{{URL::action('CajaController@show',$caja->idcaja)}}">
                <input type="hidden" value="todoExcel" id="descargar_lista" name="descargar_lista">
                <button class="label pull-left bg-green" >EXCEL</button>
            </form> --}}
            {{-- fin de descargar toda la caja en pdf --}}
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
    </div>

    

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <label for="Ventas">Ventas</label>
            {{-- ACA LISTAMOS TOAS LAS VENTAS DE CAJA --}}
            <div class="row">
                <div class="col-md-6">
                <button class="btn btn-secondary" id="mostrar_todos_ventas" name="mostrar_todos_ventas">todos</button>
                <button class="btn btn-secondary" id="mostrar_todos_ventas_articulo" name="mostrar_todos_ventas_articulo">articulos</button>
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
                    @include('caja.partial1.sventas')
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
                    @include('caja.partial1.sventas_articulo')
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
                <button class="btn btn-secondary" id="mostrar_todos_ingresos" name="mostrar_todos_ingresos">todos</button>
                <button class="btn btn-secondary" id="mostrar_todos_ingresos_articulo" name="mostrar_todos_ingresos_articulo">articulos</button>
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
                    @include('caja.partial1.singresos')
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
                    @include('caja.partial1.singresos_articulo')
                </div>
            </div>
            {{-- FIN DE LISTAR LOS INGRESOS DE CAJA--}}
        </div>
    </div>

    

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-4">
            <div class="form-group">
                <label for="inicio">Inicio</label>
            <input type="number" name="inicio" id="inicio" value="{{ $caja->inicio}}" class="form-control"  min="0" step=".01" readonly="readonly">
            <input type="hidden" name="idcaja" id="idcaja" value="{{ $caja->idcaja}}" class="form-control"  min="0" step=".01">
            </div>
        </div>
        
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
            <input type="number" name="otros_egresos" id="otros_egresos" value="{{$caja->otros_egresos}}" class="form-control" min="0" step=".01" readonly="readonly">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="Detalles egresos">Detalles (egresos)</label>
            <input type="text" name="detalles" class="form-control" value="{{$caja->detalles}}" readonly="readonly">
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="Cierre optimo">Cierre Optimo</label>
                @if ($caja->cierre_optimo == null)
                <input type="number" name="cierre_optimo" id="cierre_optimo" value="{{$caja->cierre_optimo}}" class="form-control" min="0" step=".01" readonly="readonly">                            
                @else
                <input type="number" {{-- name="cierre_optimo" id="cierre_optimo" --}} value="{{$caja->cierre_optimo}}" class="form-control" min="0" step=".01" readonly="readonly">        
                @endif
            </div>
        </div>
        <div class="col-lg-3 col-sm-6 col-md-6 col-xs-6">
            <div class="form-group">
                <label for="Cierre real">Cierre real</label>
            <input type="number" name="cierre_real" value="{{$caja->cierre_real}}" class="form-control" min="0" step=".01" readonly="readonly">
            </div>
        </div>
    </div>

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
        /*   
        egresos=parseFloat(egresos);
        total=inicio+total_vendido-ingresos-egresos;
        $("#cierre_optimo").val(total); */
    }
    
 </script>
@endpush