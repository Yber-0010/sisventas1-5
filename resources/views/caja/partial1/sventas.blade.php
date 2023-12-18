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
    #taula {
        /* position:relative; */
        /* display:block; */
        /* float: left; */
        height: 400px !important;
        overflow: auto;
        /*width: 220px;*/
    }
</style>
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