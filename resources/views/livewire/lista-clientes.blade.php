<div>
    <div class="form-group">
        <label for="nombre">Nuevo cliente</label>
        <input type="list" list="cliente" class="form-control" wire:model='pro'>
        <datalist id="cliente">
            @foreach($personas as $persona)
            <option  value="{{$persona->nombre}} : {{$persona->telefono}}"></option>
            @endforeach
        </datalist>
    </div>

    <div id="select-oculto">
        <input type="hidden" name="idcliente" id="idcliente" class="form-control" value="{{$pro2}}">    
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
