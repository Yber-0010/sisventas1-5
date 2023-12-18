<div>
    
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

    <div class="col-lg-8 col-sm-8 col-md-8 col-xs-12">
        <div class="form-group">
            <label for="proveedor">Proveedor</label>
            <input type="list" list="proveedor" id="name_proveedor" name="name_proveedor" class="form-control" wire:model.defer="proveedor" selected required>
            <datalist id=proveedor>
                @foreach($personas as $persona)
                <option  value="{{$persona->nombre}}"></option>
                @endforeach
            </datalist>
        </div>
    </div>
    <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
        <button type="button" class="btn btn-primary" style="margin-top: 25px;" wire:click="buscar()">buscar</button>
    </div>
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="panel panel-primary">
            <div class="table-responsive">
                <div id="taula">
                <table class="table table-striped table-bordered table-condensed table-hover" style="width: 100%;">
                    <thead>
                        <th>ID</th>
                        <th>Peso</th>
                        <th>Nombre</th>
                        <th>Stock</th>
                        <th>P.C/P.V</th>
                        {{-- <th>Precio Venta</th> --}}
                        <th>Imagen</th>
                        <th>Estado</th>
                    </thead>
                     @foreach ($articulos as $art)
                    <tr>
                        <td>{{ $art->idarticulo}}</td>
                        <td>{{ $art->peso}}</td>
                        <td>{{ $art->nombre}}</td>
                        <td><h3>{{ $art->stock}}</h3></td>
                        <td>P.c:{{ $art->precio_compra}}<br>
                            <br>
                            P.v:{{ $art->precio_venta}}
                        </td>
                        <td>
                            <img src="{{asset('imagenes/articulos/'.$art->imagen)}}" alt="{{ $art->nombre}}" height="100px" width="100px" class="img-thumbnail" loading="lazy">
                        </td>                
                        <td>{{ $art->estado}}</td>
                    </tr>
                    @endforeach  
                </table>
                </div>
            </div>
        </div>
    </div>
</div>
