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
                {!!Form::open(array('url'=>'almacen/articulo','method'=>'POST','autocomplete'=>'off', 'files'=>'true'))!!}
                {{Form::token()}}
                <div class="row">
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <label for="nombre">Nombre articulo</label>
                        <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
                        </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                    <div class="form-group">
                    <label for="">Categoria</label>
                    <select name="idcategoria" id="" class="form-control">
                        @foreach ($categorias as $cat)
                            <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                        @endforeach
                    </select>
                    </div>
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <label for="codigo">Codigo</label>
                        <input type="text" name="codigo" required value="{{old('codigo')}}" class="form-control" placeholder="Codigo del articulo...">
                        </div>
                    </div>
                    
                    
                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input readonly="readonly" id="ppstock" type="number" required name="stock" value="{{old('stock')}}" class="form-control" placeholder="stock del articulo..." min="0">
                    </div>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="stock">P. Compra</label>
                        <input readonly="readonly" id="ppprecio_compra" type="number" required name="precio_compra" value="{{old('precio_compra')}}" class="form-control" placeholder="precio_compra..." min="0" step=".01">
                    </div>
                    </div>
                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="stock">P. Venta</label>
                        <input readonly="readonly" id="ppprecio_venta" type="number" required name="precio_venta" value="{{old('precio_venta')}}" class="form-control" placeholder="precio_venta..." min="0" step=".01">
                    </div>
                    </div>
                    
                    
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <label for="descripcion">Descripcion</label>
                        <input type="text" name="descripcion" value="{{old('descripcion')}}" class="form-control" placeholder="descripcion del articulo...">
                        </div>
                    </div>
                    <!-- INGRESO PARA PESO-->
                    <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="peso">Peso</label>
                        <input type="text" name="peso" class="form-control">
                    </div>
                    </div>
                    <!-- INGRESO PARA EMPRESA-->
                    {{-- lista de proveedores --}}
                    <div class="col-lg-4 col-sm-4col-md-4 col-xs-12">
                        <div class="form-group">
                        <label for="Cliente">Proveedor</label>
                            <select name="empresa" class="form-control selectpicker" data-live-search="true">
                                @foreach($personas as $persona)
                                <option value="{{$persona->nombre}}">{{$persona->nombre}} : {{$persona->telefono}} </option>        
                                @endforeach
                            </select>
                        </div>
                    </div>
                    {{--  --}}
                    
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group">
                        <label for="imagen">Imagen</label>
                        <input type="file" name="imagen" class="form-control">
                        </div>
                    </div>
                    
                    <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                        <div class="form-group" style="margin-top: 25px">
                            <button class="btn btn-primary" id="count_click_articulo" name="count_click_articulo">Guardar</button>
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
            <button id="habilitar_articulo" class="btn btn-secondary">

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
    $("#count_click_articulo").click(function()
    {
        count_click_add_articulo();
    });
    $("#habilitar_articulo").click(function()
    {
        habilitar_articulo();
        count_click = 0;
    });
});

var count_click = 0;

function deshabilitar_articulo(){
    document.getElementById('count_click_articulo').disabled=true;
}
function habilitar_articulo(){
    document.getElementById('count_click_articulo').disabled=false;
}
function count_click_add_articulo(){
   count_click += 1;
   console.log(count_click);
   if(count_click==2){
     deshabilitar_articulo();
   }
}
</script>
@endpush