<style>
    .table {
        width: 100%;
        border: 2px solid rgb(226, 226, 226);
        text-align: center;
    }
    #taula1 {
        /* position:relative; */
        /* display:block; */
        /* float: left; */
        height: 400px !important;
        overflow: auto;
        /*width: 220px;*/
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


