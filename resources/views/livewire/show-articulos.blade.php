{{-- div padre unico --}}
<div>
    {{--  --}}
    <div class="row">
        <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
             <h3>Listado de Articulos</h3>
            {{-- search --}}
            <div class="form group">
                <div class="input group">
                  <table class="responsive" style="margin-bottom: 10px">
                        <tr>
                              <td  style="width: 800px;"><input style="border:#bbbbbb solid 2px" id="ptext" type="text" class="form-control" name="searchText" placeholder="Buscar..." wire:model='query'>
                              </td>
                              <td>
                                    @livewire('create-articulo')
                              </td>
                              {{-- <td>
                                <div style="border: cornflowerblue 2px solid; width: 100px; padding:7px; margin-left:4px;" class="radio">
                                      <label for="activos">
                                            @if ($estado == '1')
                                                  <input  type="radio" id="estado" name="estado" value="1" checked>          
                                            @else
                                                  <input  type="radio" id="estado" name="estado" value="1">
                                            @endif
                                      Activos</label>
                                      <label for="inactivos">
                                            @if ($estado == '2')
                                                  <input  type="radio" id="estado2" name="estado" value="2" checked>          
                                            @else
                                                  <input  type="radio" id="estado2" name="estado" value="2">
                                            @endif
                                      inactivos </label>
                                </div>
                            </td> --}}
                        </tr>
                  </table>
                </div>
          </div>
            {{--  --}}
        </div> 
    </div>
    {{-- {{$articulos->links()}} --}}
    {{-- --}}
    <div class="row">
      
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
          
          <div class="table-responsive">
            
              <table class="table table-striped table-bordered table-condensed table-hover" style="width: 100%;">
                <thead>
                   <th wire:click="order('idarticulo')"><a href="#">ID</a>
                   {{-- sort --}}
                        @if ($sort == 'idarticulo')
                              @if ($direction == 'asc')  
                                    <i class="fa fa-fw fa-arrow-up pull-right"></i>    
                              @else
                                    <i class="fa fa-fw fa-arrow-down pull-right"></i>  
                              @endif
                        @else
                              <i class="fa fa-fw fa-arrow-down pull-right"></i>
                        @endif
                   </th>
                   <th wire:click="order('nombre')"><a href="#">Nombre</a>
                        {{-- sort --}}
                        @if ($sort == 'nombre')
                              @if ($direction == 'asc')
                                    <i class="fa fa-fw fa-arrow-up pull-right"></i>    
                              @else
                                    <i class="fa fa-fw fa-arrow-down pull-right"></i>    
                              @endif
                        @else
                              <i class="fa fa-fw fa-arrow-down pull-right"></i>    
                        @endif
                   </th>
                   <th>Peso</th>
                   <th>Categoria</th>
                   <th>Proveedor</th>
                   <th>Stock</th>
                   <th>Precio Compra</th>
                   <th>Precio Venta</th>
                   <th>Imagen</th>
                   <th>Estado</th>
                 </thead>
                 @foreach ($articulos as $art)
                 <tr>
                   <td>{{ $art->idarticulo}}</td>
                   <td><h3>{{ $art->nombre}}</h3></td>
                   <td>{{ $art->peso}}</td>
                   <td>{{ $art->categoria}}</td>
                   <td>{{ $art->empresa}}</td>
                   <td><h3>{{ $art->stock}}</h3></td>
                   <td>{{ $art->precio_compra}}</td>
                   <td>{{ $art->precio_venta}}</td>
                   <td>
                   <img src="{{asset('imagenes/articulos/'.$art->imagen)}}" alt="{{ $art->nombre}}" height="100px" width="100px" class="img-thumbnail" loading="lazy">
                   </td>                
                   <td>{{ $art->estado}}</td>
                   <td>
                        {{-- <a href="{{URL::action('ArticuloController@edit',$art->idarticulo)}}">
                              <button class="btn btn-info">Editar</button>
                        </a> --}}
                        @livewire('edit-articulo',['art' => $art], key($art->idarticulo))
                   </td>
                   <td>
                       @if ( $art->estado == "Inactivo" )
                       <a href="" data-target="#modal-delete-{{$art->idarticulo}}" data-toggle="modal"><button style="background: rgb(255, 0, 0)" class="btn btn-danger">Activar</button></a>    
                       @endif
                       @if ( $art->estado == "Activo" )
                       <a href="" data-target="#modal-delete-{{$art->idarticulo}}" data-toggle="modal"><button style="background: rgb(150, 22, 22)" class="btn btn-danger">Inactivar</button></a>
                       @endif
                       <!-- ME QUEDE ACA VIENDO DE COLOCAR MODALES PARA GUARDAR-->
                   </td>
                 </tr>
                 @include('almacen.articulo.modal')
                 
                 @endforeach  
              </table>
              <div>
                    {{$articulos->links()}}
              </div>
          </div>
          
        </div>
    </div>

</div>

{{-- fin div padre unico --}}