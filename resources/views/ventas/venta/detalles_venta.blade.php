<style>
    .table {
        width: 100%;
        border: 2px solid rgb(226, 226, 226);
        /* text-align: center;         */
    }
</style>
{{-- -------- --}}
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td>
                        <label for="nombre">Cliente</label>
                        <p>{{$venta->nombre}}</p>
                    </td>
                    <td></td>
                    <td>
                        <label for="idventa">Nro</label>
                        <p>{{$idshow}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="">Tipo Comprobante</label>
                        <p>{{$venta->tipo_comprobante}}</p>
                    </td>
                    <td>
                        <label for="serie_comprobante">Serie Comprobante</label>
                        <p>{{$venta->serie_comprobante}}</p>
                    </td>
                    <td>
                        <label for="num_comprobante">Numero Comprobante</label>
                        <p>{{$venta->num_comprobante}}</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
{{-- -------- --}}
<div class="row">
    <div class="panel panel-primary">
        <div class="panel-body">
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="table-responsive">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <tr>
                                <th>Articulo</th>
                                <th>Cantidad</th>
                                <th>Precio_venta</th>
                                <th>Descuento</th>
                                <th>subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalles as $det)
                            <tr>
                                <td>{{$det->articulo}}</td>
                                <td>{{$det->cantidad}}</td>
                                <td>{{$det->precio_venta}}</td>
                                <td>{{$det->descuento}}</td>
                                <td>{{$det->cantidad*$det->precio_venta-$det->descuento}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th><h4>Total</h4></th>
                                <th><h4 id="total">{{$venta->total_venta}}</h4></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
    
