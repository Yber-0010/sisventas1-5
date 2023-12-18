@extends ('layouts.admin')
@section ('contenido')
          <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3>Nuevo Articulo</h3>
                @if (count ($errors)>0)
                <div class="alert alert-danger">
                   <ul>
                        @foreach ($errors->all() as $error)
                               <li>{{$error}}</li>
                        @endforeach
                   </ul>
                </div>
                @endif
            </div>
          </div>   
                {!!Form::open(array('url'=>'almacen/articulo','method'=>'POST','autocomplete'=>'off', 'files'=>'true'))!!}
                {{Form::token()}}
          <div class="row">
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="nombre">Nombre</label>
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
             
             
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
               <div class="form-group">
                 <label for="stock">Stock</label>
                 <input readonly="readonly" id="pstock" type="number" required name="stock" value="{{old('stock')}}" class="form-control" placeholder="stock del articulo..." min="0">
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
               <div class="form-group">
                 <label for="stock">P. Compra</label>
                 <input readonly="readonly" id="pprecio_compra" type="number" required name="precio_compra" value="{{old('precio_compra')}}" class="form-control" placeholder="precio_compra..." min="0" step=".01">
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
               <div class="form-group">
                 <label for="stock">P. Venta</label>
                 <input readonly="readonly" id="pprecio_venta" type="number" required name="precio_venta" value="{{old('precio_venta')}}" class="form-control" placeholder="precio_venta..." min="0" step=".01">
               </div>
            </div>
            
            
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="descripcion">Descripcion</label>
                  <textarea rows="10" cols="40" name="descripcion" class="form-control" placeholder="descripcion del articulo..."></textarea>
                </div>
             </div>
             <!-- INGRESO PARA PESO-->
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
               <div class="form-group">
                 <label for="peso">Peso</label>
                 <input type="text" name="peso" class="form-control" required value="{{old('peso')}}">
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
               <div class="form-group">
                 <label for="stock_min">Stock minimo</label>
                 <input type="number" name="stock_min" id="stock_min" class="form-control" required value="{{old('stock_min')}}" min="0" step="1" required>
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
               <div class="form-group">
                 <label for="stock_max">Stock Maximo</label>
                 <input type="number" name="stock_max" id="stock_max" class="form-control" required value="{{old('stock_max')}}" min="0" step="1" required>
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
               <div class="form-group">
                 <label for="alerta_dias">Alerta dias</label>
                  <input type="number" name="alerta_dias" id="alerta_dias" class="form-control" required value="{{old('alerta_dias')}}" min="0" step="1" required>
               </div>
            </div>
            <!-- INGRESO PARA EMPRESA-->
            {{-- lista de proveedores --}}
            <div class="col-lg-6 col-sm-4col-md-4 col-xs-12">
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
                  <input type="file" name="imagen" class="form-control" required>
                </div>
             </div>
             
             
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group" style="margin-top: 25px">

                  <a href="" data-target="#modal_guardar" data-toggle="modal">
                     <button class="btn btn-primary" >Guardar</button>
                  </a>
                  <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
             </div>
             
             @include('almacen.articulo.modal_guardar')
          </div>
                {!!Form::close()!!}
<button id="habilitar" class="btn btn-secondary">
   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
   <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
   <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
   </svg>
</button>

@push ('scripts')
<script>

   $(document).ready(function(){
      agregar();
   });
   function agregar(){
      val=0;
      $("#pstock").val(val);
      $("#pprecio_compra").val(val);
      $("#pprecio_venta").val(val);
   }
</script>
@endpush
@endsection

