@extends ('layouts.admin')
@section ('contenido')

<div class="row">
  <div class="col-xs-6">
    <h3>Empresa</h3>
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

<div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="table-responsive">
{!!Form::model($sucursal,['method'=>'PATCH','route'=>['negocio.update',$sucursal->idnegocio],'files'=>true])!!}
{{Form::token()}}
            <label for="nombre">Nombre de la Empresa</label>
            <input type="text" name="nombre_negocio" id="nombre_negocio" required value="{{$sucursal->nombre_negocio}}" class="form-control">
            <label for="logo">Logo</label>
            <input type="file" name="imagen_negocio" class="form-control">
                  @if (($sucursal->imagen_negocio)!="")
                      <img src="{{asset('imagenes/articulos/'.$sucursal->imagen_negocio)}}" width="300px" heigth="300px" class="img-thumbnail" loading="lazy">
                  @endif<br>
            <label for="direccion">Direccion</label>
            <input type="text" name="direccion_negocio" id="direccion_negocio" required value="{{$sucursal->direccion_negocio}}" class="form-control">
            <label for="telefono">Telefono</label>
            <input type="text" name="telefono_negocio" id="telefono_negocio" required value="{{$sucursal->telefono_negocio}}" class="form-control">
               <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <button class="btn btn-primary" type="submit">Guardar</button>
                  <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
               </div>
{!!Form::close()!!}
        </div>

      </div>
      
</div>
@endsection