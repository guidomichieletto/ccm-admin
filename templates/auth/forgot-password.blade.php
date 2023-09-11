@extends('base')

@section('title', 'Password Dimenticata')

@section('content')
<body  class=" border-top-wide border-primary d-flex flex-column">
  <div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center mb-4">
        <a href=".." class="navbar-brand navbar-brand-autodark"><img src="{{ $GLOBALS['basePath'] }}static/img/logo-black.png" height="100" alt=""></a>
      </div>
      <form class="card card-md" method="post" autocomplete="off">
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Password dimenticata</h2>
          <p class="text-muted mb-4">Inserisci il tuo indirizzo email per reimpostare la password</p>
          @if (isset($response))
            <div class="alert alert-info" role="alert">{{ $response }}</div>
          @endif
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Inserisci email" required>
          </div>
          <div class="form-footer">
            <button type="submit" class="btn btn-primary w-100">
              <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><rect x="3" y="5" width="18" height="14" rx="2" /><polyline points="3 7 12 13 21 7" /></svg>
              Invia email
            </button>
          </div>
        </div>
      </form>
      <div class="text-center text-muted mt-3">
        Torna alla pagina di <a href="./login">login</a>.
      </div>
    </div>
  </div>
</body>
@endsection