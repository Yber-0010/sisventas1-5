<div>
    <div class="form-group">
        <a href="" data-target="#modal_proveedor" data-toggle="modal">
          <button class="btn btn-success" wire:loading.attr="disabled" class="disabled opacity-25" wire:target="save, nombre">Nuevo Proveedor</button>
        </a>
    </div>
    {{-- modal crear proveedor --}}
    <div class="modal fade modal-slide-in-rigth" aria-hidden="true" role="dialog" tabindex="-1" id="modal_proveedor">
        <div class="modal-dialog">
           <div class="modal-content" style="background: rgb(227, 227, 255)">
    
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-Label="Close">
                  <span aria-hidden="true">x</span>
                  </button>
                  <h4 class="modal-title">Nuevo Proveedor</h4>
               </div>
    
               <div class="modal-body">
                    {{-- form --}}
                    <div class="row">
                        {{-- nombre proveedor --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="nombre">Nombre proveedor</label>
                                <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre..." wire:model.defer="nombre">
                                @error('nombre')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{-- direccion --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="nombre">Direccion</label>
                                <input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Direccion..." wire:model.defer="direccion">
                                @error('direccion')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{-- documento --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <label for="">Documento</label>
                            <select name="tipo_documento" id="" class="form-control" wire:model.defer="tipo_documento">
                                    <option value="CI">CI</option>
                                    <option value="NIT">NIT</option>
                                    <option value="Sin Documento">Sin Documento</option>
                            </select>
                            @error('tipo_documento')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                            @enderror
                            </div>
                        </div>
                        {{-- numero documento --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="num_documento">Numero documento</label>
                                <input type="text" name="num_documento" value="{{old('num_documento')}}" class="form-control" placeholder="Numero Documento..." wire:model.defer="num_documento">
                                @error('num_documento')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{-- telefono --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                                <label for="stock">Telefono</label>
                                <input type="text" name="telefono" required value="{{old('telefono')}}" class="form-control" placeholder="Telefono..." wire:model.defer="telefono">
                                @error('telefono')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                                @enderror
                            </div>
                        </div>
                        {{-- email --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <label for="descripcion">Email</label>
                            <input type="text" name="email" value="{{old('email')}}" class="form-control" placeholder="Email..." wire:model.defer="email">
                            @error('email')
                                <div class="alert alert-warning" role="alert">
                                    {{$message}}
                                </div>
                            @enderror
                            </div>
                        </div>
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                              <label for="descripcion">Tiene cambio</label>
                              <br>
                              NO<input type="radio" name="tiene_cambio" value="0" checked wire:model.defer="tiene_cambio"/>
                              SI<input type="radio" name="tiene_cambio" value="1" wire:model.defer="tiene_cambio"/>
                            </div>
                          </div>
                          <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                              <label for="detalles">Detalles</label>
                              <textarea type="textarea" name="detalles" value="{{old('detalles')}}" class="form-control" placeholder="Detalles..." wire:model.defer="detalles"></textarea>
                            </div>
                         </div>
                        {{-- botones --}}
                        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                            <div class="form-group">
                            <button class="btn btn-primary" type="submit" id="count_click_proveedor" name="count_click_proveedor" wire:click="save" data-dismiss="modal" aria-Label="Close" wire:loading.remove wire:target="save">
                                <span aria-hidden="true">Guardar</span>
                            </button>
                            <button class="btn btn-danger" type="reset" data-dismiss="modal" aria-Label="Close">
                                <span aria-hidden="true">Cancelar</span>
                            </button>
                            </div>
                        </div>
                    </div>
                    {{-- form --}}
               </div>
                  
            </div>
        </div>
    </div>
</div>
