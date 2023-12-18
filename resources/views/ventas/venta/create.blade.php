@extends('layouts.admin')

@section('contenido')
<style>
    .max-height-50 {
        max-height: 50px;
        padding: 5px;
        min-width: 70px;
    }
    .max-w {
        max-width: 150px;
    }
    .numFormat {
        width: 80px;
        text-align: center;
        font-size: 20px;
    }
    .numFormat::-webkit-inner-spin-button,
    .numFormat::-webkit-outer-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }

    .numFormat {
    -moz-appearance: textfield;
    }
    .plus{
        margin-right: 5px;
        width: 30px;
        border: none;
        background:   #A9D0F5;
        border: 2px solid #A9D0F5;
        border-radius: 5px;
        font-weight: bold;
    }
    .plus:hover{
        background:   #398ab4;
        color:   #fff;
    }
    .less{
        margin-right: 5px;
        width: 30px;
        border: none;
        background:   #fff;
        border: 2px solid #A9D0F5;
        border-radius: 5px;
        font-weight: bold;
    }
    .less:hover{
        background:   #398ab4;
        color:   #fff;
    }

</style>
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
        <option value="select"></option>
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
	  <input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="cantidad" min="1">

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
       <th>Imagen</th>
	   <th>Cantidad</th>
	   <th>Stock</th>
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
	 <input name="_token" value="{{csrf_token()}}" type="hidden"/>
	 <button class="btn bg-primary" type="submit" id="count_click" name="count_click">
	  Guardar
	 </button>

	 <button class="btn btn-danger" type="reset">Cancelar</button>
     <span id="endlastpoind"></span>
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
let wss = '';
let restablecer = 0;
let articulosData = {!! json_encode($articulos) !!};

// TODO nos quedamos aca validando casos en los que no deberia permitir escanear como duplicados etc
function searchByCode(code){
    let articulo = articulosData.filter(function (a) {
            return a.codigo == code;
    });
    if (articulo.length > 1) {
        alert("Alerta: Se encontro mas de un articulo, para buscar el codigo debe ser unico o busque manualmente.");
    } else {
        let articulo = articulosData.find(function (a) {
            return a.codigo == code;
        });
        return articulo
    }
    return null
}
function searchById(id){
    let articulo = articulosData.find(function (a) {
            return a.idarticulo == id;
    });
    articulo?'':'no se encontro'
    return articulo
}
 $(document).ready(function() {
    startWs();
    $("#bt_add").click(function() {
        agregar(1);
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
   document.getElementById("pcantidad").value = 1;
  }
function irAlPieDePagina() {
    // Obtén el elemento del pie de página
    var pieDePagina = document.getElementById('endlastpoind');

    // Desplázate hasta el pie de página
    if (pieDePagina) {
        pieDePagina.scrollIntoView({ behavior: 'smooth' });
    }
}

function agregar(option,code='') {
    let producto = '';
    if(option===1){
        datosArticulos = document.getElementById('pidarticulo').value.split('_');
        idarticulo = datosArticulos[0];
        producto = searchById(idarticulo);
        cantidad = $("#pcantidad").val();
        descuento = $("#pdescuento").val();
    }
    if(option===2){
        producto = searchByCode(code);
        idarticulo = `${producto.idarticulo}`
        cantidad = 1;
        descuento = '0';
        irAlPieDePagina();
    }
    if(producto===undefined||producto===null){
        alert("Error");
        return
    }
  	articulo = producto.idarticulo+" "+producto.articulo;
  	// cantidad = $("#pcantidad").val();
	cantidad = parseFloat(cantidad);
	// descuento = $("#pdescuento").val();
	precio_venta = producto.precio_venta
	stock = producto.stock
	stock = parseFloat(stock);
  	articulo = articulo.trim();
	nopasa = 1;
	for ( let i=0 ; i<cont ; i++ ) {
		// if(articulos_repeditos[i] === articulo){
		// 	nopasa = 0;
		// }
		if(articulos_repeditos[i] === articulo){

			let canTotal = $(`#cant-${idarticulo}`).val();

            if(canTotal<stock){
                canTotal = parseInt(canTotal) + 1;
                $(`#cant-${idarticulo}`).val(canTotal)
                canTotal = $(`#cant-${idarticulo}`).val();
                desTotal = $(`#desc-${idarticulo}`).val();
                total = total - subtotal[i];
                subtotal[i] = canTotal*precio_venta-desTotal;
                total = total + subtotal[i];
                $(`#subTotal${idarticulo}`).html(`${canTotal*precio_venta-desTotal}`);
                $("#total").html("Bs. "+ total.toFixed(2));
                $("#total_venta").val(total.toFixed(2));
                return
            } else {
                alert("stock insuficiente")
                return
            }
		}
	}

	if (idarticulo!="" && cantidad!=""&& cantidad > 0  && descuento!="" && precio_venta!="" && cantidad % 1 == 0 && nopasa == 1) {
		if(stock>=cantidad){
		articulos_repeditos[cont]=articulo;

		subtotal[cont] = (cantidad*precio_venta-descuento);
		total = total + subtotal[cont];

		/* var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont].toFixed(2)+'</td></tr>'; */
		var fila = `
            <tr class="selected" id="fila${cont}">
                <td>
                    <button type="button" class="btn btn-warning" onclick="eliminar(${cont}); ">X</button>
                </td>
                <td class="max-w">
                    <input type="hidden" name="idarticulo[]" value="${idarticulo}">${articulo}
                </td>
                <td class="max-height-50">
                    <img src="{{asset('imagenes/articulos/${producto.imagen}')}}" width="50px" heigth="50px" alt="img">
                </td>
                <td>
                    <div class="row" style="display:flex;min-width:170px;margin-left:5px;">
                        <button type="button" class="less" id="les-${idarticulo}" onclick="lessCantidad(${cont},${idarticulo},${precio_venta},${stock})">-</button>
                        <button type="button" class="plus" id="plus-${idarticulo}" onclick="sumCantidad(${cont},${idarticulo},${precio_venta},${stock})">+</button>
                        <input type="number" class="numFormat" id="cant-${idarticulo}" name="cantidad[]" value="${cantidad}" onkeyup="changeCantidad(${cont},${idarticulo},${precio_venta},${stock});" onchange="changeCantidad(${cont},${idarticulo},${precio_venta},${stock});" min="1" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                    </div>
                </td>
                <td>
                    <input type="number" readonly="readonly" disabled="true" value="${stock}">
                </td>
                <td>
                    <input readonly="readonly" type="number" disabled="true" value="${precio_venta}">
                    <input readonly="readonly" type="hidden" name="precio_venta[]" value="${precio_venta}">
                </td>
                <td>
                    <div class="row" style="display:flex;min-width:170px;margin-left:5px;">
                        <button type="button" class="less" id="lesDes-${idarticulo}" onclick="lessDescuento(${cont},${idarticulo},${precio_venta},${stock})">-</button>
                        <button type="button" class="plus" id="plusDes-${idarticulo}" onclick="sumDescuento(${cont},${idarticulo},${precio_venta},${stock})">+</button>
                        <input type="text" class="numFormat" id="desc-${idarticulo}" name="descuento[]" value="${descuento}" onkeyup="changeCantidad(${cont},${idarticulo},${precio_venta},${stock});" onchange="changeCantidad(${cont},${idarticulo},${precio_venta},${stock});" min="0.00" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\.\d{3})\d*$/, '$1');">
                    </div>
                </td>
                <td>
                <span id="subTotal${idarticulo}" style="font-size:20px; margin-left:5px;"></span><span style="font-size:20px; margin-left:5px;">Bs.</span>
                </td>
            </tr>`;
            limpiar();
            $("#total").html("Bs. "+ total.toFixed(2));
            $("#total_venta").val(total.toFixed(2));
            evaluar();
            $("#detalles").append(fila);
            changeCantidad(cont,idarticulo,precio_venta,stock)
            cont++;
		}
		else {
			alert('la cantidad a vender supera el stock');
		}
	}
	else {
		alert("Error al ingresar el detalle de la venta, por favor revise los datos de Artículo");
	}
 }
 function lessDescuento(cont,id,precio,stock){
    let descuentoless = parseInt($(`#desc-${id}`).val(), 10);
    if (!isNaN(descuentoless)) {
        if(descuentoless>0){
            descuentoless -= 1;
            $(`#desc-${id}`).val(descuentoless);
            changeCantidad(cont,id,precio,stock)
        }
    } else {
        alert("Error el descuento debe ser un numero");
    }
 }
 function sumDescuento(cont,id,precio,stock){
    let descuentosum = parseInt($(`#desc-${id}`).val(), 10);
    if (!isNaN(descuentosum)) {
        descuentosum += 1;
        $(`#desc-${id}`).val(descuentosum);
        changeCantidad(cont,id,precio,stock)
    } else {
        alert("Error el descuento debe ser un numero");
    }
 }
 function lessCantidad(cont,id,precio,stock){
    let cantidadLess = parseInt($(`#cant-${id}`).val(), 10);
    if (!isNaN(cantidadLess)) {
        if(cantidadLess>1){
            cantidadLess -= 1;
            $(`#cant-${id}`).val(cantidadLess);
            changeCantidad(cont,id,precio,stock)
        }
    } else {
        alert("Error la cantidad debe ser un numero");
    }
 }
 function sumCantidad(cont,id,precio,stock){
    let cantidadPluss = parseInt($(`#cant-${id}`).val(), 10);
    if (!isNaN(cantidadPluss)) {
        cantidadPluss += 1;
        $(`#cant-${id}`).val(cantidadPluss);
        changeCantidad(cont,id,precio,stock)
    } else {
        alert("Error la cantidad debe ser un numero");
    }
 }
 function changeCantidad(cont,id,precio,stock){

    cantidadTotal = $(`#cant-${id}`).val();
    if( cantidadTotal>stock ){
        alert("Error la cantidad no puede ser mayor al stock");
        $(`#cant-${id}`).val(stock);
        cantidadTotal = stock;
    }
    descuentoTotal = $(`#desc-${id}`).val();
    if( descuentoTotal<0){
        alert("Error el descuento no puede ser menor a 0");
        $(`#desc-${id}`).val(0);
        descuentoTotal = 0;
    }

    if(cantidadTotal<1){cantidadTotal=1};
    if(descuentoTotal<0){descuentoTotal=0};
    if(descuentoTotal>precio){
        alert("Error el descuento no puede ser mayor al precio");
        $(`#desc-${id}`).val(precio);
        descuentoTotal = precio;
    }
    $(`#subTotal${id}`).html(`${cantidadTotal*precio-descuentoTotal}`);
    total = total - subtotal[cont];
    subtotal[cont] = cantidadTotal*precio-descuentoTotal;
    total = total + subtotal[cont];

    $("#total").html("Bs. "+ total.toFixed(2));
    $("#total_venta").val(total.toFixed(2));
    setTimeout(() => {
        cantidadTotal = $(`#cant-${id}`).val();
        if( cantidadTotal==0 ){
            $(`#cant-${id}`).val(1);
            cantidadTotal = 1;
        }
    }, 2000);
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
 function startWs() {
		conectWs();
	}
	async function conectWs() {
		try {
			wss = await conection()
		} catch (error) {
			reconectionWs();
			desconectionWs();
		}
	}
	function conection() {
		return new Promise((resolve, reject) => {
			const websock = new WebSocket(`ws://192.168.1.3:3000/ws/c21895f0-3c29-4ec5-a9d0-6dd9a06a7e89`)
			websock.onopen = () => {
				console.log("Conectado al ws")
				useWs(websock)
				resolve(websock)
			}
			websock.onclose = () => {
				websock.CLOSED
				reject('desconectado')
			}
		})
	}
	function useWs(ws) {
		const websocket = ws;

		websocket.addEventListener('message', event => {
			try {
				console.log(event.data)
				agregar(2,event.data)
                // searchByCode(event.data)

			} catch (error) { }
		});
		websocket.addEventListener('close', () => {
			reconectionWs();
			desconectionWs();
		});
	}
	async function reconectionWs() {
		while (!restablecer) {
			try {
				wss = await conection();
				restablecer = 1;
				console.log("restablecido")
			} catch (error) {
				await new Promise(resolve => setTimeout(resolve, 100)); // loop time
			}
		}
	}
	function desconectionWs() {
		console.error('Desconectado del ws')
		restablecer = 0;
	}
</script>
@endpush

@endsection




