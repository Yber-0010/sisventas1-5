<div>
    <div class="form-group">
        <label for="nombre">Proveedor</label>
        <input type="list" list="proveedor" class="form-control" wire:model='pro' selected required>
        <datalist id=proveedor>
            @foreach($personas as $persona)
            <option  value="{{$persona->nombre}} : {{$persona->telefono}}"></option>
            @endforeach
        </datalist>
    </div>

    <div id="select-oculto">
        <input type="hidden" name="idproveedor" id="idproveedor" class="form-control" value="{{$pro2}}">    
    </div>
      @push('scripts')
        <script>
        $(document).ready(function(){
          $("#select-oculto").hide();
            /* $("#nuevo_articulo").click(function()
            {
                $(".selectpicker").selectpicker('refresh');
            }); */
            
        });
        </script>
        @endpush
</div>
