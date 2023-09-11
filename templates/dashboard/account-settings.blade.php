@extends('dashboard.main')

@section('title', 'Impostazioni Account')

@section('body')
  <div class="container-xl">
    <div class="card">
      <div class="row g-0">
        <div class="col-12 col-md-3 border-end">
          <div class="card-body">
            <h4 class="subheader">Impostazioni</h4>
            <div class="list-group list-group-transparent">
              <a href="#" class="list-group-item list-group-item-action d-flex align-items-center active">Il Mio Account</a>
            </div>
          </div>
        </div>
        <div class="col-12 col-md-9 d-flex flex-column">
          <form method="post" enctype="multipart/form-data">
            <div class="card-body">
              <h2 class="mb-4">Il Mio Account</h2>
              <h3 class="card-title">Dettagli Profilo</h3>
              <div class="row align-items-center">
                <input type="file" name="avatar-img" id="avatar-input" class="d-none" accept="image/*">
                <div class="col-auto">
                  @if (!is_null($authUser->avatar))
                    <span class="avatar avatar-xl" style="background-image: url('{{ $GLOBALS['basePath'] }}static/avatars/{{ $authUser->avatar }}')"></span>
                  @else
                    <span class="avatar avatar-xl">{{ $authUser->name[0] }}{{ $authUser->surname[0] }}</span>
                  @endif
                </div>
                <div class="col-auto"><button type="button" id="avatar-change" class="btn">
                    Cambia avatar
                  </button></div>
                <div class="col-auto"><button type="button" id="avatar-remove" class="btn btn-ghost-danger">
                    Elimina avatar
                  </button></div>
              </div>
              <h3 class="card-title mt-4">Anagrafica</h3>
              <div class="row g-3">
                <div class="col-md">
                  <div class="form-label">Nome</div>
                  <input type="text" name="name" class="form-control" value="{{ $authUser->name }}" required>
                </div>
                <div class="col-md">
                  <div class="form-label">Cognome</div>
                  <input type="text" name="surname" class="form-control" value="{{ $authUser->surname }}" required>
                </div>
              </div>
              <h3 class="card-title mt-4">Email</h3>
              <p class="card-subtitle">Useremo questo indirizzo email per inviarti notifiche ed eventuali messaggi per il recupero dell'account. Sceglilo con cura.</p>
              <div>
                <div class="row g-2">
                  <div class="col-md-6">
                    <input type="text" name="email" class="form-control" value="{{ $authUser->email }}">
                  </div>
                </div>
              </div>
              <h3 class="card-title mt-4">Password</h3>
              <p class="card-subtitle">Vuoi cambiare la password? Questo è il posto giusto!</p>
              <div>
                <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modal-new-password">
                  Imposta nuova password
                </button>
              </div>
            </div>
            <div class="card-footer bg-transparent mt-auto">
              <div class="btn-list d-flex">
                <a href="{{ $GLOBALS['basePath'] }}" class="btn btn-ghost-danger">
                  Esci senza salvare
                </a>
                <button type="submit" class="btn btn-primary ms-auto">
                  Salva
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script>
    $(document).ready(function() {
      var readURL = function(input) {
        if (input.files && input.files[0]) {
          var reader = new FileReader();

          reader.onload = function (e) {
            $('.avatar').attr('style', 'background-image: url(\'' + e.target.result + '\')');
            $('.avatar').html('');
          }

          reader.readAsDataURL(input.files[0]);
        }
      }

      $("#avatar-input").on('change', function(){
        readURL(this);
      });

      $("#avatar-remove").on('click', function() {
        $('.avatar').attr('style', '');
        $('.avatar').html('{{ $authUser->name[0] }}{{ $authUser->surname[0] }}');
      });

      $("#avatar-change").on('click', function() {
        $("#avatar-input").click();
      });

      $('#change-password').on('click', function() {
        $('#change-password-alert').hide();
        if($('#new-password-input').val() == $('#new-password2-input').val()) {
          var strength = 1;
          var arr = [/.{5,}/, /[a-z]+/, /[0-9]+/, /[A-Z]+/];
          jQuery.map(arr, function(regexp) {
            if($('#new-password-input').val().match(regexp))
              strength++;
          });
          if(strength > 4){
            $.post(
              "{{ $GLOBALS['basePath'] }}ajax/password-change",
              { 'oldPassword' : $('#old-password-input').val(), 'newPassword' : $('#new-password-input').val() },
              function(data) {
                if(data.Response.level == "success"){
                  $('#change-password-alert-success-text').html(data.Response.text);
                  $('#change-password-alert-success').show();
                } else {
                  $('#change-password-alert-text').html(data.Response.text);
                  $('#change-password-alert').show();
                }
              }
            );
          } else {
            $('#change-password-alert-text').html('Lo so che mi odierai ma... la nuova password è troppo semplice! Prova ad usare lettere maiuscole, numeri e caratteri speciali.');
            $('#change-password-alert').show();
          }
        } else {
          $('#change-password-alert-text').html('Le due password non corrispondono!');
          $('#change-password-alert').show();
        }
      })
    });
  </script>
@endsection

@section('modals')
  <div class="modal modal-blur fade" id="modal-new-password" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cambio password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
          <div class="modal-body">
            <div class="alert alert-danger" id="change-password-alert" role="alert" style="display: none;">
              <div class="d-flex">
                <div>
                  <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 8v4"></path><path d="M12 16h.01"></path></svg>
                </div>
                <div id="change-password-alert-text"></div>
              </div>
            </div>
            <div class="alert alert-success" id="change-password-alert-success" role="alert" style="display: none;">
              <div class="d-flex">
                <div>
                  <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                </div>
                <div id="change-password-alert-success-text"></div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Vecchia password</label>
              <input type="password" id="old-password-input" name="oldPassword" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Nuova password</label>
              <input type="password" id="new-password-input" name="newPassword" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Ripeti nuova password</label>
              <input type="password" id="new-password2-input" name="newPassword2" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Chiudi</button>
            <button type="button" id="change-password" class="btn btn-primary">Cambia password</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal modal-blur fade" id="modal-change-email" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cambio indirizzo email</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form>
          <div class="modal-body">
            <div class="alert alert-info" role="alert">
              <div class="d-flex">
                <div>
                  <!-- Download SVG icon from http://tabler-icons.io/i/info-circle -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0"></path><path d="M12 9h.01"></path><path d="M11 12h1v4h1"></path></svg>
                </div>
                <div>
                  Premendo "Invia" arriverà un messaggio al nuovo indirizzo mail con il link per confermarlo
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">Nuovo indirizzo</label>
              <input type="password" name="newEmail" class="form-control">
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Chiudi</button>
            <button type="submit" class="btn btn-primary">Invia</button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection