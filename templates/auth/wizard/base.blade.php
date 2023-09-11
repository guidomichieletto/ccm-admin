@extends('base')

@section('title', 'Abilitazione Account')

@section('content')
  <body class=" d-flex flex-column">
    <div class="page page-center">
      <div class="container container-tight py-4">
        <div class="text-center mb-4">
          <a href="../.." class="navbar-brand navbar-brand-autodark">
            <img src="{{ $GLOBALS['basePath'] }}static/img/logo-black.png" height="100" alt="">
          </a>
        </div>
        @yield('step-content')
      </div>
    </div>
  </body>
@endsection