<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Sisventas</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- jQuery 2.1.4 -->
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
     <!-- Bootstrap 3.3.5 -->
     <script src="{{asset('js/bootstrap.min.js')}}"></script>
     <script src="{{asset('js/bootstrap-select.min.js')}}"></script>
    <!-- Bootstrap 3.3.5 -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('css/font-awesome.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
         folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('css/_all-skins.min.css')}}">
    <link rel="apple-touch-icon" href="{{asset('img/apple-touch-icon.png')}}">
    <link rel="shortcut icon" href="{{asset('img/favicon.ico')}}">
    
    
    @livewireStyles
    
  </head>
  <body class="hold-transition skin-blue sidebar-mini sidebar-collapse">
    <div class="wrapper">
      {{-- cabeza --}}
      @include('layouts.cabeza')
      {{-- lado izquierdo --}}
      @include('layouts.sidebar')
      {{-- contenido --}}
      @include('layouts.contenido')
    </div>
    {{-- pie de pagina --}}
    <footer class="main-footer">
      <div class="pull-right hidden-xs">
        <b>Version</b> 1.5.0
      </div>
      <strong>Copyright &copy; 2020-2021 </strong> All rights reserved, custom by Iber.
    </footer>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>  
    @livewireScripts
    @stack('scripts')
    <!-- AdminLTE App -->
    <script src="{{asset('js/app.min.js')}}"></script>
    <script src="{{asset('js/guardar_bloquear.js')}}"></script>  
    <script>
      Livewire.on('alert',
      function(message){
        
        Swal.fire (
          'Good job!',
          message,
          'success'
        )
      })
    </script>
  </body>
  
</html>
