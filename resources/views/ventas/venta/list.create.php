@extends('layouts.admin')

@section('contenido')



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
  <div class="form-group">
    <label for="Cliente">Cliente</label>
      <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
        @foreach($personas as $persona)

        <option value="{{$persona->idpersona}} ">{{$persona->nombre}} : {{$persona->telefono}} </option>
        @endforeach
      </select>
    </div>
 </div>

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
   <input type="text" name="serie_comprobante"  value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie de Comprobante....">
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
      <option value="{{$articulo->idarticulo}}_{{$articulo->stock}}_{{$articulo->precio_venta}}">{{$articulo->articulo}} : {{$articulo->peso}} : {{$articulo->empresa}}</option><!--cambio de $articulo->precio_promedio por precio_venta-->
       @endforeach
      </select>
     </div>
    </div>
  </div>

<!----------------------------------------------------------------------------------------------->
          <div class="panel-body">
          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
            <label for="">Artículo</label>
            <select  name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true">
              @foreach($articulos as $articulo)
              <option value="#">{{$articulo->articulo}}</option><!--cambio de $articulo->precio_promedio por precio_venta-->
              
              @endforeach
            </select>
            </div>
          </div>
        </div>

 {{-- /*
        <style>
.select-sim {
  width:200px;
  height:22px;
  line-height:22px;
  vertical-align:middle;
  position:relative;
  background:white;
  border:1px solid #ccc;
  overflow:hidden;
}

.select-sim::after {
  content:"▼";
  font-size:0.5em;
  font-family:arial;
  position:absolute;
  top:50%;
  right:5px;
  transform:translate(0, -50%);
}

.select-sim:hover::after {
  content:"";
}

.select-sim:hover {
  overflow:visible;
}

.select-sim:hover .options .option label {
  display:inline-block;
}

.select-sim:hover .options {
  background:white;
  border:1px solid #ccc;
  position:absolute;
  top:-1px;
  left:-1px;
  width:100%;
  height:88px;
  overflow-y:scroll;
}

.select-sim .options .option {
  overflow:hidden;
}

.select-sim:hover .options .option {
  height:22px;
  overflow:hidden;
}

.select-sim .options .option img {
  vertical-align:middle;
}

.select-sim .options .option label {
  display:none;
}

.select-sim .options .option input {
  width:0;
  height:0;
  overflow:hidden;
  margin:0;
  padding:0;
  float:left;
  display:inline-block;
  /* "hack" para que funcione en Firefox */
  position: absolute;
  left: -10000px;
}

.select-sim .options .option input:checked + label {
  display:block;
  width:100%;
}

.select-sim:hover .options .option input + label {
  display:block;
}

.select-sim:hover .options .option input:checked + label {
  background:#fffff0;
}
        </style>


        <div class="select-sim" id="select-color" style="width: 400px; height:200px">
          <div class="options">
            <div class="option">
              <input type="radio" name="color" value="" id="color-" checked />
              <label for="color-">
                <img src="http://placehold.it/22/ffffff/ffffff" alt="" /> Selecciona un color
              </label>
            </div>
            @foreach($articulos as $articulo)
            <div class="option">
              <input type="radio" name="color" value="rojo" id="color-rojo" />
              <label for="color-rojo">
                <img src="{{URL('imagenes/articulos/'.$articulo->imagen)}}" alt="0" height="40px" width="40px" />{{$articulo->articulo}}
              </label>
            </div>
            @endforeach
          </div>
        </div>

*/ --}}
<!----------------------------------------------------------------------------------------------->
{{--  --}}

<style>
.dropdown dd, .dropdown dt, .dropdown ul { margin:0px; padding:0px; }
.dropdown dd { position:relative; }
.dropdown a, .dropdown a:visited { color:#000000; text-decoration:none; outline:none;}
.dropdown dt a {background: url('http://www.jankoatwarpspeed.com/wp-content/uploads/examples/reinventing-drop-down/arrow.png') no-repeat scroll right center; display:block; padding-right:20px;
                 width:150px;}
.dropdown dt a span {cursor:pointer; display:block; padding:5px;}
.dropdown dd ul { background: none repeat scroll 0 0; color:#C5C0B0; display:none;
                  left:0px; padding:5px 0px; position:absolute; top:2px; width:auto; min-width:170px; list-style:none;}
.dropdown span.value { display:none;}
.dropdown dd ul li a { padding:5px; display:block;}

.dropdown img.flag { vertical-align:middle; margin-right:10px; float:left;}
.flagvisibility { display:none;}
</style>

{{--  --}}

    {{-- CONCLUCION TRATAR DE OBTENER TODAS LAS IMAGENES DE UNA SOLA VISTA ES PESADO --}}

<dl id="sample" class="dropdown">
        <dt><a href="#"><span>Seleccione : </span></a></dt>
        <dd>
            <ul>
              @foreach($articulos as $articulo)
              {{-- <li><a href="#">Imagen 1<img class="flag" style="width:70px;" src="{{URL('imagenes/articulos/'.$articulo->imagen)}}" alt="0" /><span class="value">BR</span></a></li> --}}
              @endforeach

            </ul>
        </dd>
    </dl>
{{--  --}}
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
     <button class="btn bg-primary" type="submit">
      Guardar
     </button>
   
     <button class="btn btn-danger" type="reset">Cancelar</button>
   </div>
  </div>
</div>
  
{!!Form::close()!!}

@push ('scripts')
<script>
  $(".dropdown img.flag").addClass("flagvisibility");
      $(".dropdown dt a").click(function() {
          $(".dropdown dd ul").toggle();
      });
  
      $(".dropdown dd ul li a").click(function() {
          var text = $(this).html();
          $(".dropdown dt a span").html(text);
          $(".dropdown dd ul").hide();
          $("#result").html("Selected value is: " + getSelectedValue("sample"));
      });
  
      function getSelectedValue(id) {
          return $("#" + id).find("dt a span.value").html();
      }
  
      $(document).bind('click', function(e) {
          var $clicked = $(e.target);
          if (! $clicked.parents().hasClass("dropdown"))
              $(".dropdown dd ul").hide();
      });
  
      $(".dropdown img.flag").toggleClass("flagvisibility");
  </script>
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
  articulo =$("#pidarticulo option:selected").text();
  cantidad =$("#pcantidad").val();
  cantidad=parseFloat(cantidad);
  descuento= $("#pdescuento").val();
  precio_venta = $("#pprecio_venta").val();
  stock = $("#pstock").val();
  stock=parseFloat(stock);
    

  if (idarticulo!="" && cantidad!=""&& cantidad > 0  && descuento!="" && precio_venta!="" && cantidad % 1 == 0) 
  {
    if(stock>=cantidad){
      subtotal[cont] = (cantidad*precio_venta-descuento);
   total = total + subtotal[cont];

   var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>';

   cont++;
   limpiar();
   $("#total").html("Bs. "+ total);
   $("#total_venta").val(total);
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




