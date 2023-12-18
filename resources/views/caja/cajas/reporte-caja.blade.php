
<style>
    .table {
        width: 100%;
        border: 2px solid rgb(226, 226, 226);
        text-align: center;
        
    }
    td {
    /* border: 1px royalblue dotted; */
   /* width: 100px;*/
    /* height: 50px; */
    /* text-align: center; */
    /*font-weight: bold;*/
    }
/* taula para barra lateral */
    
</style>
{{-- REPORTE CAJA ENTERA --}}
{{-- REPORTE DE CAJA --}}
<div class="panel panel-primary">
    <div class="table-responsive">
        {{-- SUMAS --}}
        <table class="table">
            <tr>
                <td colspan="4">
                    <h3>Fuente de Vida</h3>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label for="caja">Reporte Caja</label>
                        <p>{{$caja->idcaja}}</p>
                    </div>
                </td>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label for="Encargado">Encargado</label>
                        {{-- <output class="form-control">{{ $nota_venta }}</output> --}}
                        @if ($caja->encargado_nombre == null)
                            @foreach ($encargado as $enca)
                                @if ($enca->id==$caja->encargado)
                                    <p>{{ $enca->name}}</p>
                                @endif
                            @endforeach
                        @else
                            <p>{{ $caja->encargado_nombre }}</p>
                        @endif 
                    </div>
                </td>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label for="Fecha de apertura">Fecha de apertura</label>
                        {{-- <output class="form-control">{{ $con_tarjeta }}</output> --}}
                        <p>{{ $caja->fecha_apertura }}</p>
                    </div>
                </td>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label for="Fecha de cierre">Fecha de cierre</label>
                        {{-- <output class="form-control">{{ $con_tarjeta }}</output> --}}
                        <p>{{$caja->fecha_cierre}}</p>
                    </div>
                </td>
            </tr>
            <tr>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label for="Inicio">Inicio</label>
                        <p>{{ $caja->inicio}}</p>
                    </div>
                </td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label for="Total Vendido">Total Vendido</label>
                    <p>{{ $total_ingresos}}</p>
                    </div>
                </td>
                <td></td>
                <td> 
                    <label for="Total Egresos">Total Egresos</label>
                    <p>{{ $total_egresos }}</p>
                </td>
                <td></td>
            </tr>
            <tr>
                <td>
                    <label for="Otros Egresos">Otros Egresos</label>
                    <p>{{$caja->otros_egresos}}</p>
                </td>
                <td>
                    <p>{{$caja->detalles}}</p>
                </td>
                <td>
                    <label for="Cierre Optimo">Cierre Optimo</label>
                    <p>{{$caja->cierre_optimo}}</p>
                </td>
                <td>
                    <label for="Cierre Real">Cierre Real</label>
                    <p>{{$caja->cierre_real}}</p>
                </td>
            </tr>
        </table>
        {{--FIN SUMAS VENTAS--}}
    </div>
    </div>
{{-- REPORTE VENTAS --}}
<div class="table-responsive">
    <div id="taula1">
        <table class="table table-striped table-bordered table-condensed table-hover">
            <thead>
                <tr>
                    <td colspan="2">
                        fecha de apertura <br>
                        {{ $caja->fecha_apertura }}
                    </td>
                    <td colspan="3">
                    <h4>Lista de ventas</h4>
                    </td>
                    <td colspan="2">
                        fecha de cierre <br>
                        {{$caja->fecha_cierre}}
                    </td>
                </tr>
                <tr>
                    <th>Id venta</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Comprobante</th>
                    <th>Impuesto</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>
            @foreach ($ventas as $ven)
            <tr>
                <td>{{ $ven->idventa}}</td>              
                <td>{{ $ven->fecha_hora}}</td>
                <td>{{ $ven->nombre}}</td>
                <td>{{ $ven->tipo_comprobante.':-'.$ven->serie_comprobante.'--'.$ven->num_comprobante}}</td>
                <td>{{ $ven->impuesto}}</td>
                <td>{{ $ven->total_venta}}</td>
                <td>{{ $ven->estado}}</td>
            </tr>
            @endforeach 
            @foreach ($pedidos as $ped)
                    <tr>
                        <td>Pedido: {{ $ped->id}}</td>              
                        <td>
                            <p>inicio: &nbsp;{{ $ped->fecha_hora_inicio}}</p>
                            <p>fin: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{{ $ped->fecha_hora_finalizado}}</p>
                        </td>
                        <td>{{ $ped->nombre_cliente}}</td>
                        <td>{{ $ped->tipo_comprobante.':-'.$ped->serie_comprobante.'--'.$ped->num_comprobante}}</td>
                        <td>{{ $ped->impuesto}}</td>
                        <td>
                            <p>cuenta: {{$ped->a_cuenta}}</p>
                            <p>saldo: {{$ped->saldo}}</p>
                            <p>total: {{ $ped->total_venta}}</p>
                        <td>
                        @if ($ped->estado=='ACTIVO')
                            <button  class="badge badge-primary text-wrap" style="width: 6rem; background: rgb(51, 93, 184)">{{$ped->estado}}</button>
                        @endif
                        @if ($ped->estado=='FINALIZADO')
                            <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(2, 99, 31)">{{$ped->estado}}</button>
                        @endif
                        @if ($ped->estado=='RECHAZADO')                            
                            <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(199, 58, 58)">{{$ped->estado}}</button>
                        @endif
                            @if ($ped->recogio=="no recogio")
                            <div class="label pull-right bg-red">{{ $ped->recogio }}</div>
                            @endif
                            @if ($ped->recogio=="entregado")
                            <div class="label pull-right bg-green">{{ $ped->recogio }}</div>
                            @endif
                            @if ($ped->recogio== null)
                            <div>...</div>
                            @endif
                        </td>
                        
                        
                    </tr>
            
            @endforeach 
        </table>
    </div>
    {{--------------------------------}}
</div>
<div class="panel panel-primary">
<div class="table-responsive">
    {{-- SUMAS --}}
    <table class="table">
        <tr>
            <td>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label for="efectivo">efectivo</label>
                    {{-- <output class="form-control">{{ $efectivo_venta }}</output> --}}
                    <p>{{ $efectivo_venta }}</p>
                </div>
            </td>
            <td>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label for="Nota de venta">N de venta</label>
                    {{-- <output class="form-control">{{ $nota_venta }}</output> --}}
                    <p>{{ $nota_venta }}</p>
                </div>
            </td>
            <td>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label for="Con tarjeta">Con tarjeta</label>
                    {{-- <output class="form-control">{{ $con_tarjeta }}</output> --}}
                    <p>{{ $con_tarjeta }}</p>
                </div>
            </td>
            <td>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label for="Con tarjeta">Deposito</label>
                    {{-- <output class="form-control">{{ $con_tarjeta }}</output> --}}
                    <p>{{ $deposito_pedido }}</p>
                </div>
            </td>
        </tr>
    </table>
    {{--FIN SUMAS VENTAS--}}
</div>
</div>
{{-- FIN REPORTE VENTAS --}}

{{-- REPORTE VENTAS LISTA DE ARTICULOS --}}
<div class="table-responsive">
    <div id="taula">
    <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <td colspan="2">
                    fecha de apertura <br>
                    {{ $caja->fecha_apertura }}
                </td>
                <td colspan="2">
                <h4>Lista de articulos vendidos</h4>
                </td>
                <td colspan="2">
                    fecha de cierre <br>
                    {{$caja->fecha_cierre}}
                </td>
            </tr>
            <tr>
                <th>Idventa</th>
                <th>Articulo</th>
                <th>Cantidad</th>
                <th>Descuento</th>
                <th>Precio_venta</th>
                <th>Sub_total</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($articulos_vendidos as $art_v)
            <tr>            
                <td>{{ $art_v->idventa}}</td>
                <td>{{ $art_v->articulo}}</td>
                <td>{{ $art_v->cantidad}}</td>
                <td>{{ $art_v->descuento}}</td>
                <td>{{ $art_v->precio_venta}}</td>
                <td>{{$art_v->cantidad*$art_v->precio_venta-$art_v->descuento}}</td>
            </tr>
        @endforeach
        @foreach ($articulos_pedidos as $ap)
            <tr>            
                @if ($ap->estado == "FINALIZADO")
                    <td style="color: green"> pedido: {{$ap->estado}}<br>{{ $ap->id}}</td>    
                @endif
                @if ($ap->estado == "RECHAZADO")
                    <td style="color: red"> pedido: {{$ap->estado}}<br>{{ $ap->id}}</td>    
                @endif
                @if ($ap->estado == "ACTIVO")
                    <td style="color: blue"> pedido: {{$ap->estado}}<br>{{ $ap->id}}</td>    
                @endif
                <td>{{ $ap->articulo}}</td>
                <td>{{ $ap->cantidad}}</td>
                <td>{{ $ap->precio_venta}}</td>
                <td>{{ $ap->descuento}}</td>
                <td>{{$ap->cantidad*$ap->precio_venta-$ap->descuento}}</td>
            </tr>
        @endforeach  
        </tbody>
    </table>
    </div>
    {{--------------------------------}}
</div>
<div class="panel panel-primary">
<div class="table-responsive">
    {{-- SUMAS --}}
    <table class="table">
        <tr>
            <td>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label for="efectivo">cantidad</label>
                    <p>{{ $cantidad_total_ventas + $cantidad_total_pedidos }}</p>
                </div>
            </td>
            <td>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label for="Nota de venta">descuento</label>
                    {{-- <output class="form-control">{{ $descuento_total_ventas }}</output> --}}
                    <p>{{ $descuento_total_ventas + $descuento_total_pedidos }}</p>
                </div>
            </td>
            <td>
                <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <label for="Con tarjeta">Sub total</label>
                    {{-- <output class="form-control">{{ $total_ingresos}}</output> --}}
                    <p>{{ $total_ingresos}}</p>
                </div>
            </td>
        </tr>
    </table>
    {{--FIN SUMAS VENTAS--}}
</div>
</div>
{{-- FIN REPORTE LISTA VENTA ARTICULOS --}}

{{-- REPORTE DE INGRESOS --}}
<div class="table-responsive">
    <div id="taula">
    <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <td colspan="2">
                    fecha de apertura <br>
                    {{ $caja->fecha_apertura }}
                </td>
                <td colspan="3">
                <h4>Lista de Ingresos</h4>
                </td>
                <td colspan="2">
                    fecha de cierre <br>
                    {{$caja->fecha_cierre}}
                </td>
            </tr>
            <tr>
                <th>Id ingreso</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Comprobante</th>
                <th>Impuesto</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Detalles</th>
            </tr>
        </thead>
        @foreach ($ingresos as $ing)
        <tr>
            <td>{{ $ing->idingreso}}</td>              
            <td>{{ $ing->fecha_hora}}</td>
            <td>{{ $ing->nombre}}</td>
            <td>{{ $ing->tipo_comprobante.':-'.$ing->serie_comprobante.'--'.$ing->num_comprobante}}</td>
            <td>{{ $ing->impuesto}}</td>
            <td>{{ $ing->total_venta}}</td>
            <td>{{ $ing->estado.' '.$ing->obserbacion}}</td>
            <td style="color: blue;">{{ $ing->detalles}}</td>
        </tr>
        @endforeach  
    </table>
    </div>
</div>
<div class="panel panel-primary">
    <div class="table-responsive">
        {{-- SUMAS --}}
        <table class="table">
            <tr>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label for="factura">Factura</label>
                        {{-- <output class="form-control">{{ $efectivo_venta }}</output> --}}
                        <p>{{ $factura_ingreso }}</p>
                    </div>
                </td>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label for="Nota de ingreso">N Ingreso</label>
                        {{-- <output class="form-control">{{ $nota_venta }}</output> --}}
                        <p>{{ $nota_ingreso }}</p>
                    </div>
                </td>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label for="Con tarjeta">Con tarjeta</label>
                        {{-- <output class="form-control">{{ $con_tarjeta }}</output> --}}
                        <p>{{ $tarjeta_ingreso }}</p>
                    </div>
                </td>
            </tr>
        </table>
        {{--FIN SUMAS VENTAS--}}
    </div>
    </div>
{{-- FIN REPORTE INGRESOS --}}

{{-- REPORTE INGRESOS ARTICULOS --}}
<div class="table-responsive">
    <div id="taula">
    <table class="table table-striped table-bordered table-condensed table-hover">
        <thead>
            <tr>
                <td colspan="2">
                    fecha de apertura <br>
                    {{ $caja->fecha_apertura }}
                </td>
                <td colspan="2">
                <h4>Lista de articulos ingresados</h4>
                </td>
                <td colspan="2">
                    fecha de cierre <br>
                    {{$caja->fecha_cierre}}
                </td>
            </tr>
            <tr>
                <th>Idingreso</th>
                <th>Articulo</th>
                <th>Cantidad</th>
                <th>P. compra</th>
                <th>P. venta</th>
                <th>fecha vencimiento</th>
                <th>Sub total</th>
            </tr>
        </thead>
        @foreach ($detalles_ingresados as $det)
                <tr>            
                    <td>{{ $det->idingreso}}</td>
                    <td>{{ $det->articulo}}</td>
                    <td>{{ $det->cantidad}}</td>
                    <td>{{ $det->precio_compra}}</td>
                    <td>{{ $det->precio_venta}}</td>
                    <td>{{ $det->fecha_vencimiento}}</td>
                    <td>{{ $det->cantidad*$det->precio_compra}}</td>
                </tr>
        @endforeach 
    </table>
    </div>
</div>
{{--------------------------------}}
<div class="panel panel-primary">
    <div class="table-responsive">
        {{-- SUMAS --}}
        <table class="table">
            <tr>
                <td>
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <label for="cantidad_ingresos">cantidad</label>
                        <p>{{$cantidad_total_ingresos}}</p>
                    </div>
                </td>
            </tr>
        </table>
        {{--FIN SUMAS INGRESOS--}}
    </div>
</div>
{{--------------------------------}}

{{-- FIN REPORTE INGRESOS ARTICULOS --}}