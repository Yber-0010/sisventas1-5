<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Articulos</title>
    <!--vista para descargar excel articulos-->
</head>
<body>
    <table>
        <thead>
            <tr>
                <th><strong>ID</strong></th>
                <th><strong>Nombre</strong></th>
                {{--<th><strong>Categoria</strong></th>--}}
                <th><strong>Stock</strong></th>
                <th><strong>Precio_compra</strong></th>
                <th><strong>Precio_venta</strong></th>
                <th><strong>Estado</strong></th>
                
            </tr>
        </thead>
        <tbody>
            @foreach ($articulos as $art)
            <tr>
                <td>{{ $art->idarticulo}}</td>
                <td>{{ $art->nombre}}</td>
                {{--<td>{{ $art->categoria}}</td>--}}
                <td>{{ $art->stock}}</td>    
                <td>{{ $art->precio_compra}}</td>    
                <td>{{ $art->precio_venta}}</td>    
                <td>{{ $art->estado}}</td>    
                
            </tr>    
            @endforeach
        </tbody>
    </table>
</body>>
</html>