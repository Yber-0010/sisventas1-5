@extends ('layouts.admin')
@section ('contenido')
         <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
 
                <h3>Editar Articulo: {{$articulo->nombre}}</h3>
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
                {!!Form::model($articulo,['method'=>'PATCH','route'=>['articulo.update',$articulo->idarticulo],'files'=>true])!!}
                {{Form::token()}}
<!--paso de ruta al controlador-->    
<div>
<input type="hidden" id="ruta" name="ruta"value="{!!URL::previous()!!}">
</div>
   <!---->
          <div class="row">
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" name="nombre" required value="{{$articulo->nombre}}" class="form-control">
                </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
               <div class="form-group">
               <label for="">Categoria</label>
               <select name="idcategoria" id="" class="form-control">
                  @foreach ($categorias as $cat)
                     @if($cat->idcategoria==$articulo->idcategoria)
                     <option value="{{$cat->idcategoria}}" selected>{{$cat->nombre}}</option>
                     @else
                     <option value="{{$cat->idcategoria}}">{{$cat->nombre}}</option>
                     @endif
                  @endforeach
               </select>
               </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="codigo">Codigo</label>
                  <input type="text" name="codigo" required value="{{$articulo->codigo}}" class="form-control">
                </div>
             </div>
         @can('isAdmin')
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
                <div class="form-group">
                  <label for="stock">Stock</label>
                  <input id="pstock" type="number" name="stock" required value="{{$articulo->stock}}" class="form-control" min="0">
                </div>
             </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
               <div class="form-group">
                 <label for="stock">P. Compra</label>
                 <input  id="pprecio_compra" type="number" required name="precio_compra" value="{{$articulo->precio_compra}}" class="form-control" min="0" step=".01">
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
               <div class="form-group">
                 <label for="stock">P. Venta</label>
                 <input  id="pprecio_venta" type="number" required name="precio_venta" value="{{$articulo->precio_venta}}" class="form-control" min="0" step=".01">
               </div>
            </div>
            <!---->
         @endcan
         @can('isUser')
         
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
                <div class="form-group">
                  <label for="stock">Stock</label>
                  <input  id="ppstock" type="number" name="stock" required value="{{$articulo->stock}}" class="form-control" min="0">
                </div>
             </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
               <div class="form-group">
                 <label for="stock">P. Compra</label>
                 <input  id="ppprecio_compra" type="number" required name="precio_compra" value="{{$articulo->precio_compra}}" class="form-control" min="0" step=".01">
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-4">
               <div class="form-group">
                 <label for="stock">P. Venta</label>
                 <input  id="ppprecio_venta" type="number" required name="precio_venta" value="{{$articulo->precio_venta}}" class="form-control" min="0" step=".01">
               </div>
            </div>
         
            <!---->
         @endcan
            

             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="descripcion">Descripcion</label>
                  <textarea rows="10" cols="40" name="descripcion" class="form-control" placeholder="descripcion del articulo...">{{$articulo->descripcion}}</textarea>
                  {{-- <input type="text" name="descripcion" value="{{$articulo->descripcion}}" class="form-control" placeholder="descripcion del articulo..."> --}}
                </div>
             </div>
             <!-- INGRESO PARA PESO-->
             <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
               <div class="form-group">
                 <label for="peso">Peso</label>
                 <input type="text" name="peso" value="{{$articulo->peso}}" class="form-control" required>
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
               <div class="form-group">
                 <label for="stock_min">Stock minimo</label>
                 <input type="number" name="stock_min" id="stock_min" class="form-control" required value="{{$articulo->stock_min}}" min="0" required>
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
               <div class="form-group">
                 <label for="stock_max">Stock Maximo</label>
                 <input type="number" name="stock_max" id="stock_max" class="form-control" required value="{{$articulo->stock_max}}" min="0" required>
               </div>
            </div>
            <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
               <div class="form-group">
                 <label for="alerta_dias">Alerta dias</label>
                  <input type="number" name="alerta_dias" id="alerta_dias" class="form-control" required value="{{$articulo->alerta_dias}}" min="0" step="1" required>
               </div>
            </div>
            <!-- INGRESO PARA EMPRESA-->
            {{-- lista de proveedores --}}
            <div class="col-lg-6 col-sm-4col-md-4 col-xs-12">
               <div class="form-group">
                 <label for="Cliente">Proveedor</label>
                 <select name="empresa" class="form-control selectpicker" data-live-search="true">
                   @foreach($personas as $persona)
                   @if ($articulo->empresa == $persona->nombre)
                     <option value="{{$persona->nombre}}" selected>{{$persona->nombre}} : {{$persona->telefono}} </option>    
                   @else
                     <option value="{{$persona->nombre}}">{{$persona->nombre}} : {{$persona->telefono}} </option>    
                   @endif
                   @endforeach
                 </select>
               </div>
             </div>
            {{--  --}}

             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="imagen">Imagen</label>

                  {{-- <input type="file" name="imagen" class="form-control" value="{{$articulo->imagen}}"> --}}
                  <input type="file" name="imagen" class="form-control-file" id="imagen">
                  @if (($articulo->imagen)!="")
                      <img src="{{asset('imagenes/articulos/'.$articulo->imagen)}}" width="300px" heigth="300px">
                  @endif
                </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <button class="btn btn-primary" type="submit">Guardar</button>
                  <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
             </div>
          </div>
                {!!Form::close()!!}

@endsection
@push('scripts')
<script>
$(document).ready(function(){
   isuser();
   function isuser(){
      var stock = document.getElementById('ppstock');
      stock.readOnly = true;
      var compra = document.getElementById('ppprecio_compra');
      compra.readOnly = true;
      var venta = document.getElementById('ppprecio_venta');
      venta.readOnly = true;
   }
});
</script>
@endpush