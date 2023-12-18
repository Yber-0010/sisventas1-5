<header class="main-header">
    <!-- Logo -->
    <a href="#" class="logo">
      <span class="logo-mini"><b>Fd</b>V</span>
      <span class="logo-lg"><b>Fuente de vida</b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top" role="navigation">
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegación</span>
      </a>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <li class="dropdown notifications-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bell-o"></i>
              <span class="label label-warning">{{count(auth()->user()->unreadNotifications)}}</span>
            </a>
            <ul class="dropdown-menu" > 
              <li class="header">
                @if ((count(auth()->user()->unreadNotifications))!=0)
                <span>notificaciones {{count(auth()->user()->unreadNotifications)}} </span>
                @else
                <span>sin notificaciones</span>
                @endif
              </li>
              <li>
                <ul class="menu">
                  @foreach (auth()->user()->unreadNotifications as $notificacion)
                  @if ($notificacion->type == 'App\Notifications\ArticuloNotificacion')
                  <li>
                    <div style="padding: 5px;">
                      <div class="pull-right">
                        <img src="{{asset('imagenes/articulos/'.$notificacion->data['imagen'])}}" class="img-circle" alt="{{$notificacion->data['nombre']}}" height="60" width="60">
                      </div>
                      <h5>
                        <i class="fa fa-warning text-blue"></i>Nuevo articulo creado:
                        <p><strong>id:</strong> {{ $notificacion->data['idarticulo']}} <br>
                           <strong>nombre:</strong> {{ $notificacion->data['nombre']}} <br>
                           <strong>stock:</strong> {{ $notificacion->data['stock']}} 
                        </p>
                      </h5>
                      <small><i class="fa fa-clock-o"></i>{{$notificacion->created_at->diffForHumans()}} creado por: {{ $notificacion->data['usuario']}}  </small>
                      <br>
                      <a href="/markAsReadd/{{ $notificacion['id'] }}">
                        <button class="btn btn-secondary">marcar leido</button>
                      </a>
                    </div>
                  </li>
                  @endif
                  @if ($notificacion->type == 'App\Notifications\ArticuloActualizadoNotification')
                  <li>
                    <div style="padding: 5px;">
                      <div class="pull-right">
                        <img src="{{asset('imagenes/articulos/'.$notificacion->data['imagen'])}}" class="img-circle" alt="{{$notificacion->data['nombre']}}" height="60" width="60">
                      </div>
                      <h5>
                        <i class="fa fa-warning text-yellow"></i>Articulo actualizado:
                        <p><strong>id:</strong> {{ $notificacion->data['idarticulo']}} <br>
                           <strong>nombre:</strong> {{ $notificacion->data['nombre']}} <br>
                           <strong>stock:</strong> {{ $notificacion->data['stock']}} 
                        </p>
                      </h5>
                      <small><i class="fa fa-clock-o"></i>{{$notificacion->created_at->diffForHumans()}} actualizado por: {{ $notificacion->data['usuario']}}  </small>
                      <br>
                      <a href="/markAsReadd/{{ $notificacion['id'] }}">
                        <button class="btn btn-secondary">marcar leido</button>
                      </a>
                    </div>
                  </li>
                  @endif
                  @if ($notificacion->type == 'App\Notifications\stockminNotification')
                  <li>
                    <div style="padding: 5px;">
                      <div class="pull-right">
                        <img src="{{asset('imagenes/articulos/'.$notificacion->data['imagen'])}}" class="img-circle" alt="{{$notificacion->data['nombre']}}" height="60" width="60">
                      </div>
                      <h5>
                        <i class="fa fa-warning text-black"></i>Articulo escaso:
                        <p><strong>id:</strong> {{ $notificacion->data['idarticulo']}} <br>
                           <strong>nombre:</strong> {{ $notificacion->data['nombre']}} <br>
                           <strong>stock:</strong> {{ $notificacion->data['stock']}} 
                        </p>
                      </h5>
                      <small><i class="fa fa-clock-o"></i>{{$notificacion->created_at->diffForHumans()}} por: {{ $notificacion->data['usuario']}}  </small>
                      <br>
                      <a href="/markAsReadd/{{ $notificacion['id'] }}">
                        <button class="btn btn-secondary">marcar leido</button>
                      </a>
                    </div>
                  </li>
                  @endif
                  @if ($notificacion->type == 'App\Notifications\VencimientoNotification')
                  <li>
                    <div style="padding: 5px;">
                      <div class="pull-right">
                        <img src="{{asset('imagenes/articulos/'.$notificacion->data['imagen'])}}" class="img-circle" alt="{{$notificacion->data['nombre']}}" height="60" width="60">
                      </div>
                      <h5>
                        <i class="fa fa-warning text-red"></i>Alerta de Vencimiento:
                        <p><strong>id:</strong> {{ $notificacion->data['idarticulo']}} <br/>
                           <strong>id ingreso:</strong>
                            <a href="{{URL::action('IngresoController@show',$notificacion->data['idingreso'])}}">
                              <span style="color: rgb(2, 0, 100)"><u>{{$notificacion->data['idingreso']}}</u></span>
                            </a>
                            <br/>
                           <strong>nombre:</strong> {{ $notificacion->data['nombre']}} <br/>
                           <strong>stock:</strong> {{ $notificacion->data['stock']}} <br/>
                           <strong>alerta de:</strong> <span style="color: rgba(139, 0, 0, 0.808)">{{ $notificacion->data['alerta_dias']}} dias</span>
                        </p>
                      </h5>
                      <small><i class="fa fa-clock-o"></i>{{$notificacion->created_at->diffForHumans()}} por: {{ $notificacion->data['usuario']}}  </small>
                      <br>
                      <a href="/markAsReadd/{{ $notificacion['id'] }}">
                        <button class="btn btn-secondary">marcar leido</button>
                      </a>
                    </div>
                  </li>
                  @endif
                  @endforeach
                </ul>
              </li>
              @if ((count(auth()->user()->unreadNotifications))!=0)
              <li class="footer"><a href="{{route('markAsRead')}}">Marcar como leidas</a></a></li>
              @endif
            </ul>
          </li>
          {{--  --}}
          
          <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
              <small class="bg-red">Online</small>
              <span class="hidden-xs"></span>
              @auth
               {{Auth::user()->name}}
              @endauth
            </a>
            <ul class="dropdown-menu">
              <!-- User image -->
              <li class="user-header">
                <p>
                  Bienvenido
                <small>@auth
                  {{Auth::user()->name}} <br>
                  {{Auth::user()->idrol}} 
                 @endauth</small>
                </p>
              </li>
              <!-- Menu Footer-->
              <li class="user-footer">
                <div class="pull-right">
                <a href="{{ route('logout') }}" class="btn btn-default btn-flat">Cerrar</a>
                </div>
              </li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>