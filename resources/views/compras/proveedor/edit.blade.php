@extends ('layouts.admin')
@section ('contenido')
         <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3>Editar Proveedor: {{$persona->nombre}}</h3>
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
                {!!Form::model($persona,['method'=>'PATCH','route'=>['proveedor.update',$persona->idpersona]])!!}
                {{Form::token()}}
                <div class="row">
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" name="nombre" required value="{{$persona->nombre}}" class="form-control" placeholder="Nombre...">
                </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="nombre">Direccion</label>
                  <input type="text" name="direccion" value="{{$persona->direccion}}" class="form-control" placeholder="Direccion...">
                </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
               <div class="form-group">
               <label for="">Documento</label>
               <select name="tipo_documento" id="" class="form-control">
                  @if($persona->tipo_documento=='CI')
                     <option value="CI" selected>CI</option>
                     <option value="NIT">NIT</option>
                     <option value="Sin Documento">Sin Documento</option>
                  @elseif($persona->tipo_documento=='RUC')
                     <option value="CI">CI</option>
                     <option value="NIT" selected>NIT</option>
                     <option value="Sin Documento">Sin Documento</option>
                  @else
                     <option value="CI">CI</option>
                     <option value="NIT">NIT</option>
                     <option value="Sin Documento" selected>Sin Documento</option>
                  @endif
               </select>
               </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="num_documento">Numero documento</label>
                  <input type="text" name="num_documento" value="{{$persona->num_documento}}" class="form-control" placeholder="Numero Documento...">
                </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="stock">Telefono</label>
                  <input type="text" name="telefono" required value="{{$persona->telefono}}" class="form-control" placeholder="Telefono...">
                </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <label for="descripcion">Email</label>
                  <input type="text" name="email" value="{{$persona->email}}" class="form-control" placeholder="Email...">
                </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
               <div class="form-group">
                 <label for="descripcion">Tiene cambio</label>
                 
                 @if ($persona->tiene_cambio==0||$persona->tiene_cambio==null)
                  NO
                     <input type="radio" name="tiene_cambio" value="0" checked/>    
                  SI
                     <input type="radio" name="tiene_cambio" value="1"/>    
                 @else
                  NO
                     <input type="radio" name="tiene_cambio" value="0" />
                  SI
                     <input type="radio" name="tiene_cambio" value="1" checked/>
                 @endif
               </div>
             </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
               <div class="form-group">
                 <label for="detalles">Detalles</label>
                 <textarea type="textarea" name="detalles" value="{{$persona->detalles}}" class="form-control" placeholder="Detalles...">{{$persona->detalles}}</textarea>
               </div>
            </div>
             <div class="col-lg-6 col-sm-6 col-md-6 col-xs-12">
                <div class="form-group">
                  <button class="btn btn-primary" type="submit">Guardar</button>
                  <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
             </div>
          </div>
                {!!Form::close()!!}

@endsection