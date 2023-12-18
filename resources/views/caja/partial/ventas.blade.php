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
            <th>Id</th>
            <th>Fecha</th>
            <th>Cliente</th>
            <th>Comprobante</th>
            <th>Impuesto</th>
            <th>Total</th>
            <th>Estado</th>
            <th>Opciones</th>
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
                        <td>
                        <a href="{{URL::action('VentaController@show',$ven->idventa)}}"><button class="btn btn-primary">Detalles</button></a>
                            <a href="" data-target="#modal-delete-{{$ven->idventa}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
                        </td>
                    </tr>
            @include('ventas.venta.modal') 
            @endforeach 
            {{-- ACA LISTAMOS PEDIDOS --}}
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
                                <a href="{{URL::action('PedidoController@edit',$ped->id)}}"><button  class="badge badge-primary text-wrap" style="width: 6rem; background: rgb(51, 93, 184)">{{$ped->estado}}</button></a>
                            @endif
                            @if ($ped->estado=='FINALIZADO')
                                <a href="{{URL::action('PedidoController@edit',$ped->id)}}">
                                <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(2, 99, 31)">{{$ped->estado}}</button>
                                </a>
                            @endif
                            @if ($ped->estado=='RECHAZADO')
                                <a href="{{URL::action('PedidoController@edit',$ped->id)}}">               
                                <button  class="badge badge-primary text-wrap" style="width: 8rem; background: rgb(199, 58, 58)">{{$ped->estado}}</button>
                                </a>
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
                        <td>
                            <a href="{{URL::action('PedidoController@show',$ped->id)}}"><button class="btn btn-primary">Detalles</button></a>
                        
                            <form action="{{URL::action('PedidoController@show',$ped->id)}}" target="_blank">
                            <button class="btn btn-primary  bg-blue">PDF</button>
                            <input type="hidden" value="2" id="descargar_detalles" name="descargar_detalles">
                            </form>
                        </td>
                    </tr>
            
            @endforeach 
            {{-- FIN LISTAR PEDIDOS --}}
        </table>
        {{--------------------------------}}
    </div>
</div>

