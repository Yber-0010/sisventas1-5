<div>
    <a class="btn btn-info" data-target="#modal_articulo1" data-toggle="modal">
        <i class="fa fa-edit"></i>
        {{-- <button class="btn btn-info">Editar</button> --}}
    </a>

    {{-- modal editar articulo --}}
    <div class="modal fade modal-slide-in-rigth" aria-hidden="true" role="dialog" tabindex="-1" id="modal_articulo1">
        <div class="modal-dialog">
           <div class="modal-content" style="background: rgb(227, 227, 255)">
                {{-- header modal --}}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-Label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                    <h4 class="modal-title">Editar Articulo {{$articulo->nombre}}</h4>
                </div>
                {{-- body nodal --}}
                <div class="modal-body">   
                    <div class="row">
                        {{-- nombre articulo --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <label for="nombre">Nombre articulo</label>
                            <input type="text" name="nombre" value="{{old('nombre')}}" class="form-control" placeholder="Nombre..." required>
                            </div>
                        </div>
                        {{-- lista de proveedores --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <label for="">Categoria</label>
                                <select name="idcategoria" id="" class="form-control">
                                @foreach ($categorias as $cat)
                                    @if($cat->idcategoria==$articulo->idcategoria)
                                    <option value="{{$cat->idcategoria}}" selected>{{$cat->nombre}}</option>
                                    @else
                                    <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                                    @endif
                                @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- codigo --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <label for="codigo">Codigo</label>
                            <input type="text" name="codigo" required value="{{old('codigo')}}" class="form-control" placeholder="Codigo del articulo...">
                            </div>
                        </div>
                        {{-- stock --}}
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input readonly="readonly" id="ppstock" type="number" required name="stock" value="{{old('stock')}}" class="form-control" placeholder="stock del articulo..." min="0">
                            </div>
                        </div>
                        {{-- p compra --}}
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                            <div class="form-group">
                                <label for="stock">P. Compra</label>
                                <input readonly="readonly" id="ppprecio_compra" type="number" required name="precio_compra" value="{{old('precio_compra')}}" class="form-control" placeholder="precio_compra..." min="0" step=".01">
                            </div>
                        </div>
                        {{-- p venta --}}
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                            <div class="form-group">
                                <label for="stock">P. Venta</label>
                                <input readonly="readonly" id="ppprecio_venta" type="number" required name="precio_venta" value="{{old('precio_venta')}}" class="form-control" placeholder="precio_venta..." min="0" step=".01">
                            </div>
                        </div>
                        {{-- descricion --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="descripcion">Descripcion</label>
                                <input type="text" name="descripcion" value="{{old('descripcion')}}" class="form-control" placeholder="descripcion del articulo...">
                            </div>
                        </div>
                        {{-- peso --}}
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                            <div class="form-group">
                                <label for="peso">Peso</label>
                                <input type="text" name="peso" class="form-control">
                            </div>
                        </div>
                        {{-- lista de proveedores --}}
                        <div class="col-lg-4 col-sm-4col-md-4 col-xs-12">
                            <div class="form-group">
                            <label for="Cliente">Proveedor</label>
                                <select name="empresa" class="form-control selectpicker" data-live-search="true" required>
                                    <option></option>
                                    @foreach($personas as $persona)
                                    <option value="{{$persona->nombre}}">{{$persona->nombre}} : {{$persona->telefono}} </option>        
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- imagen --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="imagen">Imagen</label>
                                <input type="file" name="imagen" class="form-control">
                            </div>
                        </div>

                        {{-- @if ($imagen)
                        <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                              <img src="{{$imagen->temporaryUrl()}}" width="300px" heigth="300px">  
                            </div>
                         </div>
                        @endif --}}
                        {{-- botones guardar cerrar --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group" style="margin-top: 25px">
                                <button class="btn btn-primary" id="count_click_articulo" name="count_click_articulo" data-dismiss="modal" aria-Label="Close">
                                    <span aria-hidden="false">Guardar</span>
                                </button>
                                <button class="btn btn-danger" type="button" data-dismiss="modal" aria-Label="Close">
                                    <span aria-hidden="true">Cancelar</span>
                                </button>
                            </div>
                        </div>

                    </div>        
                </div>
           </div>
        </div>
    </div>

</div>
