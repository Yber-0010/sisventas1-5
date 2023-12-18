@extends('layouts.admin')

@section('contenido')
<!----------------------->
<!--REPORTE DE ARTICULOS-->
<!----------------------->
<div class="panel panel-primary">
  <div class="row">
    <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">  
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <h2>Reporte de Almacén</h2>
            </div>
        </div>
        <form method="get" action="{{route('articulos.excel')}}">
            @csrf
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <label for="campos">Elige los campos a descargar en excel</label>
            </div>
        </div>
        <!--CHECKS-->
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <div class="form-check">
                    <label>
                        <input type="checkbox" value="a.idarticulo" name="id" id="id">
                        id
                    </label>
                    <label>
                        <input type="checkbox" value="a.nombre" name="nombre" id="nombre" checked> 
                        nombre
                    </label>
                    <label>
                        <input type="checkbox" value="a.codigo" name="codigo" id="codigo">
                        codigo
                    </label>
                    <label>
                        <input type="checkbox" value="a.stock" name="stock1" id="stock1" checked>
                        stock
                    </label>
                    <label>
                        <input type="checkbox" value="c.nombre as categoria" name="categoria1" id="categoria1" checked>
                        categoria
                    </label>
                    <label>
                        <input type="checkbox" value="a.descripcion" name="descripcion" id="descripccion">
                        descripcion
                    </label>
                    <label>
                        <input type="checkbox" value="a.imagen" name="imagen" id="imagen">
                        imagen
                    </label>
                    <label>
                        <input type="checkbox" value="a.estado" name="estado1" id="estado1">
                        estado
                    </label>
                    <label>
                        <input type="checkbox" value="a.precio_compra" name="precio_compra" id="precio_compra" checked>
                        precio_compra
                    </label>
                    <label>
                        <input type="checkbox" value="a.precio_venta" name="precio_venta" id="precio_venta" checked> 
                        precio_venta
                    </label>
                </div>
            </div>
        </div>
        <!--SELECT TODOS O PERSONALIZAR-->
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
            <div class="form-group">
                <select name="personalizar" id="personalizar" class="form-control selectpicker">
                    <option value="todos">Todos</option>
                    <option value="personalizado1">personalizado</option>
                </select>
            </div>
        </div>
        <!--BOTON DESCARGAR SELECT TODOS -->
        <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
            <div class="form-group">
                <button id="descargar" class="btn btn-success">Descargar</button>
            </div>
        </div>

        <!--DIV OCULTO-->
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">        
                <div id="personalizado" name="personalizado">
                    <!--SELECT ESTADO-->
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="tipo">Tipo</label>
                            <select name="estado" id="estado" class="form-control selectpicker">
                                <option value="activo">activos</option>
                                <option value="inactivo">inactivos</option>
                            </select>
                        </div>
                    </div>
                    <!--SELECT CATEGORIA-->
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="categoria">categoria</label>
                            <select name="por_categorias" id="por_categorias" class="form-control selectpicker">
                                @foreach ($categorias as $cat)
                                <option value="{{$cat->nombre}}">{{$cat->nombre}}</option>    
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <!--SELECT TAMANO-->
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="stock">stock</label>
                            <select name="comparativa" id="comparativa" class="form-control selectpicker">
                                <option value=">=">mayor igual</option>
                                <option value="<=">menor igual</option>
                                <option value="=">igual</option>
                            </select>
                        </div>
                    </div>
                    <!--SELECT CANTIDAD-->
                    <div class="col-lg-3 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <label for="cantidad">Cantidad</label>
                            <input type="number" name="stock" id="stock" min="0" value="0" class="form-control">
                        </div>
                    </div>
                    <!--BOTON DESCARGAR-->
                    <div class="col-lg-12 col-sm-3 col-md-3 col-xs-12">
                        <div class="form-group">
                            <button class="btn btn-success">descargar</button>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        </form>
    </div>
  </div>
</div>
@can('isAdmin')
<!----------------------->
<!--REPORTE DE COMPRAS-->
<!----------------------->
<div class="panel panel-primary">
    <div class="row">
      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12"> 
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <h2>Reporte de compras</h2>
                <h4>proximamente...</h4>
            </div>
        </div>
      </div>
    </div>
</div>
<!----------------------->
<!--REPORTE DE VENTAS-->
<!----------------------->
<div class="panel panel-primary">
    <div class="row">
      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12"> 
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <h2>Reporte de ventas</h2>
                <h4>proximamente...</h4>
            </div>
        </div>
      </div>
    </div>
</div>
<!----------------------->
<!--REPORTE DE CAJA-->
<!----------------------->
<div class="panel panel-primary">
    <div class="row">
      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12"> 
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <h2>Reporte de caja</h2>
            </div>
        </div>
        <form method="get" action="{{route('caja.pdf')}}">
            @csrf
            <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
                <div class="form-group">
                    <p>
                        Prueba para descargar informes de una fecha determinada a otra en PDF
                    </p>
                </div>

                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                    <div class="form-group">
                    <label for="fecha_entrega">De</label>
                    <input type="date" name="fecha_de" class="form-control" required>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                    <div class="form-group">
                    <label for="fecha_entrega">Asta</label>
                    <input type="date" name="fecha_asta" class="form-control" required>
                    </div>
                </div> 
                <div class="col-lg-3 col-sm-3 col-md-3 col-xs-6">
                    <div class="form-group">
                        <button id="descargar_caja" class="btn btn-success" style="margin-top: 25px;">Descargar</button>
                    </div>
                </div>           
            </div>
        </form>

      </div>
    </div>
</div>

<!----------------------->
<!--REPORTE DE USUARIOS-->
<!----------------------->
<div class="panel panel-primary">
    <div class="row">
      <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12"> 
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <h2>Reporte de usuarios</h2>
            </div>
        </div>
        <div class="col-lg-12 col-sm-12 col-md-12 col-xs-12">
            <div class="form-group">
                <p>
                    click <a href="{{route('users.pdf')}}">aqui</a>
                    para descargar en pdf a los <strong>usuarios</strong>
                </p>
                <p>
                    click <a href="{{route('users.excel')}}">aqui</a>
                    para descargar en excel a los <strong>usuarios</strong>
                </p>
                
            </div>
        </div>
        {{--
        <p>
            click <a href="{{route('articulo.pdf')}}">aqui</a>
            para descargar en pdf a los <strong>articulos</strong>
        </p>
        --}}
      </div>
    </div>
</div>
@endcan
    

@push('scripts')
<script>
    $(document).ready(function(){
        $("#personalizar").change(function()
        { 
            agregar();
        });
      valores();
    });
    function valores(){
        $("#personalizado").hide();
    }
    function agregar(){
        mostrar = $("#personalizar").val();
        if(mostrar == 'personalizado1'){
            $("#personalizado").show();
            $("#descargar").hide();
        }
        else{
            $("#personalizado").hide();
            $("#descargar").show();
        }
        console.log(mostrar);
    }
</script>    
@endpush
@endsection
