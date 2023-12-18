@extends ('layouts.admin')
@section ('contenido')
         <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <h3>Nueva Categoria</h3>
                @if (count ($errors)>0)
                <div class="alert alert-danger">
                   <ul>
                        @foreach ($errors->all() as $error)
                               <li>{{$error}}</li>
                        @endforeach
                   </ul>
                </div>
                @endif
                
                {!!Form::open(array('url'=>'almacen/categoria','method'=>'POST','autocomplete'=>'off'))!!}
                {{Form::token()}}
                <div class="form-group">
                  <label for="nombre">Nombre</label>
                  <input type="text" name="nombre" class="form-control" placeholder="Nombre..." required>
                </div>
                <div class="form-group">
                  <label for="descripcion">Descripcion</label>
                  <input type="text" name="descripcion" id="" class="form-control" placeholder="Descripcion...">
                </div>
                <div class="form-group">
                  <button class="btn btn-primary" type="submit" id="count_click" name="count_click">Guardar</button>
                  <button class="btn btn-danger" type="reset">Cancelar</button>
                </div>
                {!!Form::close()!!}

            </div>
         </div>
<button id="habilitar" class="btn btn-secondary">
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-key" viewBox="0 0 16 16">
  <path d="M0 8a4 4 0 0 1 7.465-2H14a.5.5 0 0 1 .354.146l1.5 1.5a.5.5 0 0 1 0 .708l-1.5 1.5a.5.5 0 0 1-.708 0L13 9.207l-.646.647a.5.5 0 0 1-.708 0L11 9.207l-.646.647a.5.5 0 0 1-.708 0L9 9.207l-.646.647A.5.5 0 0 1 8 10h-.535A4 4 0 0 1 0 8zm4-3a3 3 0 1 0 2.712 4.285A.5.5 0 0 1 7.163 9h.63l.853-.854a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.646-.647a.5.5 0 0 1 .708 0l.646.647.793-.793-1-1h-6.63a.5.5 0 0 1-.451-.285A3 3 0 0 0 4 5z"/>
  <path d="M4 8a1 1 0 1 1-2 0 1 1 0 0 1 2 0z"/>
</svg>
</button>
@endsection