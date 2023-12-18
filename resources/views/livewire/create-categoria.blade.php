<div>
    <div class="form-group">
        <a href="" data-target="#modal_categoria" data-toggle="modal">
          <button class="btn btn-success" wire:loading.attr="disabled" class="disabled opacity-25" wire:target="save, nombre">Nuevo Categoria</button>
        </a>
    </div>
    {{-- modal create categoria --}}
    <div class="modal fade modal-slide-in-rigth" aria-hidden="true" role="dialog" tabindex="-1" id="modal_categoria">
        <div class="modal-dialog">
           <div class="modal-content" style="background: rgb(227, 227, 255)">
    
               <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-Label="Close">
                  <span aria-hidden="true">x</span>
                  </button>
                  <h4 class="modal-title">Nuevo categoria</h4>
               </div>
    
               <div class="modal-body">
                    {{-- form --}}
                    <div class="form-group">
                    <label for="nombre">Nombre categoria</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Nombre..." value="{{old('nombre')}}" wire:model.defer="nombre" required>
                    @error('nombre')
                            <div class="alert alert-warning" role="alert">
                                {{$message}}
                            </div>
                    @enderror
                    </div>
                    <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <input type="text" name="descripcion" id="" class="form-control" placeholder="Descripcion..." value="{{old('descripcion')}}" wire:model.defer="descripcion">
                    @error('descripcion')
                            <div class="alert alert-warning" role="alert">
                                {{$message}}
                            </div>
                    @enderror
                    </div>
                    <div class="form-group">
                    <button class="btn btn-primary" type="submit" id="count_click_categoria" name="count_click_categoria" wire:click="save" data-dismiss="modal" aria-Label="Close" wire:loading.remove wire:target="save">
                        <span aria-hidden="true">Guardar</span>
                    </button>
                    <button class="btn btn-danger" type="reset" data-dismiss="modal" aria-Label="Close">
                        <span aria-hidden="true">Cancelar</span>
                    </button>
                    </div>
                    <!--paso de ruta al controlador-->    
                    {{-- <div>
                        <input type="hidden" id="ruta" name="ruta"value="{!!Request::path();!!}">
                    </div> --}}
                    <!----> 
                    {{-- form --}}
               </div>
               
           </div>
        </div>
    </div>
    
</div>