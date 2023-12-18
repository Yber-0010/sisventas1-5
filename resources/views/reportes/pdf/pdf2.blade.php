<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Articulos</title>
    <style>
        .table{
            width: 100%;
            border: 1 px solid #999999;
        }
    </style>
</head>
<body>
    <table class="table">
        <thead>
            <tr>
                <th>nombre</th>
                <th>stock</th>
                <th>p_compra</th>
                <th>p_venta</th>
                <th>estado</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($articulo as $art)
            <tr>
                <td>{{ $art->nombre}}</td>    
                <td>{{ $art->stock}}</td>    
                <td>{{ $art->precio_compra}}</td>    
                <td>{{ $art->precio_venta}}</td>    
                <td>{{ $art->estado}}</td>    
            </tr>    
            @endforeach
        </tbody>
    </table>
</body>
</html>