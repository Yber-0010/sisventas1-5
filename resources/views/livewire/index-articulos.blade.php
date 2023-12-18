<div>
    {{-- buscador --}}
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <h3>Busqueda rapida de Articulos {{-- <a href="articulo/create"><button class="btn btn-success">Nuevo</button></a> --}}</h3>
            <div class="form group">
                <div class="input group">
                    <table class="responsive" style="margin-bottom: 10px">
                        <tr>
                            <td  style="width: 800px;">
                                <input style="border:#bbbbbb solid 2px" id="ptext" type="text" class="form-control" name="searchText" placeholder="Buscar..." value="{{$searchText}}" wire:model='searchText'>
                            </td>
                            {{-- <td>
                                <samp class="input-group-btn">
                                        <button style="margin-left: 5px" id="psearch" type="submit" class="btn btn-primary">Buscar</button>
                                </samp>
                            </td> --}}
                            <td>
                                <div style="border: cornflowerblue 2px solid; width: 100px; padding:7px; margin-left:4px;" class="radio">
                                    <label for="activos">
                                        @if ($estado == '1')
                                                <input  type="radio" id="estado" name="estado" value="1" checked wire:click="selecEstado('1')">          
                                        @else
                                                <input  type="radio" id="estado" name="estado" value="1" wire:click="selecEstado('1')">
                                        @endif
                                    Activos
                                    </label>
                                    <label for="inactivos">
                                        @if ($estado == '2')
                                                <input  type="radio" id="estado2" name="estado" value="2" checked wire:click="selecEstado('2')">          
                                        @else
                                                <input  type="radio" id="estado2" name="estado" value="2" wire:click="selecEstado('2')">
                                        @endif
                                    inactivos
                                    </label>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            
        </div> 
    </div>
    {{-- tabla --}}
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            
            {{--  --}}
            <div class="row">
                <div class="col-lg-9 col-sm-12 col-md-12 col-xs-12">
                    <label for="Ventas">Ventas</label>
                    <div class="panel panel-primary">
                        <div class="table-responsive">
                            {{--BOTONES SUMAS DE VENTAS--}}
                            @foreach ($articulos as $art)
                            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                                <div class="form-group">
                                    
                                    <table class="table">
                                        <tr>
                                            <td>
                                                <img src="{{asset('imagenes/articulos/'.$art->imagen)}}" alt="{{ $art->nombre}}" height="200px" width="200px" class="img-thumbnail" loading="lazy">
                                            </td>
                                            <td>
                                                <h2><strong>{{ $art->nombre}}</strong></h2>
                                                <h3>{{ $art->peso}}</h3>
                                                <h3>{{ $art->categoria}}</h3>
                                                <h3><strong>{{ $art->precio_venta}} Bs </strong></h3>
                                                <h4>disponible: <strong>{{ $art->stock}}</strong> id: {{ $art->idarticulo}}</h4>
                                                <h4>proveedor: {{ $art->empresa}}</h4>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            @endforeach
                            
                        </div>
                    </div>
                </div>
            </div>
            
            {!! $articulos->appends(["searchText"=>$query ?? $nombre,'estado'=>$estado]) !!}
        </div>
    </div>
</div>
