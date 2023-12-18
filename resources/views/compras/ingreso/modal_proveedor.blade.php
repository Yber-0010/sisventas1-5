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
                {!!Form::open(array('url'=>'compras/proveedor','method'=>'POST','autocomplete'=>'off'))!!}
                {{Form::token()}}
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <label for="nombre">Nombre proveedor</label>
                        <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <label for="nombre">Direccion</label>
                        <input type="text" name="direccion" value="{{old('direccion')}}" class="form-control" placeholder="Direccion...">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                    <label for="">Documento</label>
                    <select name="tipo_documento" id="" class="form-control">
                            <option value="CI">CI</option>
                            <option value="NIT">NIT</option>
                            <option value="Sin Documento">Sin Documento</option>
                    </select>
                    </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <label for="num_documento">Numero documento</label>
                        <input type="text" name="num_documento" value="{{old('num_documento')}}" class="form-control" placeholder="Numero Documento...">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <label for="stock">Telefono</label>
                        <input type="text" name="telefono" required value="{{old('telefono')}}" class="form-control" placeholder="Telefono...">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <label for="descripcion">Email</label>
                        <input type="text" name="email" value="{{old('email')}}" class="form-control" placeholder="Email...">
                        </div>
                    </div>
                
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <button class="btn btn-primary" type="submit" id="count_click_proveedor" name="count_click_proveedor">Guardar</button>
                        <button class="btn btn-danger" type="reset">Cancelar</button>
                        </div>
                    </div>
                </div>
                <!--paso de ruta al controlador-->    
                <div>
                    <input type="hidden" id="ruta" name="ruta"value="{!!Request::path();!!}">
                </div>
                <!----> 
                {!!Form::close()!!}
           </div>

           <button id="habilitar_proveedor" class="btn btn-secondary">

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
    $("#count_click_proveedor").click(function()
    {
        count_click_add_proveedor();
    });
    $("#habilitar_proveedor").click(function()
    {
        habilitar_proveedor();
        count_click = 0;
    });
});

var count_click = 0;

function deshabilitar_proveedor(){
    document.getElementById('count_click_proveedor').disabled=true;
}
function habilitar_proveedor(){
    document.getElementById('count_click_proveedor').disabled=false;
}
function count_click_add_proveedor(){
   count_click += 1;
   console.log(count_click);
   if(count_click==2){
     deshabilitar_proveedor();
   }
}
</script>
@endpush