<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->              
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header"></li>

    @can('isAdmin')     <!--directiva can esconde mediante el Providers isadmin a los que no sean admin--> 
        <!--ADMINISTRACION-->
        <li class="treeview">
          <a href="#">
            <i>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
                <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1H3zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
              </svg>
            </i>
            <span>Administracion</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('negocio/')}}"><i class="fa fa-circle-o"></i>Perfil</a></li>
            <li><a href="{{url('reportes/')}}"><i class="fa fa-circle-o"></i> Reportes </a></li>
          </ul>
        </li>
        <!----------------->
        {{-- consultas --}}
        <li class="treeview">
          <a href="#">
            <i>
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-book" viewBox="0 0 16 16">
                <path d="M1 2.828c.885-.37 2.154-.769 3.388-.893 1.33-.134 2.458.063 3.112.752v9.746c-.935-.53-2.12-.603-3.213-.493-1.18.12-2.37.461-3.287.811V2.828zm7.5-.141c.654-.689 1.782-.886 3.112-.752 1.234.124 2.503.523 3.388.893v9.923c-.918-.35-2.107-.692-3.287-.81-1.094-.111-2.278-.039-3.213.492V2.687zM8 1.783C7.015.936 5.587.81 4.287.94c-1.514.153-3.042.672-3.994 1.105A.5.5 0 0 0 0 2.5v11a.5.5 0 0 0 .707.455c.882-.4 2.303-.881 3.68-1.02 1.409-.142 2.59.087 3.223.877a.5.5 0 0 0 .78 0c.633-.79 1.814-1.019 3.222-.877 1.378.139 2.8.62 3.681 1.02A.5.5 0 0 0 16 13.5v-11a.5.5 0 0 0-.293-.455c-.952-.433-2.48-.952-3.994-1.105C10.413.809 8.985.936 8 1.783z"/>
              </svg>
            </i>
            <span>Consultas</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('consultas/productos-vendidos')}}"><i class="fa fa-circle-o"></i>Productos vendidos</a></li>
          </ul>
        </li>
        {{-- acceso --}}
        <li class="treeview">
          <a href="#">
            <i class="fa fa-folder"></i> <span>Acceso</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('seguridad/usuario')}}"><i class="fa fa-circle-o"></i> Usuarios</a></li>
          </ul>
        </li>
    @endcan
        <li class="treeview">
          <a href="#">
            <i class="fa fa-laptop"></i>
            <span>Almacén</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('almacen/articulo')}}"><i class="fa fa-circle-o"></i> Artículos</a></li>
            <li><a href="{{url('almacen/categoria')}}"><i class="fa fa-circle-o"></i> Categorías</a></li>
          </ul>
        </li>
        
        <li class="treeview">
          <a href="#">
            <i class="fa fa-th"></i>
            <span>Compras</span>
             <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('compras/ingreso')}}"><i class="fa fa-circle-o"></i> Ingresos</a></li>
            <li><a href="{{url('compras/proveedor')}}"><i class="fa fa-circle-o"></i> Proveedores</a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-shopping-cart"></i>
            <span>Ventas</span>
             <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('ventas/venta')}}"><i class="fa fa-circle-o"></i> Ventas</a></li>
            <li><a href="{{url('ventas/cliente')}}"><i class="fa fa-circle-o"></i> Clientes</a></li>
          </ul>
        </li>
        {{-- pedidos --}}
        <li class="treeview">
          <a href="#">
            <i class="fa fa-cube"></i>
            <span>Pedidos</span>
             <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('pedidos/cliente-pedido')}}"><i class="fa fa-circle-o"></i> Cliente Pedido </a></li>
            <li><a href="{{url('pedidos/proveedor-pedido')}}"><i class="fa fa-circle-o"></i>Proveedor pedido</a></li>
            {{-- <li><a href="#"><i class="fa fa-circle-o"></i> Cotizaciones proximamente... </a></li> --}}
          </ul>
        </li>
        {{-- fin pedidos --}}

       
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Caja</span>
            <i class="fa fa-angle-left pull-right"></i>
          </a>
          <ul class="treeview-menu">
            <li><a href="{{url('caja/cajas')}}"><i class="fa fa-circle-o"></i>Cajas</a></li>
            @can('isUser')
            <li><a href="{{url('reportes/')}}"><i class="fa fa-circle-o"></i> Reportes </a></li>
            @endcan
          </ul>
        </li>
        <li>
          <!--PROXIMOS VENCIDOS EN UN MES POR AHORA -->
          <a href="{{url('porVencer/')}}">
            <i class="fa fa-plus-square"></i> <span>
              Proximos vencimientos
          </span>
          </a>            
          <!---->    
        </li>
         <li>
          <a href="{{asset('ayudas/sisventas1.5.txt')}}" download="Documentation (ver 1.5).txt">
            <i class="fa fa-plus-square"></i> <span>Ayuda vercion 1.5</span>
            <small class="label pull-right bg-blue">txt</small>
          </a>
        </li>
        <li>
          <a href="https://mi-galeria.com/" target="_blank">
            <i class="fa fa-info-circle"></i> <span>Custom By Iber</span>
            {{-- <small class="label pull-right bg-yellow">Y</small> --}}
          </a>
        </li>   
      </ul>
      
    </section>
    <!-- /.sidebar -->
  </aside>