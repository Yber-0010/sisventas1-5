<style>
    .table {
        width: 100%;
        border: 2px solid rgb(226, 226, 226);
        text-align: center;
    }
</style>
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