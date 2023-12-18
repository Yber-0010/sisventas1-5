<div>
    <div class="input-group-btn">
        <a href="" data-target="#modal_articulo" data-toggle="modal">
            <button id="nuevo_articulo" style="margin-left: 10px;" class="btn btn-success" wire:loading.attr="disabled" class="disabled opacity-25" wire:target="save, imagen">Nuevo Articulo</button>
        </a>
    </div>
    {{-- <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
        <span wire:loading wire:target="save">cargando ...</span>
    </div> --}}
      {{-- modal articulo --}}
    <div class="modal fade modal-slide-in-rigth" aria-hidden="true" role="dialog" tabindex="-1" id="modal_articulo">
        <div class="modal-dialog">
           <div class="modal-content" style="background: rgb(227, 227, 255)">
    
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-Label="Close">
                    <span aria-hidden="true">x</span>
                    </button>
                    <h4 class="modal-title">Nuevo Articulo</h4>
                </div>
    
                <div class="modal-body">
                    {{-- {!!Form::open(array('url'=>'almacen/articulo','method'=>'POST','autocomplete'=>'off', 'files'=>'true'))!!}
                    {{Form::token()}} --}}
                    <div class="row">
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <label for="nombre">Nombre articulo</label>
                            <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre..." wire:model.defer="nombre" required>
                            @error('nombre')
                            <div class="alert alert-warning" role="alert">
                                {{$message}}
                            </div>
                            @enderror
                            </div>
                        </div>                   
                        
                        {{--  --}}
                        {{-- lista de proveedores --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="categoria">Categoria</label>
                                <select name="idcategoria" class="form-control selectpicker" data-live-search="true" wire:model.defer="idcategoria" required>
                                    <option value=""></option>
                                    @foreach ($categorias as $cat)
                                        <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                                    @endforeach
                                </select>
                                @error('idcategoria')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{--  --}}
                        {{--  --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <label for="codigo">Codigo</label>
                            <input type="text" name="codigo" required value="{{old('codigo')}}" class="form-control" placeholder="Codigo del articulo..." wire:model.defer="codigo">
                            @error('codigo')
                            <div class="alert alert-warning" role="alert">
                                {{$message}}
                            </div>
                            @enderror
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="stock">Stock</label>
                            <input readonly="readonly" id="ppstock" type="number" required name="stock" value="{{old('stock')}}" class="form-control" placeholder="stock del articulo..." min="0" wire:model.defer="stock">
                            @error('stock')
                            <div class="alert alert-warning" role="alert">
                                {{$message}}
                            </div>
                            @enderror
                        </div>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="stock">P. Compra</label>
                            <input readonly="readonly" id="ppprecio_compra" type="number" required name="precio_compra" value="{{old('precio_compra')}}" class="form-control" placeholder="precio_compra..." min="0" step=".01" wire:model.defer="precio_compra">
                        </div>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                        <div class="form-group">
                            <label for="stock">P. Venta</label>
                            <input readonly="readonly" id="ppprecio_venta" type="number" required name="precio_venta" value="{{old('precio_venta')}}" class="form-control" placeholder="precio_venta..." min="0" step=".01" wire:model.defer="precio_venta">
                        </div>
                        </div>
                        
                        
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" name="descripcion" value="{{old('descripcion')}}" class="form-control" placeholder="descripcion del articulo..." wire:model.defer="descripcion">
                            @error('descripcion')
                            <div class="alert alert-warning" role="alert">
                                {{$message}}
                            </div>
                            @enderror
                            </div>
                        </div>
                        <!-- INGRESO PARA PESO-->
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                            <div class="form-group">
                                <label for="peso">Peso</label>
                                <input type="text" name="peso" class="form-control" wire:model.defer="peso">
                                @error('peso')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                            <div class="form-group">
                                <label for="stock_min">Stock minimo</label>
                                <input type="number" name="stock_min" class="form-control" wire:model.defer="stock_min" min="0" required>
                                @error('stock_min')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                            <div class="form-group">
                                <label for="stock_max">Stock Maximo</label>
                                <input type="number" name="stock_max" class="form-control" wire:model.defer="stock_max" min="0" required>
                                @error('stock_max')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <!-- INGRESO PARA EMPRESA-->
                        {{-- lista de proveedores --}}
                        <div class="col-lg-4 col-sm-4col-md-4 col-xs-12">
                            <div class="form-group">
                            <label for="Cliente">Proveedor</label>
                                <select name="empresa" class="form-control selectpicker" data-live-search="true" wire:model.defer="empresa" required>
                                    <option></option>
                                    @foreach($personas as $persona)
                                    <option value="{{$persona->nombre}}">{{$persona->nombre}} : {{$persona->telefono}} </option>        
                                    @endforeach
                                </select>
                                @error('empresa')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{--  --}}
                        
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <label for="imagen">Imagen</label>
                            <input type="file" name="imagen" class="form-control" wire:model='imagen' id="{{$identificador}}">
                            @error('imagen')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                            @enderror
                            </div>
                        </div>

                        @if ($imagen)
                        <div class="col-lg-12 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                              <img src="{{$imagen->temporaryUrl()}}" width="300px" heigth="300px">  
                            </div>
                         </div>
                        @endif
                        
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group" style="margin-top: 25px">
                                <button class="btn btn-primary" id="count_click_articulo" name="count_click_articulo" wire:click="save" data-dismiss="modal" aria-Label="Close" wire:loading.remove wire:target="save">
                                    <span aria-hidden="true">Guardar</span>
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
    
    @push('scripts')
    <script>
    $(document).ready(function(){

        $("#nuevo_articulo").click(function()
        {
            $(".selectpicker").selectpicker('refresh');
        });
        $("#count_click_articulo").click(function()
        {
            $("#modal_articulo").modal("hide");
        });
        
    });
    Livewire.on('show',function(){
        
        //$("#modal_articulo").modal("show"); 
        $(document).ready(function(){
            $("#modal_articulo").modal("hide");
            //$("#modal_articulo").modal("show"); 
            //$("#nuevo_articulo").trigger("click");
        });
    })
    </script>
    @endpush
</div>
