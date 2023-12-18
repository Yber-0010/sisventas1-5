<style>
    td {
    border: 1px royalblue dotted;
   /* width: 100px;*/
    height: 50px;
    text-align: center;
    /*font-weight: bold;*/
}

#taula {
    height: 400px !important;
    overflow: auto;
    /*width: 220px;*/
}
</style>
<div class="table-responsive">
    <div id="taula">
        <table class="table table-striped table-bordered table-condensed table-hover">
            <thead>
            <th>Idventa</th>
            <th>Articulo</th>
            <th>Cantidad</th>
            <th>Precio_venta</th>
            <th>Descuento</th>
            <th>Sub_total</th>
            </thead>
            @foreach ($articulos_vendidos as $art_v)
                    <tr>            
                        <td>{{ $art_v->idventa}}</td>
                        <td>{{ $art_v->articulo}}</td>
                        <td>{{ $art_v->cantidad}}</td>
                        <td>{{ $art_v->precio_venta}}</td>
                        <td>{{ $art_v->descuento}}</td>
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
            
        </table>
        {{--------------------------------}}
    </div>
</div>
<div class="table-responsive">
    {{-- SUMAS --}}
    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
        <div class="form-group">
            <label for="efectivo">cantidad<br>total</label>
        <input type="number" name="efectivo" value="{{ $cantidad_total_ventas + $cantidad_total_pedidos }}" class="form-control"  min="0" step=".01" readonly="readonly">
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
        <div class="form-group">
            <label for="Nota de venta">descuento<br>total</label>
        <input type="number" name="efectivo" value="{{ $descuento_total_ventas + $descuento_total_pedidos }}" class="form-control"  min="0" step=".01" readonly="readonly">
        </div>
    </div>
    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
        <div class="form-group">
            <label for="Con tarjeta">Sub total<br>total</label>
        <input type="number" name="efectivo" value="{{ $total_ingresos}}" class="form-control"  min="0" step=".01" readonly="readonly">
        </div>
    </div>
    {{--FIN SUMAS VENTAS--}}
</div>
