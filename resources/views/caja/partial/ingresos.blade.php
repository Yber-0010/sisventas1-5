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
                <th>Proveedor</th>
                <th>Comprobante</th>
                <th>Impuesto</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Opciones</th>
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
                <td>
                    <a href="{{URL::action('IngresoController@show',$ing->idingreso)}}"><button class="btn btn-primary">Detalles</button></a>
                    <a href="" data-target="#modal-delete-{{$ing->idingreso}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
                </td>
            </tr>
            @include('compras.ingreso.modal')
            @endforeach  
        </table>
    </div>
    {{-----------------------}}
</div>