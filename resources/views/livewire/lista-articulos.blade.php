<div id="pidarticulo4" name="pidarticulo4">
  <div class="form-group">
    <label>Articulo</label>
    <input type="text" list="petss" name="pidarticulo2" id="pidarticulo2" class="form-control" wire:model='art' selected>
    <datalist id="petss">
      @foreach($articulos as $articulo)
      <option id="gets" value="+{{$articulo->idarticulo}}+ {{$articulo->articulo}} {{$articulo->peso}} {{$articulo->empresa}}"></option>
      @endforeach
    </datalist>
    <button  id="limpiar-lista" type="button" class="btn btn-warning" style="margin: 5px 50px 0px 0px;">x</button>
    <div id="select-oculto">
    <input type="hidden" name="pidarticulo" id="pidarticulo" class="form-control" {{-- wire:model='art2' --}} value="{{$art2}}">
      <select name="pidarticulo3" id="pidarticulo3" class="form-control" selected readonly="raedonly"  style="visibility:hidden">
        <option value="#">{{$art3}}</option>
      </select>
    </div>
    
  </div>
  @push('scripts')
    <script>
    $(document).ready(function(){
      $("#select-oculto").hide();
      //$("#pidarticulo2").change(mostrarValores);
        /* $("#nuevo_articulo").click(function()
        {
            $(".selectpicker").selectpicker('refresh');
        }); */
        /* $("#pidarticulo2").on("change keyup paste click", function(){
          mostrarValores();
        }) */
        /* $("#pidarticulo2").on("input", null, null, mostrarValores); */
        /* $("input[name='pidarticulo2']").on("propertychange change click keyup input paste blur", function(){
          mostrarValores();
        }); */
        $("input[name='pidarticulo2']").on("propertychange change click keyup input paste blur", function(){
          mostrarValores();
          agregar_p_venta_es();
        });
        /* $("#pidarticulo4").mouseover(function()
        {
              agregar_p_venta_es();
        }); */
        $("#limpiar-lista").click(function()
        {
          $('#pidarticulo2').val("");   
        });
        
    });
    
    </script>
    @endpush
</div>