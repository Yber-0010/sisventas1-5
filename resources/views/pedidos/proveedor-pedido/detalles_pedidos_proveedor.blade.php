<style>
    .table {
        width: 100%;
        border: 2px solid rgb(226, 226, 226);
        /* text-align: center;         */
    }
</style>

{{-- -------- --}}
Fuente de Vida
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="table-responsive">
            <table class="table">
                <tr>
                    <td>
                        @foreach($persona as $persona)
                            @if($persona->idpersona==$pedidos->id_proveedor)
                            <label for="nombre">Proveedor</label> <span style="font-size: 120%"><strong>&nbsp;{{$persona->nombre}}</strong></span> <br>
                            <label for="nombre">Telefono</label> &nbsp;{{$persona->telefono}}
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <label for="nombre">Fecha pedido </label> {{\Carbon\Carbon::parse($pedidos->fecha_inicio)->format('d-m-y h:i')}}<br>
                        <label for="nombre">Fecha finalizado </label>
                        @if ( $pedidos->fecha_fin == null)
                            
                        @else
                             {{\Carbon\Carbon::parse($pedidos->fecha_fin)->format('d-m-y h:i')}}    
                        @endif
                        
                    </td>
                    <td>
                        <label for="id_pedido">Nro</label>
                        <p>{{$idshow}}</p>
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
                                <th>Artículo</th>
                                <th>Pedido</th>
                                <th>Stock {{\Carbon\Carbon::parse($pedidos->fecha_inicio)->format('d-m-y')}}</th>
                                <th>Precio Compra</th>
                                <th>Descuento</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($detalles_pedido as $det)
                            <tr>
                                <td>{{$det->articulo}}  {{$det->peso}}</td>
                                <td>{{$det->cantidad}}</td>
                                <td>{{$det->stock}}</td>
                                <td>{{$det->precio_compra}}</td>
                                <td>{{$det->descuento}}</td>
                                <td>{{$det->cantidad*$det->precio_compra-$det->descuento}}</td>
                            </tr>
                            @endforeach
                            @foreach($detalles_pedido_null as $det)
                            <tr>
                                <td style="color: blue">{{$det->otro}}</td>
                                <td>{{$det->cantidad}}</td>
                                <td>...</td>
                                <td>{{$det->precio_compra}}</td>
                                <td>{{$det->descuento}}</td>
                                <td>{{$det->cantidad*$det->precio_compra-$det->descuento}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>detalle <br>{{$pedidos->detalles}}</th>
                                <th><h4>Total</h4></th>
                                <th><h4 id="total">{{$total}} Bs</h4></th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>
@push('scripts')
<script>
    $(document).ready(function(){
        sumTotal();
    });
    var total=0;
    function sumTotal() {
        var sumTotal = @json($sum_pedido);
        for (let i=0 ; i<sumTotal.length ; i++) {
            cantidad = sumTotal[i].cantidad;
            precio_compra = sumTotal[i].precio_compra;
            descuento = sumTotal[i].descuento;
            total = total+(cantidad*precio_compra-descuento);
        }
        $("#total").html("Bs. "+ total);
    }
</script>    
@endpush
    
