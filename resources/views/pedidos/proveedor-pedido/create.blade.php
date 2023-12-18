@extends ('layouts.admin')
@section ('contenido')
<style>
.contenedor {
  width: 100%;
  margin: 2px;
}   
</style>
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        <div class="form-group">
            <h2>Nuevo pedido proveedor</h2>
        </div>
    </div>
</div>
{!!Form::open(['url'=>'pedidos/proveedor-pedido', 'method'=>'POST','autocomplete'=>'off']) !!}
{{Form::token()}}
<div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        {{-- <input type="text" list="proveedor" id="name_proveedor" name="name_proveedor" value="1"> --}}
            @livewire('pedido-proveedor')
    </div>
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
        {{-- modulo coipado pedidos --}}
        <div class="row">
            <div class="panel panel-primary">
                <div class="panel-body">
                    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                        <div class="form-group">
                            <label for="">Artículo</label>
                            <select  name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true">
                            @foreach($articulos as $articulo)
                                <option value="{{$articulo->idarticulo}}_{{$articulo->stock}}_{{$articulo->precio_venta}}_{{$articulo->precio_compra}}">
                                +{{$articulo->idarticulo}}+ {{$articulo->articulo}} {{$articulo->peso}} {{$articulo->empresa}}
                                </option>
                            @endforeach
                            </select>
                        </div>
                    </div>
                </div>
          
                <div class="row">
                    <div class="panel-body">
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="cantidad">Pedir</label>
                                <input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="cantidad" min="0">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="stock">Stock</label>
                                <input type="number" disabled name="pstock" id="pstock" class="form-control" placeholder="Stock">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="precio_compra">P. Compra</label>
                                <input type="number" disabled name="pprecio_compra" id="pprecio_compra" class="form-control" placeholder="Precio de compra">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="precio_venta">P. Venta</label>
                                <input type="number" disabled name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="Precio de venta">
                            </div>
                        </div>  
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <label for="descuento">Descuento</label>
                                <input type="number" name="pdescuento" id="pdescuento" class="form-control" placeholder="Descuento">
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
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
                        <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                            <div class="form-group">
                                <button type="button" id="otros" class="btn btn-warning">otro</button>
                            </div>
                        </div>
          
                {{-- ------------------------ --}}
                        <div id="campos_otro">
                            <div class="row">
                                <div class="panel-body">
                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <div class="form-group">
                                            <label for="">Artículo</label>
                                            <input type="text" name="pdetallep" id="pdetallep" class="form-control" placeholder="detalle ...">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="cantidad">Pedir</label>
                                            <input type="number" name="pcantidadp" id="pcantidadp" class="form-control" placeholder="cantidad" min="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="stock">Stock</label>
                                            <input type="number" disabled name="pstockp" id="pstockp" class="form-control" placeholder="Stock" value="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="precio_compra">P. Compra</label>
                                            <input type="number" name="pprecio_comprap" id="pprecio_comprap" class="form-control" placeholder="Precio de compra">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="precio_venta">P. Venta</label>
                                            <input type="number" name="pprecio_ventap" id="pprecio_ventap" class="form-control" placeholder="Precio de venta">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
                                        <div class="form-group">
                                            <label for="descuento">Descuento</label>
                                            <input type="number" name="pdescuentop" id="pdescuentop" class="form-control" placeholder="Descuento" value="0">
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-sm-6 col-xs-12">
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
                                    <th>Pedido</th>
                                    <th>Stock</th>
                                    <th>Precio Compra</th>
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
        {{--  --}}
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
              <label for="detalles1">Detalles</label>
              <input type="text" name="detalles1" class="form-control" placeholder="detalle ...">
            </div>
        </div>
        <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
            <div class="form-group">
                <input name="_token" value="{{csrf_token()}}" type="hidden">
                <button class="btn bg-primary" type="submit">Pedir</button> 
                <button class="btn btn-danger" {{-- type="reset" --}}>Cancelar</button>
            </div>
        </div>
    </div>
</div>
{!!Form::close()!!}
@endsection
@push('scripts')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script>
$(document).ready(function(){
    $("#pidarticulo").select2({
        width: '100%'
    });    
});
</script>
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
      $("#pprecio_compra").val(datosArticulos[3]);
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
         precio_compra = $("#pprecio_comprap").val();
         descuento    = $("#pdescuentop").val();
   
         if ( cantidad!=""&& cantidad > 0  && descuento!="" && precio_venta!="" && precio_compra!=""&& cantidad % 1 == 0) 
         {
           subtotal[cont] = (cantidad*precio_compra-descuento);
           total = total + subtotal[cont];
           
           var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td style="color:blue;"><input type="hidden" name="idarticulo[]" value=""><input type="hidden" name="otro[]" value="'+articulo+'">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="stock[]" value="0"></td><td><input readonly="readonly" type="number" name="precio_compra[]" value="'+precio_compra+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont].toFixed(2)+'</td></tr>';
   
           cont++;
           limpiar();
           $("#total").html("Bs. "+ total.toFixed(2));
           $("#total_venta").val(total.toFixed(2));
           $("#total1").val(total.toFixed(2));
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
         precio_compra = $("#pprecio_compra").val();
         precio_venta = $("#pprecio_venta").val();
         stock = $("#pstock").val();
         stock=parseInt(stock);

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
   
        if (idarticulo!="" && cantidad!=""&& cantidad > 0  && descuento!="" && precio_venta!="" && precio_compra!="" && cantidad % 1 == 0 && nopasa == 1) 
        {
           
             articulos_repeditos[cont]=articulo;
             subtotal[cont] = (cantidad*precio_compra-descuento);
             total = total + subtotal[cont];
   
             var fila = '<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+'); ">X</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'"><input type="hidden" name="otro[]" value="">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="stock[]" value="'+stock+'"></td><td><input readonly="readonly" type="number" name="precio_compra[]" value="'+precio_compra+'"></td><td><input readonly="readonly" type="number" name="descuento[]" value="'+descuento+'"></td><td>'+subtotal[cont].toFixed(2)+'</td></tr>';
   
             cont++;
             limpiar();
             $("#total").html("Bs. "+ total.toFixed(2));
             $("#total_venta").val(total.toFixed(2));
             $("#total1").val(total.toFixed(2));
             evaluar();
             $("#detalles").append(fila);
         
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
     if (total>=0) 
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