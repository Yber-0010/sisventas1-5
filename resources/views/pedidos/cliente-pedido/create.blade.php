@extends('layouts.admin')

@section('contenido')
<div>
  <a href="" data-target="#modal_cliente" data-toggle="modal">
    <button class="btn btn-success">Nuevo Cliente</button>
  </a>
</div>
@include('pedidos.cliente-pedido.modal_cliente')
<div class="row">
  <div class="col-xs-6">
    <h3>Nuevo Pedido</h3>
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
{!!Form::open(['url'=>'pedidos/cliente-pedido', 'method'=>'POST','autocomplete'=>'off']) !!}
{{Form::token()}}
<div class="row">
  <div class="col-lg-4 col-sm-4col-md-4 col-xs-12">
    <div class="form-group">
      <label for="Cliente">Cliente</label>
      <select name="idcliente" id="idcliente" class="form-control selectpicker" data-live-search="true">
        @foreach($personas as $persona)

        <option value="{{$persona->idpersona}}">{{$persona->nombre}} : {{$persona->telefono}} </option>
          
        @endforeach
      </select>
    </div>
  </div>
  
  <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
    <div class="form-group">
      <label for="fecha_entrega">Para</label>
      <input type="date" name="fecha_entrega" class="form-control" required>
    </div>
  </div>

  <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
    <div class="form-group">
      <label for="hora_entrega">Hora</label>
      <input type="time" name="hora" class="form-control">
    </div>
  </div>
  
  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label for="tipo_comprobante">Tipo de Comprobante</label>
      <select name="tipo_comprobante" class="form-control" id="">
        <option value="Efectivo">Efectivo</option>
        <option value="Nota de Venta">Nota de venta</option>
        <option value="Con tarjeta">Con tarjeta</option>
        <option value="Deposito">Deposito</option>
        <option value="otro">otro</option>
      </select>
    </div>
  </div>

  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label for="serie_comprobante">Serie de Comprobante</label>
      <input type="text" name="serie_comprobante"  value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie de Comprobante...." required>
    </div>
  </div>

  <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
    <div class="form-group">
      <label for="num_comprobante">Numero de Comprobante</label>  
      <input type="text" name="num_comprobante" required value="{{old('num_comprobante')}}" class="form-control"  placeholder="Numero de Comprobante...." required>
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
          </option>
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
      <div class="col-lg-1 col-md-2 col-sm-2 col-xs-12">
        <div class="form-group">
          <style>
            #bt_add{
              margin-top: 24px;
            }
            #otros{
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
              <th><h4 id="total">Bs. 0.00</h4> <input type="hidden" name="total_venta" id="total_venta"></th>
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
        <label for="a_cuenta">A Cuenta</label>
        <input type="number" name="total1" id="total1" class="form-control" placeholder="a cuenta ..." min="0" step=".01" value="0">
      </div>
    </div>

    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
      <div class="form-group">
        <label for="saldo">Saldo</label>
        <input type="number" id="saldo" name="saldo" class="form-control" placeholder="saldo ..." min="0" step=".01" value="0" readonly="readonly">
      </div>
    </div>

    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
      <div class="form-group">
        <label for="detalles1">Detalles</label>
        <input type="text" name="detalles1" class="form-control" placeholder="detalle ...">
      </div>
    </div>
  </div>
</div>
{{--  --}}

<div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
  <div class="form-group">
     <input name="_token" value="{{csrf_token()}}" type="hidden">
     <button class="btn bg-primary" type="submit">Pedir</button> 
     <button class="btn btn-danger" {{-- type="reset" --}}>Cancelar</button>
  </div>
</div>
  
{!!Form::close()!!}

@push ('scripts')
<script>
 $(document).ready(function(){

   control = 3;
   agregar(control);
   

    $("#bt_add").click(function()
    {
      control = 0;
      agregar(control);
    });
    $("#otros").click(function()
    {
      control = 1;
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
    total = $('#total_venta').val();
    a_cuenta = total - a_cuenta;
    $('#saldo').val(a_cuenta);
    console.log(a_cuenta);
  }
  function mostrarValores()
  {
   datosArticulos=document.getElementById('pidarticulo').value.split('_');
   $("#pprecio_venta").val(datosArticulos[2]);
   $("#pstock").val(datosArticulos[1]);
  }
 function agregar(control) 
  {
    if(control == 1) {
      $("#campos_otro").show();
    } 
    if(control == 3) {
      $("#campos_otro").hide();
    }
    if (control == 4) {

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
    if (control == 0) {
      $("#campos_otro").hide();
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
        if(stock>=cantidad){
          articulos_repeditos[cont]=articulo;

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
      
      else
      {
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




