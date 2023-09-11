@extends('base')

@section('content')
<body>
  <script>
      // Dark mode
      if (localStorage.tablerTheme) document.body.setAttribute("data-bs-theme", localStorage.tablerTheme);
  </script>
    <div class="page">
      <!-- Sidebar -->
      <aside class="navbar navbar-vertical navbar-expand-lg navbar-dark" data-bs-theme="dark">
        <div class="container-fluid">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <h1 class="navbar-brand navbar-brand-autodark">
            <a href=".">
              <img src="{{ $GLOBALS['basePath'] }}static/img/logo-white.png" height="100" alt="CCM">
            </a>
          </h1>
          <div class="collapse navbar-collapse" id="sidebar-menu">
            <ul class="navbar-nav pt-lg-3">
              <li class="nav-item">
                <a class="nav-link" href="{{ $GLOBALS['basePath'] }}" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><polyline points="5 12 3 12 12 3 21 12 19 12" /><path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" /><path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" /></svg>
                  </span>
                  <span class="nav-link-title">
                    Home
                  </span>
                </a>
              </li>
              @if( in_array('members_view', $authUser->roles) )
              <li class="nav-item">
                <a class="nav-link" href="{{ $GLOBALS['basePath'] }}members" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-id-badge" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 3m0 3a3 3 0 0 1 3 -3h8a3 3 0 0 1 3 3v12a3 3 0 0 1 -3 3h-8a3 3 0 0 1 -3 -3z"></path><path d="M12 13m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path><path d="M10 6h4"></path><path d="M9 18h6"></path></svg>
                   </span>
                  <span class="nav-link-title">
                    Soci
                  </span>
                </a>
              </li>
              @endif
              @if( in_array('materials_view', $authUser->roles) )
              <li class="nav-item">
                <a class="nav-link" href="{{ $GLOBALS['basePath'] }}materials" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-packages" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path><path d="M2 13.5v5.5l5 3"></path><path d="M7 16.545l5 -3.03"></path><path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path><path d="M12 19l5 3"></path><path d="M17 16.5l5 -3"></path><path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5"></path><path d="M7 5.03v5.455"></path><path d="M12 8l5 -3"></path></svg>
                   </span>
                  <span class="nav-link-title">
                    Materiale
                  </span>
                </a>
              </li>
              @endif
              @if( in_array('email_view', $authUser->roles) || in_array('email_edit', $authUser->roles) )
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path><path d="M3 7l9 6l9 -6"></path></svg>
                  </span>
                  <span class="nav-link-title">
                    Gestione Email
                  </span>
                </a>
                <div class="dropdown-menu">
                  @if( in_array('email_view', $authUser->roles) )
                  <a class="dropdown-item" href="{{ $GLOBALS['basePath'] }}email/inbox">
                    Posta in arrivo
                  </a>
                  <a class="dropdown-item" href="{{ $GLOBALS['basePath'] }}email/queue">
                    Coda d'invio
                  </a>
                  @endif
                  @if( in_array('email_edit', $authUser->roles) )
                  <a class="dropdown-item" href="{{ $GLOBALS['basePath'] }}email/templates">
                    Modelli
                  </a>
                  @endif
                </div>
              </li>
              @endif
              @if( in_array('users_view', $authUser->roles) )
              <li class="nav-item">
                <a class="nav-link" href="{{ $GLOBALS['basePath'] }}users" >
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M17 10h2a2 2 0 0 1 2 2v1"></path><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path></svg>
                  </span>
                  <span class="nav-link-title">
                    Utenti
                  </span>
                </a>
              </li>
              @endif
              @if( in_array('memberstypes_edit', $authUser->roles) || in_array('materialtypes_edit', $authUser->roles) )
              <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
                  <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/lifebuoy -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-table" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 5a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v14a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-14z"></path><path d="M3 10h18"></path><path d="M10 3v18"></path></svg>
                  </span>
                  <span class="nav-link-title">
                    Tabelle
                  </span>
                </a>
                <div class="dropdown-menu">
                  @if( in_array('memberstypes_edit', $authUser->roles) )
                  <a class="dropdown-item" href="{{ $GLOBALS['basePath'] }}member-types">
                    Tipologie Soci
                  </a>
                  @endif
                  @if( in_array('memberstypes_edit', $authUser->roles) )
                  <a class="dropdown-item" href="{{ $GLOBALS['basePath'] }}material-types">
                    Tipologie Materiale
                  </a>
                  @endif
                </div>
              </li>
              @endif
            </ul>
          </div>
        </div>
      </aside>
      <!-- Navbar -->
      <header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
        <div class="container-xl">
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="navbar-nav flex-row order-md-last">
            <div class="d-none d-md-flex">
              <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Attiva tema scuro" data-bs-toggle="tooltip"
		   data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" /></svg>
              </a>
              <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Attiva tema chiaro" data-bs-toggle="tooltip"
		   data-bs-placement="bottom">
                <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" /></svg>
              </a>
              <div class="nav-item dropdown d-none d-md-flex me-3">
                <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
                  <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                  @if (count($alerts) > 0)
                  <span class="badge bg-red"></span>
                  @endif
                </a>
                <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
                  <div class="card">
                    <div class="card-header">
                      <h3 class="card-title">Notifiche</h3>
                    </div>
                    @foreach ($alerts as $alert)
                    <div class="list-group list-group-flush list-group-hoverable">
                      <div class="list-group-item">
                        <div class="row align-items-center">
                          <div class="col-auto"><span class="status-dot d-block"></span></div>
                          <div class="col text-truncate">
                            <a href="#" class="text-body d-block">{{{ $alert->title }}}</a>
                            <div class="d-block text-muted text-truncate mt-n1">{{{ $alert->content }}}</div>
                          </div>
                        </div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                </div>
              </div>
            </div>
            <div class="nav-item dropdown">
              <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                @if (!is_null($authUser->avatar))
                  <span class="avatar avatar-sm rounded" style="background-image: url('{{ $GLOBALS['basePath'] }}static/avatars/{{ $authUser->avatar }}')"></span>
                @else
                  <span class="avatar avatar-sm rounded">{{ $authUser->name[0] }}{{ $authUser->surname[0] }}</span>
                @endif
                <div class="d-none d-xl-block ps-2">
                  <div>{{{ $authUser->name }}} {{{ $authUser->surname }}}</div>
                  <div class="mt-1 small text-muted">{{ $authUser->email }}</div>
                </div>
              </a>
              <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                <a href="{{ $GLOBALS['basePath'] }}account/settings" class="dropdown-item">Impostazioni</a>
                <div class="dropdown-divider"></div>
                <a href="{{ $GLOBALS['basePath'] }}auth/logout" class="dropdown-item">Logout</a>
              </div>
            </div>
          </div>
          <div class="collapse navbar-collapse" id="navbar-menu">
            <div>
              <form action="./" method="get" autocomplete="off" novalidate>
                <div class="input-icon">
                  <span class="input-icon-addon">
                    <!-- Download SVG icon from http://tabler-icons.io/i/search -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="10" cy="10" r="7" /><line x1="21" y1="21" x2="15" y2="15" /></svg>
                  </span>
                  <input type="text" value="" class="form-control" placeholder="Cerca..." aria-label="Cerca">
                </div>
              </form>
            </div>
          </div>
        </div>
      </header>
      <div class="page-wrapper">
        <!-- Page header -->
        <div class="page-header d-print-none">
          <div class="container-xl">
            <div class="row g-2 align-items-center">
              <div class="col">
                <!-- Page pre-title -->
                <div class="page-pretitle">
                  Dashboard
                </div>
                <h2 class="page-title">
                  @yield('title')
                </h2>
              </div>
              <div class="col-auto ms-auto d-print-none">
                @yield('top-actions')
              </div>
            </div>
          </div>
        </div>
        <!-- Page body -->
        <div class="page-body">
          @yield('body')
        </div>
        <footer class="footer footer-transparent d-print-none">
          <div class="container-xl">
            <div class="row text-center align-items-center flex-row-reverse">
              <div class="col-lg-auto ms-lg-auto">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Made with
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon text-pink icon-filled icon-inline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M19.5 12.572l-7.5 7.428l-7.5 -7.428m0 0a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.572" /></svg>
                    by <a href="#">Guido Michieletto</a>
                  </li>
                </ul>
              </div>
              <div class="col-12 col-lg-auto mt-3 mt-lg-0">
                <ul class="list-inline list-inline-dots mb-0">
                  <li class="list-inline-item">
                    Copyright &copy; 2023
                    <a href="https://www.canoaclubmestre.it/" class="link-secondary">Canoa Club Mestre</a>.
                  </li>
                  <li class="list-inline-item">
                    <a href="{{ $GLOBALS['basePath'] }}changelog" class="link-secondary" rel="noopener">
                      v1.0.0-alpha1
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </footer>
      </div>
    </div>
    @yield('modals')
  </body>
@endsection('content')