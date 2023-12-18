@extends('layouts.admin')

@section('contenido')

<div class="row">
  <div class="col-xs-6">
    <h3> Pedido {{$pedidos->id}}</h3>
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
{{-- {!!Form::open(['url'=>'ventas/pedidos', 'method'=>'POST','autocomplete'=>'off']) !!} --}}
{!!Form::model($pedidos,['method'=>'PATCH','route'=>['cliente-pedido.update',$pedidos->id]])!!}
{{Form::token()}}
<div class="row">
  <div class="col-lg-4 col-sm-4col-md-4 col-xs-12">
    <div class="form-group">
      <label for="Cliente">Cliente</label>
      <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
        @foreach($persona as $persona)
          @if($persona->nombre==$pedidos->nombre_cliente)
          <option value="{{$persona->idpersona}}" selected>{{$persona->nombre}} : {{$persona->telefono}} </option>
          @else
          <option value="{{$persona->idpersona}}">{{$persona->nombre}} : {{$persona->telefono}} </option>
          @endif
        @endforeach
      </select>
    </div>
  </div>
  {{-- <div class="col-lg-4 col-sm-4col-md-4 col-xs-12">
    <div class="form-group">
      <label for="Cliente">Cliente</label>
      <input type="text" name="idcliente" value="{{ $pedidos->nombre_cliente }} {{$pedidos->celular_cliente}}" class="form-control" readonly="readonly">        
    </div>
  </div> --}}
  
  <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
    <div class="form-group">
      <label for="fecha_entrega">Para</label>
      <input type="date" name="fecha_entrega" class="form-control" value="{{$pedidos->fecha_hora_entrega}}" required>
    </div>
  </div>

  <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
    <div class="form-group">
      <label for="hora_entrega">Hora</label>
      <input type="time" name="hora" class="form-control" value="{{$pedidos->hora}}">
    </div>
  </div>
  
  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label for="tipo_comprobante">Tipo de Comprobante</label>
      <select name="tipo_comprobante" class="form-control" id="" value="{{$pedidos->tipo_comprobante}}">
        
        @if ($pedidos->tipo_comprobante == "Efectivo")
          <option value="Efectivo" selected>Efectivo</option>    
        @else
          <option value="Efectivo">Efectivo</option>    
        @endif
        @if ($pedidos->tipo_comprobante == "Nota de Venta")
          <option value="Nota de Venta" selected>Nota de venta</option>    
        @else
          <option value="Nota de Venta">Nota de venta</option>          
        @endif
        @if ($pedidos->tipo_comprobante == "Con tarjeta")
          <option value="Con tarjeta" selected>Con tarjeta</option>    
        @else
          <option value="Con tarjeta">Con tarjeta</option>  
        @endif
        @if ($pedidos->tipo_comprobante == "Deposito")
          <option value="Deposito" selected>Deposito</option>    
        @else
          <option value="Deposito">Deposito</option>  
        @endif
        @if ($pedidos->tipo_comprobante == "otro")
          <option value="otro" selected>otro</option>    
        @else
          <option value="otro">otro</option>  
        @endif
        

      </select>
    </div>
  </div>

  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label for="serie_comprobante">Serie de Comprobante</label>
      <input type="text" name="serie_comprobante"  value="{{$pedidos->serie_comprobante}}" class="form-control" placeholder="Serie de Comprobante...." required>
    </div>
  </div>

  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label for="num_comprobante">Numero de Comprobante</label>  
      <input type="text" name="num_comprobante" required value="{{$pedidos->num_comprobante}}" class="form-control"  placeholder="Numero de Comprobante...." required>
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
          <option value="{{$articulo->idarticulo}}_{{$articulo->stock}}_{{$articulo->precio_venta}}">+{{$articulo->idarticulo}}+ {{$articulo->articulo}} {{$articulo->peso}} {{$articulo->empresa}}</option><!--cambio de $articulo->precio_promedio por precio_venta-->
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
      {{-- CAMPO EXTRA --}}
      <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
          <button type="button" id="otros" class="btn btn-warning">otro</button>
        </div>
      </div>

      {{-- ------------------------ --}}
      <div id="campos_otro">
      <div class="row">
      <div class="panel-body">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

          <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
              <label for="">Artículo</label>
                <input type="text" name="pdetallep" id="pdetallep" class="form-control" placeholder="detalle ...">
            </div>
          </div>
          
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <label for="cantidad">Cantidad</label>
              <input type="number" name="pcantidadp" id="pcantidadp" class="form-control" placeholder="cantidad" min="0">
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <label for="precio_venta">P. Venta</label>
              <input type="number" name="pprecio_ventap" id="pprecio_ventap" class="form-control" placeholder="Precio de venta">
            </div>
          </div>
          <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <label for="descuento">Descuento</label>
              <input type="number" name="pdescuentop" id="pdescuentop" class="form-control" placeholder="Descuento" value="0">
            </div>
          </div>
          <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
            <div class="form-group">
              <style>
                #bt_add_otro{
                  margin-top: 24px;
                }
              </style>
              <button type="button" id="bt_add_otro" class="btn btn-primary">Agregar</button>
            </div>
          </div>
      </div>
      </div>
      </div>
      </div>
      {{-- ------------------------ --}}
      {{-- FIN EXTRA  --}}

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
              <th><h4 id="total">{{-- {{$pedidos->total_venta}} --}}</h4> <input type="hidden" name="total_venta" id="total_venta"></th>
              <th></th>  
              <th></th>
              <th></th>
              <th></th>
            </tfoot>
          </table>
        </div>
      </div>

    </div>
  </div>
</div>


{{--  --}}
<div class="col-lg-12 col-sm-6 col-md-6 col-xs-12" id="guardar">
  <div class="form-group">
    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <div class="form-group">
        <label for="a_cuenta">A Cuenta: {{$pedidos->a_cuenta}}</label>
        <input type="number" id="total1" name="total1" class="form-control" placeholder="a cuenta ..." min="0" step=".01" value="{{$pedidos->a_cuenta}}">
      </div>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <div class="form-group">
        <label for="saldo">Saldo: {{$pedidos->saldo}} </label>
        <input type="number" id="saldo" name="saldo" class="form-control" placeholder="saldo ..." min="0" step=".01" value="{{$pedidos->saldo}}" readonly="readonly">
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="detalles1">Detalles</label>
        <input type="text" name="detalles1" class="form-control" placeholder="detalle ..." value="{{$pedidos->detalles}}">
      </div>
    </div>

    <button class="btn btn-warning" type="submit" style="margin-top: 24px;">Guardar</button> 
  </div>
</div>
{{--  --}}
<div class="col-lg-12 col-sm-6 col-md-6 col-xs-12" id="guardar">
  <div class="form-group">
     <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div style="border: cornflowerblue 2px solid;" class="radio">
        <label for="entregado"> 
        <input  type="radio" id="estadoPedido" name="estadoPedido" value="1">
        Finalizado</label>
        <label for="rechazado">
        <input  type="radio" id="estadoPedido2" name="estadoPedido" value="2">
        Rechazado </label>
      </div>
     </div>
     <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
      <div style="border: cornflowerblue 2px solid;" class="radio">
        <label for="">
        <input type="radio" name="recogio" value="1">
        Entregado</label>
        <label for="">
        <input type="radio" name="recogio" value="2">
        No recogio</label>
      </div>
     </div>
     <input name="_token" value="{{csrf_token()}}" type="hidden">
     

     <!-- Default unchecked -->
  </div>
</div>
  
{!!Form::close()!!}

@push ('scripts')
<script>

 $(document).ready(function(){

    control = 1
    agregar(control);
    saldo();

  $("#bt_add").click(function()
  {
    control = 0;
   agregar(control);
  });
  $("#otros").click(function()
  {
    control = 2;
    agregar(control);
  });
  $("#bt_add_otro").click(function()
  {
    control = 4;
    agregar(control);
  });
  $("#total1").keyup(function()
  {
    saldo();
  });

 });
 var cont=0;
 total=0;
 subtotal=[];
 articulos_repeditos=[];
 
  $("#guardar").hide();
  $("#pidarticulo").change(mostrarValores);

  function saldo(){
    a_cuenta = $('#total1').val();
    total1 = $('#total_venta').val();
    a_cuenta = total1 - a_cuenta;
    $('#saldo').val(a_cuenta);
  }
  function mostrarValores()
  {
   datosArticulos=document.getElementById('pidarticulo').value.split('_');
   $("#pprecio_venta").val(datosArticulos[2]);
   $("#pstock").val(datosArticulos[1]);
  }
  
  function agregar(control) 
  {

    /* obtenermos el control para traer los detalles 
    si son antiguos o si son recien editados
     */
    if(control == 1) {
      $("#campos_otro").hide();
      /* usamos directiva json para traer el pedido directo al js*/
      var detalle = @json($detalles_pedido);
      var detalleNull = @json($detalles_pedido_null);

      for(let i=0;i<detalle.length;i++) {
        iddetale_pedido = detalle[i].iddetale_pedido;
        otro = detalle[i].otro;
        idarticulo = detalle[i].idarticulo;

        //articulo = detalle[i].articulo;
        articulo ="+"+detalle[i].idarticulo+"+ "+detalle[i].articulo+" "+detalle[i].peso+" "+detalle[i].empresa;
        //+{{$articulo->idarticulo}}+ {{$articulo->articulo}} {{$articulo->peso}} {{$articulo->empresa}}

        articulos_repeditos[cont] = articulo;/////////////////METIENDO A MI ARRAY DE RESTRICCION ARTICULO
        
        cantidad = detalle[i].cantidad;
        descuento = detalle[i].descuento;
        precio_venta = detalle[i].precio_venta;
        subtotal[cont] = (cantidad*precio_venta-descuento);
        total = total + subtotal[cont];    
        
        
          var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td><input type="hidden" name="iddetale_pedido[]" value="'+iddetale_pedido+'"><input type="hidden" name="idarticulo[]" value="'+idarticulo+'"><input type="hidden" name="otro[]" value="">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>';
        
        /* var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td><input type="hidden" name="idarticulo[]" value=""><input type="hidden" name="otro[]" value="'+articulo+'">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>'; */
        
        $("#detalles").append(fila);
        $("#total").html("Bs. "+ total);
        $("#total_venta").val(total);
        $("#total1").val(total);
        evaluar();
        cont++;

      }
      for(let i=0;i<detalleNull.length;i++){
        iddetale_pedido = detalleNull[i].iddetale_pedido;
        otro = detalleNull[i].otro;
        articulos_repeditos[cont] = otro;/////////////////METIENDO A MI ARRAY DE RESTRICCION ARTICULO
        /* idarticulo = detalle[i].idarticulo; */
        /* articulo = detalle[i].articulo; */
        cantidad = detalleNull[i].cantidad;
        descuento = detalleNull[i].descuento;
        precio_venta = detalleNull[i].precio_venta;
        subtotal[cont] = (cantidad*precio_venta-descuento);
        total = total + subtotal[cont];    
        
        
        var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td style="color:blue;"><input type="hidden" name="iddetale_pedido[]" value="'+iddetale_pedido+'"><input type="hidden" name="idarticulo[]" value=""><input type="hidden" name="otro[]" value="'+otro+'">'+otro+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>';
        
        /* var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td><input type="hidden" name="idarticulo[]" value=""><input type="hidden" name="otro[]" value="'+articulo+'">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>'; */
        
        $("#detalles").append(fila);
        $("#total").html("Bs. "+ total);
        $("#total_venta").val(total);
        $("#total1").val(total);
        evaluar();
        cont++;

      }
      

    } if (control == 2) {
      $("#campos_otro").show();
    }
    if ( control == 4 ) {
      $("#campos_otro").hide();
      articulo     = $("#pdetallep").val();
      cantidad     = $("#pcantidadp").val();
      precio_venta = $("#pprecio_ventap").val();
      descuento    = $("#pdescuentop").val();



      if ( cantidad!=""&& cantidad > 0  && descuento!="" && precio_venta!="" && cantidad % 1 == 0) 
      {
        subtotal[cont] = (cantidad*precio_venta-descuento);
        total = total + subtotal[cont];

        var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td style="color:blue;"><input type="hidden" name="idarticulo[]" value=""><input type="hidden" name="otro[]" value="'+articulo+'">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>';

        cont++;
        limpiar();
        $("#total").html("Bs. "+ total);
        $("#total_venta").val(total);
        $("#total1").val(total);
        evaluar();
        $("#detalles").append(fila);
      
      }
      
      else
      {
      alert("Error al ingresar el detalle de la venta, por favor revise los datos de Artículo");
      }
    }
    if ( control == 0 ) {
      $("#campos_otro").hide();

      var nopasa = 1;

      datosArticulos=document.getElementById('pidarticulo').value.split('_');
      idarticulo=datosArticulos[0];
      articulo =$("#pidarticulo option:selected").text();
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
        if(stock>=cantidad) {
          
          articulos_repeditos[cont]=articulo;
          /*  */
          subtotal[cont] = (cantidad*precio_venta-descuento);    
          total = total + subtotal[cont];
          var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'"><input type="hidden" name="otro[]" value="">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont]+'</td></tr>';
          cont++;
          limpiar();
          $("#total").html("Bs. "+ total);
          $("#total_venta").val(total);
          $("#total1").val(total);
          evaluar();
          $("#detalles").append(fila);
            
        }
        else {
        alert('la cantidad a vender supera el stock');
        }
      }
      else {
      alert("Error al ingresar el detalle de la venta, por favor revise los datos de Artículo");
      }    
      
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




