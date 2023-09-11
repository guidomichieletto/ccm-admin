@extends('base')

@section('title', 'Login')

@section('content')
<body class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
      <div class="container container-normal py-4">
        <div class="row align-items-center g-4">
          <div class="col-lg">
            <div class="container-tight">
              <div class="text-center mb-4">
                <a href=".." class="navbar-brand navbar-brand-autodark"><img src="{{ $GLOBALS['basePath'] }}static/img/logo-black.png" height="100" alt=""></a>
              </div>
              <div class="card card-md">
                <div class="card-body">
                  <h2 class="h2 text-center mb-4">Accedi</h2>
                  @if (isset($errors))
                    @foreach ($errors as $error)
                      <div class="alert alert-danger" role="alert">{{ $error }}</div>
                    @endforeach
                  @endif
                  <form method="post" autocomplete="off" novalidate>
                    <div class="mb-3">
                      <label class="form-label">Email</label>
                      <input type="email" name="email" class="form-control" placeholder="tua@email.com" autocomplete="off"
                        @if (isset($email))
                          value="{{ $email }}"
                        @endif
                      >
                    </div>
                    <div class="mb-2">
                      <label class="form-label">
                        Password
                        <span class="form-label-description">
                          <a href="./forgot-password">Password dimenticata</a>
                        </span>
                      </label>
                      <div class="input-group input-group-flat">
                        <input type="password" name="password" class="form-control" placeholder="Password" autocomplete="off" id="password">
                        <span class="input-group-text">
                          <a href="#" class="link-secondary" title="Mostra password" data-bs-toggle="tooltip" onclick="shPasswd()"><!-- Download SVG icon from http://tabler-icons.io/i/eye -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="2" /><path d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" /></svg>
                          </a>
                        </span>
                      </div>
                    </div>
                    <div class="mb-2">
                      <label class="form-check">
                        <input type="checkbox" class="form-check-input"/>
                        <span class="form-check-label">Ricordami su questo dispositivo</span>
                      </label>
                    </div>
                    <div class="form-footer">
                      <button type="submit" class="btn btn-primary w-100">Login</button>
                    </div>
                  </form>
                </div>
                <!--
                <div class="hr-text">oppure</div>
                <div class="card-body">
                  <div class="row">
                    <div class="col"><a href="#" class="btn w-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-windows" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17.8 20l-12 -1.5c-1 -.1 -1.8 -.9 -1.8 -1.9v-9.2c0 -1 .8 -1.8 1.8 -1.9l12 -1.5c1.2 -.1 2.2 .8 2.2 1.9v12.1c0 1.2 -1.1 2.1 -2.2 1.9z"></path><path d="M12 5l0 14"></path><path d="M4 12l16 0"></path></svg>                        Login con Microsoft
                      </a>
                    </div>
                  </div>
                </div>
                -->
              </div>
            </div>
          </div>
          <div class="col-lg d-none d-lg-block">
            <img src="{{ $GLOBALS['basePath'] }}static/img/runner_start.svg" height="300" class="d-block mx-auto" alt="">
          </div>
        </div>
      </div>
    </div>
    <script>
      function shPasswd() {
        var x = document.getElementById("password");
        if (x.type === "password") {
          x.type = "text";
        } else {
          x.type = "password";
        }
      }
    </script>
  </body>
@endsection