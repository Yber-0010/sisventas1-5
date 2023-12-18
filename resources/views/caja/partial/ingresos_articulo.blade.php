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
            <th>Idingreso</th>
            <th>Articulo</th>
            <th>Cantidad</th>
            <th>P. compra</th>
            <th>P. venta</th>
            <th>fecha vencimiento</th>
            <th>Sub total</th>
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
    {{--------------------------------}}
</div>
<div class="table-responsive">
    {{-- SUMAS --}}
    <div class="col-lg-3 col-sm-6 col-md-6 col-xs-4">
        <div class="form-group">
            <label for="efectivo">cantidad<br>total</label>
        <input type="number" name="efectivo" value="{{$cantidad_total_ingresos}}" class="form-control"  min="0" step=".01" readonly="readonly">
        </div>
    </div>
    {{--FIN SUMAS INGRESOS--}}
</div>