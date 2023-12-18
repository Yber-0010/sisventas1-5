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
                {!!Form::open(array('url'=>'almacen/categoria','method'=>'POST','autocomplete'=>'off'))!!}
                {{Form::token()}}
                <div class="form-group">
                <label for="nombre">Nombre categoria</label>
                <input type="text" name="nombre" class="form-control" placeholder="Nombre..." required>
                </div>
                <div class="form-group">
                <label for="descripcion">Descripcion</label>
                <input type="text" name="descripcion" id="" class="form-control" placeholder="Descripcion...">
                </div>
                <div class="form-group">
                <button class="btn btn-primary" type="submit" id="count_click_categoria" name="count_click_categoria">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
                <!--paso de ruta al controlador-->    
                <div>
                    <input type="hidden" id="ruta" name="ruta"value="{!!Request::path();!!}">
                </div>
                <!----> 
                {!!Form::close()!!}
           </div>
           <button id="habilitar_categoria" class="btn btn-secondary">

                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
                <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
                <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
                </svg>
            
            </button>
       </div>
    </div>
</div>
@push('scripts')
<script>
$(document).ready(function(){
    $("#count_click_categoria").click(function()
    {
        count_click_add_categoria();
    });
    $("#habilitar_categoria").click(function()
    {
        habilitar_categoria();
        count_click = 0;
    });
});

var count_click = 0;

function deshabilitar_categoria(){
    document.getElementById('count_click_categoria').disabled=true;
}
function habilitar_categoria(){
    document.getElementById('count_click_categoria').disabled=false;
}
function count_click_add_categoria(){
   count_click += 1;
   console.log(count_click);
   if(count_click==2){
     deshabilitar_categoria();
   }
}
</script>
@endpush