@extends('layouts.admin')

@section('contenido')
    <div class="row">
        <div class="col-xs-6">
            <h3>Nueva Caja</h1>
        </div>
    </div>
{!!Form::open(['url'=>'caja/cajas', 'method'=>'POST','autocomplete'=>'off']) !!}
{{Form::token()}}
    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="Encargado">Encargado</label>
                <input type="text" name="encargado" value="{{Auth::user()->name}}" class="form-control" readonly="readonly">
            </div>
        </div>   
        @can('isAdmin')
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="Fecha Apertura">Fecha Apertura</label>
                <input type="text"  name="fecha_apertura" class="form-control"  value="{{ $mytime }}">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="Fecha Apertura">Fecha Cierre</label>
                <input type="text"  name="fecha_cierre" class="form-control" value="">
            </div>
        </div>
        @endcan
        @can('isUser')
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="Fecha Apertura">Fecha Apertura</label>
                <input type="text"  name="fecha_apertura" class="form-control" readonly="readonly" value="{{ $mytime }}">
            </div>
        </div>    
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="Fecha Apertura">Fecha Cierre</label>
                <input type="text"  name="fecha_cierre" class="form-control" readonly="readonly" value="">
            </div>
        </div>
        @endcan
            
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <label for="Ventas">Ventas</label>
            <div class="panel panel-primary">
    {{-- ACA LISTAMOS TOAS LAS VENTAS DE CAJA --}}    
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Comprobante</th>
                        <th>Impuesto</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                        </thead>
                    </table>
                    {{--BOTONES SUMAS DE VENTAS--}}
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="efectivo">Efectivo</label>
                            <input type="number" name="efectivo" value="0" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="Nota de venta">N de venta</label>
                            <input type="number" name="efectivo" value="0" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="Con tarjeta">Con tarjeta</label>
                            <input type="number" name="efectivo" value="0" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    {{--FIN BOTONES VENTAS--}}
                </div>
    {{-- FIN DE LISTAR VENTAS DE CAJA--}}    
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <label for="Ingresos">Ingresos</label>
            <div class="panel panel-primary">
    {{-- ACA LISTAMOS LOS INGRESOS DE CAJA --}}
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-condensed table-hover">
                        <thead>
                            <th>Fecha</th>
                            <th>Proveedor</th>
                            <th>Comprobante</th>
                            <th>Impuesto</th>
                            <th>Total</th>
                            <th>Estado</th>
                            <th>Opciones</th>
                        </thead>
                        
                    </table>
                    {{--BOTONES SUMAS DE INGRESOS--}}
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="efectivo">Efectivo</label>
                            <input type="number" name="efectivo" value="0" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="Nota de venta">N de venta</label>
                            <input type="number" name="efectivo" value="0" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="Con tarjeta">Con tarjeta</label>
                            <input type="number" name="efectivo" value="0" class="form-control"  min="0" step=".01" readonly="readonly">
                        </div>
                    </div>
                    {{--FIN BOTONES INGRESOS--}}
                </div>
    {{-- FIN DE LISTAR LOS INGRESOS DE CAJA--}}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="inicio">Inicio</label>
                <input type="number" name="inicio" value="0" class="form-control"  min="0" step=".01">
            </div>
        </div>
        {{----}}
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <input type="hidden" name="iduser" value="{{Auth::user()->id}}" class="form-control" readonly="readonly">
            </div>
        </div> 
        {{----}}
    </div>

    <div class="row">
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="total Vendido">Toltal Vendido</label>
                <input type="number" value="0" class="form-control" min="0" step=".01" readonly="readonly">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="total egresos">Toltal ingresos (egresos)</label>
                <input type="number" value="0" class="form-control" min="0" step=".01" readonly="readonly">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="otros egresos">Otros (egresos)</label>
                <input type="number" value="0" class="form-control" min="0" step=".01" readonly="readonly">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            {{-- <div class="form-group">
                <label for="Detalles egresos">Detalles (egresos)</label>
                <input type="text" class="form-control" readonly="readonly">
            </div> --}}
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="Cierre optimo">Cierre Optimo</label>
                <input type="number" value="0" class="form-control" min="0" step=".01" readonly="readonly">
            </div>
        </div>
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <label for="Cierre real">Cierre real</label>
                <input type="number" name="cierre_real" value="0" class="form-control" min="0" step=".01" readonly="readonly">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
            <div class="form-group">
                <label for="Detalles egresos">Detalles (egresos)</label>
                <input type="text" class="form-control" readonly="readonly">
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
            <div class="form-group">
                <input name="_token" value="{{csrf_token()}}" type="hidden">
                <a href="" data-target="#modal_guardar" data-toggle="modal">
                    <button class="btn bg-primary" >Guardar</button>
                </a>
            </div>
        </div>
    </div>
    @include('caja.cajas.modal_guardar')
{!!Form::close()!!}
<button id="habilitar" class="btn btn-secondary">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
      <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
      <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
    </svg>
    </button>
@endsection
