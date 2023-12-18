<style>
    .table {
        width: 100%;
        border: 2px solid rgb(226, 226, 226);
        /* text-align: center;         */
    }
</style>
{{-- -------- --}}
fuente de vida
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td>
                        <label for="nombre">Cliente</label> {{$pedidos->nombre_cliente}} <br>
                        <label for="nombre">Telefono</label> {{$pedidos->celular_cliente}}
                    </td>
                    <td>
                        <label for="nombre">Fecha pedido </label> {{$pedidos->fecha_hora_inicio}}<br>
                        <label for="nombre">Entrega para </label> {{$pedidos->fecha_hora_entrega}} {{$pedidos->hora}}
                    </td>
                    <td>
                        <label for="idventa">Nro</label>
                        <p>{{$idshow}}</p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="">Tipo Comprobante</label>
                        <p>{{$pedidos->tipo_comprobante}}</p>
                    </td>
                    <td>
                        <label for="serie_comprobante">Serie Comprobante</label>
                        <p>{{$pedidos->serie_comprobante}}</p>
                    </td>
                    <td>
                        <label for="num_comprobante">Numero Comprobante</label>
                        <p>{{$pedidos->num_comprobante}}</p>
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
                            @foreach($detalles_pedido as $det)
                            <tr>
                                <td>{{$det->articulo}}</td>
                                <td>{{$det->cantidad}}</td>
                                <td>{{$det->precio_venta}}</td>
                                <td>{{$det->descuento}}</td>
                                <td>{{$det->cantidad*$det->precio_venta-$det->descuento}}</td>
                            </tr>
                            @endforeach
                            @foreach($detalles_pedido_null as $det)
                            <tr>
                                <td style="color: blue">{{$det->otro}}</td>
                                <td>{{$det->cantidad}}</td>
                                <td>{{$det->precio_venta}}</td>
                                <td>{{$det->descuento}}</td>
                                <td>{{$det->cantidad*$det->precio_venta-$det->descuento}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th>a cuenta <br> {{$pedidos->a_cuenta}} Bs</th>
                                <th>saldo <br> {{$pedidos->saldo}} Bs</th>
                                <th>detalle <br>{{$pedidos->detalles}}</th>
                                <th><h4>Total</h4></th>
                                <th><h4 id="total">{{$pedidos->total_venta}} Bs</h4></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
    
