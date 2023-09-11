@extends('base')

@section('title', 'Password Dimenticata')

@section('content')
  <body  class=" border-top-wide border-primary d-flex flex-column">
  <div class="page page-center">
    <div class="container container-tight py-4">
      <div class="text-center mb-4">
        <a href=".." class="navbar-brand navbar-brand-autodark"><img src="{{ $GLOBALS['basePath'] }}static/img/logo-black.png" height="100" alt=""></a>
      </div>
      <form class="card card-md" id="form" method="post" autocomplete="off">
        <div class="card-body">
          <h2 class="card-title text-center mb-4">Password dimenticata</h2>
          <p class="text-muted mb-4">Ciao {{ $user->name }}, imposta la nuova password</p>
          @if (isset($response))
            <div class="alert alert-success" role="alert">{{ $response }}</div>
            <span class="text-center text-muted mt-3">Torna alla pagina di <a href="./login">login</a>.</span>
          @else
            <div class="alert alert-danger" id="change-password-alert" style="display: none;" role="alert"></div>
            <div class="mb-3">
              <label class="form-label">Nuova password</label>
              <input type="password" class="form-control" id="new-password-input" placeholder="Nuova password" name="newPassword" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Ripeti nuova password</label>
              <input type="password" class="form-control" id="new-password2-input" placeholder="Ripeti nuova password" name="newPassword2" required>
            </div>
            <div class="form-footer">
              <button type="button" id="change-password" class="btn btn-primary w-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"></path><path d="M15 9h.01"></path></svg>
                Cambia password
              </button>
            </div>
          @endif
        </div>
      </form>
    </div>
  </div>
  </body>
  <script>
    $(document).ready(function() {
      $('#change-password').on('click', function () {
        $('#change-password-alert').hide();
        if ($('#new-password-input').val() == $('#new-password2-input').val()) {
          var strength = 1;
          var arr = [/.{5,}/, /[a-z]+/, /[0-9]+/, /[A-Z]+/];
          jQuery.map(arr, function (regexp) {
            if ($('#new-password-input').val().match(regexp))
              strength++;
          });
          if (strength > 4) {
            $('#form').submit();
          } else {
            $('#change-password-alert').html('Lo so che mi odierai ma... la nuova password è troppo semplice! Prova ad usare lettere maiuscole, numeri e caratteri speciali.');
            $('#change-password-alert').show();
          }
        } else {
          $('#change-password-alert').html('Le due password non corrispondono!');
          $('#change-password-alert').show();
        }
      })
    });
  </script>
@endsection