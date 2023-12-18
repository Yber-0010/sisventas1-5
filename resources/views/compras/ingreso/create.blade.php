@extends ('layouts.admin')
@section ('contenido')
<!-------------------------------------------------->
<!--CABECERA BOTONES ADICIONALES DE INGRESO--------->
<!-------------------------------------------------->
<div class="row">
  <div class="col-lg-2 col-sm-4 col-md-4 col-xs-6">
    @livewire('create-proveedor')
    {{-- <div class="form-group">
      <a href="" data-target="#modal_proveedor" data-toggle="modal">
        <button class="btn btn-success">Nuevo Proveedor</button>
      </a>
    </div> --}}
  </div>

  @include('compras.ingreso.modal_proveedor')

  <div class="col-lg-2 col-sm-4 col-md-4 col-xs-6">
    {{-- funciona --}}
    {{-- intento de ajax conlive wire --}}
      @livewire('create-articulo')
    {{-- <div class="form-group">
      <a href="" data-target="#modal_articulo" data-toggle="modal">
        <button class="btn btn-success">Nuevo Articulo</button>
      </a>
    </div> --}}
  </div>
  @include('compras.ingreso.modal_articulo')

  <div class="col-lg-2 col-sm-4 col-md-4 col-xs-6">
    @livewire('create-categoria')
    {{-- <div class="form-group">
      <a href="" data-target="#modal_categoria" data-toggle="modal">
        <button class="btn btn-success">Nuevo Categoria</button>
      </a>
    </div> --}}
  </div>
  @include('compras.ingreso.modal_categoria')
</div>
<!-------------------------------------------------->
<!--- FIN DE CABECERA BOTONES ADICIONALES ---------->
<!-------------------------------------------------->
<div class="row">      
  <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
    <h3>Nuevo Ingreso</h3>
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
                {!!Form::open(array('url'=>'compras/ingreso','method'=>'POST','autocomplete'=>'off'))!!}
                {{Form::token()}}
          <div class="row">
            
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
              @livewire('lista-proveedor')
              {{-- <div class="form-group">
                <label for="nombre">Proveedor</label>
                <select name="idproveedor" id="idproveedor" class="form-control selectpicker" data-live-search="true">
                  @foreach($personas as $persona)
                  <option  value="{{$persona->idpersona}}">{{$persona->nombre}} : {{$persona->telefono}}</option>
                  @endforeach
                </select>
              </div> --}}
           </div>
             <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
               <div class="form-group">
               <label for="">Tipo de comprobante</label><!--tipo de comprobante-->
               <select name="tipo_comprobante" id="" class="form-control">
                     <option value="factura">factura</option>
                     <option value="Nota de Venta">Nota de venta</option>
                     <option value="Con tarjeta">Con tarjeta</option>
               </select>
               </div>
             </div>
             <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                <div class="form-group">
                  <label for="serie_comprobante">Serie Comprobante</label>
                  <input type="text" name="serie_comprobante" required value="{{old('serie_comprobante')}}" class="form-control" placeholder="Serie comprobante...">
                </div>
             </div>
             <div class="col-lg-4 col-sm-4 col-md-4 col-xs-6">
                <div class="form-group">
                  <label for="num_comprobante">Numero Comprobante</label>
                  <input type="text" name="num_comprobante" required value="{{old('num_comprobante')}}" class="form-control" placeholder="Numero comprobante...">
                </div>
             </div>
             @can('isAdmin')
             <div class="col-lg-4 col-sm-4 col-md-4 col-xs-12">
              <div class="form-group">
               <label for="fecha">fecha</label>
               <input type="datetime" name="mytime" required value="{{$mytime}}" class="form-control"  placeholder="Numero de Comprobante....">
              </div>
             </div>
            @endcan
          </div>

          <div class="row">
            <div class="panel panel-primary">
               <div class="panel-body">
                
                

                 {{-- <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                    <div class="form-group">
                      <label>Articulo</label>
                      <select name="pidarticulo" id="pidarticulo" class="form-control selectpicker" data-live-search="true">
                      @foreach($articulos as $articulo)                      
                      <option value="{{$articulo->idarticulo}}_{{$articulo->precio_compra}}_{{$articulo->precio_venta}}_{{$articulo->peso}}_{{$articulo->stock}}">
                        +{{$articulo->idarticulo}}+ {{$articulo->articulo}} {{$articulo->peso}} {{$articulo->empresa}}
                      </option>
                      @endforeach
                      </select>
                    </div>
                 </div> --}}
                 <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                   {{-- INTENTO DE AJAX CON LIVEWIRE --}}
                  @livewire('lista-articulos')
                  {{-- <div class="form-group">
                    <input type="list" list="pets" name="pidarticulo" id="pidarticulo" class="form-control">
                    <datalist id=pets>
                      @foreach($articulos as $articulo)                      
                      <option value="{{$articulo->idarticulo}}_{{$articulo->precio_compra}}_{{$articulo->precio_venta}}_{{$articulo->peso}}_{{$articulo->stock}}">
                        +{{$articulo->idarticulo}}+ {{$articulo->articulo}} {{$articulo->peso}} {{$articulo->empresa}}
                      </option>
                      @endforeach
                    </datalist>
                  </div>
                 </div> --}}
<!---->
                   <div class="row"></div>
<!---->
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="cantidad..." min="0">
                        <label for="cantidad">Stock actual</label>
                        <input type="number" readonly="readonly" name="pstock" id="pstock" class="form-control" placeholder="stock..." min="0">
                    </div>
                 </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-6">
                    <div class="form-group">
                        <label for="precio_compra">P. compra</label>
                        <input type="number" name="pprecio_compra" id="pprecio_compra" class="form-control" placeholder="P.compra...">
                        <!---->
                        <label for="impuesto">impuesto %:</label>
                        <input type="number" name="impuesto" id="impuesto" class="form-control" placeholder="%..." value="35">
                        <label for="P_sugerido">P.v. sugerido es:</label>
                        <input type="number" readonly="readonly" name="P_sugerido" id="P_sugerido" class="form-control" placeholder="P.venta.es...">
                        <!---->
                    </div>
                 </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                        <label for="precio_venta">P. venta</label>
                        <input type="number" name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="P.venta...">
                        
                    </div>
                 </div>
                 
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                  <div class="form-group">
                      <label for="fecha_vencimiento">fecha_vencimiento</label>
                      <input type="date" name="pfecha_vencimiento" id="pfecha_vencimiento" class="form-control">
                      <label for="ppeso">Peso</label>
                      <input type="text" name="ppeso" id="ppeso" class="form-control" placeholder="peso...">
                  </div>
                 </div>
                 <div class="col-lg-2 col-sm-2 col-md-2 col-xs-12">
                    <div class="form-group">
                      <style>
                        #bt_add{
                         margin-top: 24px;
                        }
                      </style>
                        <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                    </div>
                 </div>
              
                <style>
                  input{
                    width:100%;
                  }
                </style>
                 <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                 <div class="table-responsive">
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th>Opciones</th>
                            <th>Articulo</th>
                            <th>Cantidad</th>
                            <th>Precio_compra</th>
                            <th>Precio_venta</th>
                            <th>Fecha_vencimiento</th>
                            <th>Peso</th>
                            <th>subtotal</th>
                        </thead>
                        <tfoot>
                            <th>TOTAL</th>
                            <th>
                              <h4 id="total" >Bs. 0.00</h4>
                              <label>Ingreso en Caja
                              </label>
                              <input type="number" name="total_venta" id="total_venta" min="0" step=".01" placeholder="monto cambiable...">
                              <input type="hidden" name="total_ventaO" id="total_ventaO">
                            </th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tfoot>
                        <tbody>
                        </tbody>
                    </table>
                    <label>detalles ingreso
                    </label>
                    <input name="detalles-ingreso" id="detalles-ingreso" placeholder="detalles de ingreso...">
                 </div>
                 </div>
              
                </div>            
               </div>
               
            </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12" id="guardar">
                <div class="form-group">
                  <input type="hidden" name="_token" value="{{csrf_token()}}"></input>
                  <button class="btn btn-primary" type="submit" id="count_click" name="count_click">Guardar</button>
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
/*PARA EL MODAL MODAL_CATEGORIA*/
   $(document).ready(function(){
      agregarvalues();
   });
   function agregarvalues(){
      val=0;
      $("#ppstock").val(val);
      $("#ppprecio_compra").val(val);
      $("#ppprecio_venta").val(val);
   }
</script>
@endpush
@push ('scripts')
<script>
    $(document).ready(function(){
      $("#impuesto").change(function()
      {
            agregar_p_venta_es();
      });
      $("#pprecio_compra").change(function()
      {
            agregar_p_venta_es();
      });
      $("#impuesto").keyup(function()
      {
            agregar_p_venta_es();
      });
      $("#pprecio_compra").keyup(function()
      {
            agregar_p_venta_es();
      });
      $("#pidarticulo").change(function()
        {
              agregar_p_venta_es();
      }); // funcion movida al livewire lista-articulos
      $('#bt_add').click(function(){
        agregar();
      })
    });
    var cont=0;
    total=0;
    subtotal=[];
    //articulos_repeditos=[];
    $('#guardar').hide();


  $("#pidarticulo").change(mostrarValores);// funcion movida al livewire lista-articulos

  function mostrarValores()
  {
   datosArticulos=document.getElementById('pidarticulo').value.split('_');
   $("#pstock").val(datosArticulos[4]);
   $("#ppeso").val(datosArticulos[3]);
   $("#pprecio_venta").val(datosArticulos[2]);
   $("#pprecio_compra").val(datosArticulos[1]);
  }




    function agregar(){
      IdArticulos=document.getElementById('pidarticulo').value.split('_');
      idarticulo=IdArticulos[0];

// ENTRADA DE OPCION PARTIDO EN VECTORES POR + SOLO OBTENIENDO TODO MENOS EL CODIGO DEL PRODUCTO //
      articulo =$("#pidarticulo3 option:selected").text(); //este
      //artculo=$('#pidarticulo3').text();// este no
      articulo=articulo.split('+');
      articulo = articulo[1]+articulo[2];
///////////////////////////////////////////////////////////////////////////////////////////////////
      /* articulo=$('#pidarticulo option:selected').text(); */
      cantidad=$('#pcantidad').val();
      precio_compra=$('#pprecio_compra').val();
      precio_venta=$('#pprecio_venta').val();
      fecha_vencimiento=$('#pfecha_vencimiento').val();
      peso=$('#ppeso').val();

      /*  comprobando si articulo esta repetido*/
      articulo = articulo.trim();
      

      /* nopasa = 1;
      for ( let i=0 ; i<cont ; i++ ) {
        if(articulos_repeditos[i] == articulo){
          //articulo repetido    
          nopasa = 0;
        } else {
          
        }
      }
      console.log("nopasa ="+nopasa); */

      if(idarticulo!=""&&cantidad!=""&&cantidad>0&&precio_compra!=""&&precio_venta!="" && cantidad % 1 == 0 /*&&  nopasa == 1 */){
        //articulos_repeditos[cont]=articulo;

        subtotal[cont]=(cantidad*precio_compra);
        total=total+subtotal[cont];

        var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input type="hidden" name="idarticulo[]" value="'+idarticulo+'">'+articulo+'</td><td><input readonly="readonly" type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input readonly="readonly" type="number" name="precio_compra[]" value="'+precio_compra+'"></td><td><input readonly="readonly" type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td><input readonly="readonly" type="date" name="fecha_vencimiento[]" value="'+fecha_vencimiento+'"></td><td><input readonly="readonly" type="text" name="peso[]" value="'+peso+'"></td><td>'+subtotal[cont].toFixed(2)+'</td></tr>';
        cont++;
        limpiar();
        $("#total").html("Bs. "+total.toFixed(2));
        $("#total_ventaO").val(total.toFixed(2));
        $("#total_venta").val(total.toFixed(2));
        evaluar();
        $("#detalles").append(fila);
      }
      else{
        alert("error al ingresas el detalle del ingreso, revise los detalles del articulo");
      }
    }
    function limpiar(){
      $('#pcantidad').val("");
      $('#pprecio_compra').val("");
      $('#pprecio_venta').val("");
      $('#ppeso').val("");
      $('#pstock').val("");
    }
    function evaluar(){
      if(total>0){
        $("#guardar").show();
      }
      else{
        $("#guardar").hide();
      }
    }
    function eliminar(index){
      /* FUNCIONA */
      //imprimir = articulos_repeditos[index];
      //articulos_repeditos[index] = "";
      /*  */
      total=total-subtotal[index];
      $("#total").html("Bs. "+total);
      $("#total_venta").val(total);
      $("#fila"+index).remove();
      evaluar();
    }
    function agregar_p_venta_es(){
        
        total1=0;
        porsentaje = 0;
        pCompra = 0;
        aux = 0;
        porsentaje = $("#impuesto").val();
        porsentaje = parseFloat(porsentaje);
        pCompra = $("#pprecio_compra").val();
        pCompra = parseFloat(pCompra);
        aux = pCompra;
        total1 = (porsentaje/100)*pCompra+aux;
        console.log(total1);
        $("#P_sugerido").val(total1);
    }

</script>
@endpush
@endsection