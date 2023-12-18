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
