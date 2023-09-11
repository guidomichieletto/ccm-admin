@extends('auth.wizard.base')

@section('step-content')
  <form id="form" method="post">
    <div class="card card-md">
      <div class="card-body">
        <div class="alert alert-danger" id="change-password-alert" style="display: none;" role="alert"></div>
        <div class="mb-3">
          <label class="form-label">Password</label>
          <input type="password" name="newPassword" id="new-password-input" class="form-control" placeholder="Password">
        </div>
        <div class="mb-3">
          <label class="form-label">Ripeti Password</label>
          <input type="password" name="newPassword2" id="new-password2-input" class="form-control" placeholder="Ripeti Password">
        </div>
        <div class="form-hint">Scegli con cura la tua password: ti servirà per accedere a tutti i servizi CCM.</div>
      </div>
    </div>
    <div class="row align-items-center mt-3">
      <div class="col-4">
        <div class="progress">
          <div class="progress-bar" style="width: 75%" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" aria-label="75% Complete">
            <span class="visually-hidden">75% Complete</span>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="btn-list justify-content-end">
          <button type="button" id="change-password" class="btn btn-primary">
            Continua
          </button>
        </div>
      </div>
    </div>
  </form>
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