@extends('layouts.admin')

@section('contenido')
<div>
  @livewire('create-cliente')
  {{-- <a href="" data-target="#modal_cliente" data-toggle="modal">
    <button class="btn btn-success">Nuevo Cliente</button>
  </a> --}}
</div>
@include('ventas.venta.modal_cliente')
<div class="row">
  <div class="col-xs-6">
    <h3>Nueva Venta</h3>
    @if(count($errors)>0)
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
  {!!Form::open(['url'=>'ventas/venta', 'method'=>'POST','autocomplete'=>'off']) !!}
  {{Form::token()}}
<div class="row">

 <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
  @livewire('lista-clientes')
  {{-- <div class="form-group">
      <label for="Cliente">Cliente</label>

      <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
        @foreach($personas as $persona)

        <option value="{{$persona->idpersona}} ">{{$persona->nombre}} : {{$persona->telefono}} </option>
        @endforeach
      </select>
  </div> --}}
 </div>

@can('isAdmin')
 <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
  <div class="form-group">
   <label for="fecha">fecha</label>
   <input type="datetime" name="mytime" required value="{{$mytime}}" class="form-control"  placeholder="Numero de Comprobante....">
  </div>
 </div>
@endcan
 <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
  <div class="form-group">
   <label for="tipo_comprobante">Tipo de Comprobante</label>
   <select name="tipo_comprobante" class="form-control" id="">
    <option value="Efectivo">Efectivo</option>
    <option value="Nota de Venta">Nota de venta</option>
    <option value="Con tarjeta">Con tarjeta</option>
   </select>
  </div>
 </div>

 <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
  <div class="form-group">
   <label for="serie_comprobante">Serie de Comprobante</label>
   <input type="text" name="serie_comprobante"  required value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie de Comprobante....">
  </div>
 </div>

 <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
  <div class="form-group">
   <label for="num_comprobante">Numero de Comprobante</label>
   <input type="text" name="num_comprobante" required value="{{old('num_comprobante')}}" class="form-control"  placeholder="Numero de Comprobante....">
  </div>
 </div>

 



 
</div>

<div class="row">

  <div class="panel panel-primary">
   <div class="panel-body">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
     <div class="form-group">
      <label for="">Artículo</label>
      <select  name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true">
       @foreach($articulos as $articulo)
      <option value="{{$articulo->idarticulo}}_{{$articulo->stock}}_{{$articulo->precio_venta}}">
        +{{$articulo->idarticulo}}+ {{$articulo->articulo}} {{$articulo->peso}} {{$articulo->empresa}}
      </option><!--cambio de $articulo->precio_promedio por precio_venta-->
       @endforeach
      </select>
     </div>
    </div>
  </div>
  <div class="row">
    
      <div class="panel-body">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">

     <div class="form-group">
      <label for="cantidad">Cantidad</label>
      <input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="cantidad" min="0">

     </div>
     
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">

     <div class="form-group">
      <label for="stock">Stock</label>
      <input type="number" disabled name="pstock" id="pstock" class="form-control" placeholder="Stock">

     </div>
     
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <div class="form-group">
       <label for="precio_venta">P. Venta</label>
       <input type="number" disabled name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="Precio de venta">
      </div>
     </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">

     <div class="form-group">
      <label for="descuento">Descuento</label>
      <input type="number" name="pdescuento" id="pdescuento" class="form-control" placeholder="Descuento">
     </div>
     
    </div>
    
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">

     <div class="form-group">
       <style>
         #bt_add{
          margin-top: 24px;
         }
       </style>
      <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
     </div>
    </div>



    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
    <div class="table-responsive">
     <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">

      <thead style="background-color:#A9D0F5">
       <th>Opciones</th>
       <th>Artículo</th>
       <th>Cantidad</th>
       <th>Precio Venta</th>
       <th>Descuento</th>
       <th>Sub Total</th>
      </thead>
      <tfoot>
       <th>TOTAL</th>
       <th><h4 id="total">Bs. 0.00</h4> <input type="hidden" name="total_venta" id="total_venta"></th>
       <th></th>
       <th></th>
       <th></th>
       <th>
        
       </th>
      </tfoot>
      <tbody>
       
      </tbody>
      
     </table>
     </div>
    </div>

  
</div>
   </div>
  </div>
  



  <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
   <div class="form-group">
     <input name="_token" value="{{csrf_token()}}" type="hidden"></input>
     <button class="btn bg-primary" type="submit" id="count_click" name="count_click">
      Guardar
     </button>
     
     <button class="btn btn-danger" type="reset">Cancelar</button>
   </div>
  </div>
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
  $("#bt_add").click(function()
  {
   agregar();
  });
 });
 var cont=0;
 total=0;
 subtotal=[];
 articulos_repeditos=[];
  $("#guardar").hide();
  $("#pidarticulo").change(mostrarValores);


  function mostrarValores()
  {
   datosArticulos=document.getElementById('pidarticulo').value.split('_');
   $("#pprecio_venta").val(datosArticulos[2]);
   $("#pstock").val(datosArticulos[1]);
  }
 function agregar() 
 {
  datosArticulos=document.getElementById('pidarticulo').value.split('_');

  idarticulo=datosArticulos[0];
// ENTRADA DE OPCION PARTIDO EN VECTORES POR + SOLO OBTENIENDO TODO MENOS EL CODIGO DEL PRODUCTO //
  articulo =$("#pidarticulo option:selected").text();
  articulo=articulo.split('+');
  articulo = articulo[1]+articulo[2];
///////////////////////////////////////////////////////////////////////////////////////////////////
  // articulo =$("#pidarticulo option:selected").text(); // obtenia todo el contenido del option
  cantidad =$("#pcantidad").val();
  cantidad=parseFloat(cantidad);
  descuento= $("#pdescuento").val();
  precio_venta = $("#pprecio_venta").val();
  stock = $("#pstock").val();
  stock=parseFloat(stock);
    
  /*  comprobando si articulo esta repetido*/
  articulo = articulo.trim();
      
      nopasa = 1;
      for ( let i=0 ; i<cont ; i++ ) {
        if(articulos_repeditos[i] == articulo){
          // este articulo esta repedito
          //console.log("repetido : "+articulos_repeditos[i]+" "+i);
          nopasa = 0;
        } else {
          //console.log("No repetido : "+articulos_repeditos[i]+" "+i);
        }
      }
      console.log("nopasa ="+nopasa);

  if (idarticulo!="" && cantidad!=""&& cantidad > 0  && descuento!="" && precio_venta!="" && cantidad % 1 == 0 && nopasa == 1) 
  {
    if(stock>=cantidad){
      articulos_repeditos[cont]=articulo;

      subtotal[cont] = (cantidad*precio_venta-descuento);
   total = total + subtotal[cont];

   var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont].toFixed(2)+'</td></tr>';

   cont++;
   limpiar();
   $("#total").html("Bs. "+ total.toFixed(2));
   $("#total_venta").val(total.toFixed(2));
   evaluar();
   $("#detalles").append(fila);
  }
  else {
    alert('la cantidad a vender supera el stock');
  }
    }
   
  else
  {
   alert("Error al ingresar el detalle de la venta, por favor revise los datos de Artículo");
  }
 }

 function limpiar() 
 {
  $("#pcantidad").val("");
  $("#pdescuento").val("0");
  $("#pprecio_venta").val("");
 }

 function evaluar()
 {
  if (total>0) 
  {
   $("#guardar").show();

  }
  else
  {
   $("#guardar").hide();
  }
 }
 function eliminar(index)
 {
   /* FUNCIONA */
  imprimir = articulos_repeditos[index];
  articulos_repeditos[index] = "";
  /*  */
  total= total - subtotal[index];
  $("#total").html("Bs. " +total);
  $("#total_venta").val(total);
  $("#fila" + index).remove();
  evaluar();
 } 
 $(document).ready(function(){
      valores();
 });
 function valores(){
  val=0;
      $("#pdescuento").val(val);
 }
</script>
@endpush
@endsection




