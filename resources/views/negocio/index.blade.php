@extends ('layouts.admin')
@section ('contenido')

<style>
#tabla1{
   text-align: center;
}
</style>

<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-condensed table-hover">
               
               @foreach ($sucursal as $suc)
               <thead>
                  <td id="tabla1">Empresa</td>
               </thead>
               <thead>
                  <th id="tabla1"><h1>{{$suc->nombre_negocio}}</h1></th>
               </thead>
               <thead>
                  <td id="tabla1">Logo</td>
               </thead>
               <thead>
                  <th><img src="{{asset('imagenes/articulos/'.$suc->imagen_negocio)}}" alt="{{ $suc->nombre_negocio}}" height="150px" width="150px" class="img-thumbnail" loading="lazy" style="margin-left: 440px"></th>
               </thead>
               <thead>
                  <td id="tabla1">Direccion</td>
               </thead>
               <thead>
                  <th id="tabla1"><h3>{{$suc->direccion_negocio}}</h3></th>
               </thead>
               <thead>                  
                  <td id="tabla1">Telefono</td>
               </thead>
               <thead>
                  <th id="tabla1"><h3>{{$suc->telefono_negocio}}</h3></th>
               </thead>
               <thead>
                 <th>
                  <a href="{{URL::action('SucursalController@edit',$suc->idnegocio)}}">
                     <button class="btn btn-info">Editar</button>
                   </a>
                 </th>
               </thead>
               
               @endforeach  
            </table>
        </div>

      </div>
      
</div>
@endsection