@extends ('layouts.admin')
@section ('contenido')

<div class="row">
  <div class="col-md-6">
  <button class="btn btn-secondary" id="mostrar_todos_ventas" name="mostrar_todos_ventas">Busqueda completa</button>
  <button class="btn btn-secondary" id="mostrar_todos_ventas_articulo" name="mostrar_todos_ventas_articulo">Busqueda simple</button>
  </div>
</div>
<div id="todoventas" name="todoventas">
{{-- BUSCADOR REAL --}}
<div class="row">
    <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
         <h3>Listado de Articulos <a href="articulo/create"><button class="btn btn-success">Nuevo</button></a></h3>
         @include('almacen.articulo.search')
    </div> 
</div>

{{-- CRUD REAL --}}
<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        {!! $articulos->appends(["searchText"=>$query ?? $nombre,'estado'=>$estado]) !!}
        
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover" style="width: 100%;">
              <thead>
                 <th>ID</th>
                 <th>Nombre</th>
                 <th>Peso</th>
                 <th>Creacion</th>
                 <th>Categoria</th>
                 <th>Proveedor</th>
                 <th>Stock</th>
                 <th>Precio Compra</th>
                 <th>Precio Venta</th>
                 <th>Imagen</th>
                 <th>Estado</th>
               </thead>
               @foreach ($articulos as $art)
               <tr>
                 <td>{{ $art->idarticulo}}</td>
                 <td><h3>{{ $art->nombre}}</h3></td>
                 <td>{{ $art->peso}}</td>
                 <td>
                  @if ($art->created_at!=null)
                  creado: 
                  {{ Carbon\Carbon::parse($art->created_at)->format('d/m/Y H:i') }}
                  @endif
                  @if ($art->updated_at!=null)
                  actualizado: 
                  {{ Carbon\Carbon::parse($art->updated_at)->format('d/m/Y H:i') }}
                  @endif
                </td>
                 <td>{{ $art->categoria}}</td>
                 <td>{{ $art->empresa}}</td>
                 <td><h3>{{ $art->stock}}</h3></td>
                 <td>{{ $art->precio_compra}}</td>
                 <td>{{ $art->precio_venta}}</td>
                 <td>
                 <img src="{{asset('imagenes/articulos/'.$art->imagen)}}" alt="{{ $art->nombre}}" height="100px" width="100px" class="img-thumbnail" loading="lazy">
                 </td>                
                 <td>
                   @if ($art->estado=="Activo")
                    <span style="color: green">{{ $art->estado}}</span>    
                   @else
                    <span style="color: rgb(150, 22, 22)">{{ $art->estado}}</span>    
                   @endif
                   @if ($art->alerta_dias!=null)
                    avisara antes de: {{ $art->alerta_dias}} dias.    
                   @endif
                </td>
                 <td>
                     <a href="{{URL::action('ArticuloController@edit',$art->idarticulo)}}">
                       <button class="btn btn-info">Editar</button>
                     </a>
                 </td>
                 <td>
                     @if ( $art->estado == "Inactivo" )
                     <a href="" data-target="#modal-delete-{{$art->idarticulo}}" data-toggle="modal"><button style="background: rgb(255, 0, 0)" class="btn btn-danger">Activar</button></a>    
                     @endif
                     @if ( $art->estado == "Activo" )
                     <a href="" data-target="#modal-delete-{{$art->idarticulo}}" data-toggle="modal"><button style="background: rgb(150, 22, 22)" class="btn btn-danger">Inactivar</button></a>
                     @endif
                     <!-- ME QUEDE ACA VIENDO DE COLOCAR MODALES PARA GUARDAR-->
                 </td>
               </tr>
               @include('almacen.articulo.modal')
               
               @endforeach  
            </table>
        </div>
        {!! $articulos->appends(["searchText"=>$query ?? $nombre,'estado'=>$estado]) !!}
      </div>
</div>  
</div>
<div id="todoventasarticulo" name="todoventasarticulo">
  @livewire('index-articulos')  
</div>

{{--  live wire index articulos --}}
{{-- @livewire('index-articulos') --}}
{{--  --}}

{{--  live wire index articulos --}}
{{-- @livewire('buscador-articulo') --}}
{{--  --}}

{{-- live wire --}}
  {{-- <livewire:show-articulos></livewire:show-articulos> --}}
  {{-- @livewire('show-articulos') --}}
{{-- fin live wire --}}


@endsection

@push('scripts')
<script>

    $(document).ready(function(){

        mostrar_todos_ventas();
        
        $("#mostrar_todos_ventas").click(function()
        {
            mostrar_todos_ventas();
        });
        $("#mostrar_todos_ventas_articulo").click(function()
        {
            mostrar_todos_ventas_articulo();
        });
        
    });
    function mostrar_todos_ventas(){
        var btn = document.getElementById("mostrar_todos_ventas");
        btn.style.backgroundColor="#3c8dbc";
        var btn = document.getElementById("mostrar_todos_ventas_articulo");
        btn.style.backgroundColor="";
        $("#todoventas").show();
        $("#todoventasarticulo").hide();
    }
    function mostrar_todos_ventas_articulo(){
        var btn = document.getElementById("mostrar_todos_ventas_articulo");
        btn.style.backgroundColor="#3c8dbc";
        var btn = document.getElementById("mostrar_todos_ventas");
        btn.style.backgroundColor="";
        $("#todoventas").hide();
        $("#todoventasarticulo").show();
    }
    
 </script>
@endpush