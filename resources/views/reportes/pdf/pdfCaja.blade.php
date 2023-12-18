<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <style>
        .table{
            width: 100%;
            border: 1 px solid #999999;
        }
        .cabeza{
            text-align: center;
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
            background: #999999;
        }
    </style>
</head>
<body>
    
    <table>
        @foreach ($negocio as $n)
        <tr>
            <td>{{$n->nombre_negocio}}</td>
            <td rowspan="4">
                <img src="../public/imagenes/articulos/{{$n->imagen_negocio}}" alt="{{ $n->nombre_negocio}}" height="150px" width="150px" style="margin-left: 330px">
            </td>
        </tr>
        <tr>
            <td>{{$n->direccion_negocio}}</td>
        </tr>
        <tr>
            <td>{{$n->telefono_negocio}}</td>
        </tr>
        <tr>
            <td>De: {{$fecha_desde}} asta {{$fecha_asta}}</td>
        </tr>
        @endforeach
    </table>
    <H1 style="text-align: center">
        informe de ventas e ingresos
    </H1>
    <table class="table">
        <thead>
            <tr>
            <th colspan="2" class="cabeza">Ventas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>total efectivo</th>
                <td>{{$efectivo_venta}}</td>
            </tr>
            <tr>
                <th>nota de venta</th>
                <td>{{$nota_venta}}</td>
            </tr>
            <tr>
                <th>con tarjeta</th>
                <td>{{$con_tarjeta}}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>{{$total_ingresos}}</td>
            </tr>
        </tbody>
    </table>
    <table class="table">
        <thead>
            <tr>
               <th colspan="2" class="cabeza">Ingresos</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <th>total factura</th>
                <td>{{$factura_ingreso}}</td>
            </tr>
            <tr>
                <th>nota de ingreso</th>
                <td>{{$nota_ingreso}}</td>
            </tr>
            <tr>
                <th>tarjeta</th>
                <td>{{$tarjeta_ingreso}}</td>
            </tr>
            <tr>
                <th>total</th>
                <td>{{$total_egresos}}</td>
            </tr>
        </tbody>
    </table>
    <br>
    <table>
        <tr>
            <td>
                <pre>
                    
Este es un informe elaborado
para el seguimiento del total
de ventas e ingresos
                </pre>
            </td>
        </tr>
        <tr>
            <td>
                <pre>
          El informe está sujeto a los montos registrados en el sistema,
          por lo que si hay variaciones es por los registros  en el mismo.  
                </pre>
            </td>
        </tr>
    </table>
</body>
</html>