@extends('dashboard.main')

@section('title', 'Utenti')

@section('top-actions')
<div class="btn-list">
  <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-new-user">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
    Nuovo
  </a>
  <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-new-user" aria-label="Create new report">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
  </a>
</div>
@endsection

@section('body')
<div class="container-xl">
  <div class="row row-deck row-cards">
    <div class="col-12">
      <div class="card">
        <!--<div class="card-header">
          <h3 class="card-title">Utenti</h3>
        </div>-->
        <div class="table-responsive">
          <table class="table table-vcenter table-mobile-md card-table">
            <thead>
              <tr>
                <th>Nome</th>
                <!--<th>Title</th>-->
                <th>Stato</th>
                <th>Ultimo Accesso</th>
                <th class="w-1"></th>
              </tr>
            </thead>
            <tbody>
              @foreach ($users as $user)
              <tr>
                <td data-label="Nome">
                  <div class="d-flex py-1 align-items-center">
                    @if (!is_null($user->avatar))
                    <span class="avatar me-2" style="background-image: url('./static/avatars/{{ $user->avatar }}')"></span>
                    @else
                    <span class="avatar me-2">{{ $user->name[0] }}{{ $user->surname[0] }}</span>
                    @endif
                    <div class="flex-fill">
                      <div class="font-weight-medium">{{ $user->name }} {{ $user->surname }}</div>
                      <div class="text-muted"><a href="#" class="text-reset">{{ $user->email }}</a></div>
                    </div>
                  </div>
                </td>
                <!--<td data-label="Title">
                  <div>VP Sales</div>
                  <div class="text-muted">Business Development</div>
                </td>-->
                <td class="text-muted" data-label="Stato">
                  @if(!$user->enabled)
                  <span class="status status-red">
                    <span class="status-dot"></span>
                    Disattivato
                  </span>
                  @elseif(!$user->confirmed)
                  <span class="status status-yellow">
                    <span class="status-dot"></span>
                    In fase di registrazione
                  </span>
                  @else
                  <span class="status status-green">
                    <span class="status-dot"></span>
                    Attivo
                  </span>
                  @endif
                </td>
                <td class="text-muted" data-label="Ultimo Accesso">
                  {{ (!is_null($user->lastLogin)) ? date('d/m/Y H:i', strtotime($user->lastLogin)) : 'Mai' }}
                </td>
                <td>
                  <div class="dropdown">
                    <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                      Azioni
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                      <a class="dropdown-item" href="{{ $GLOBALS['basePath'] }}user/{{ $user->getID() }}">
                        Modifica
                      </a>
                      <button class="dropdown-item reset-password" data-bs-toggle="modal" data-bs-target="#modal-reset-password" value="{{ $user->getID() }}" href="#">
                        Reset password
                      </button>
                    </div>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>


<script>
  $(document).ready(function() {
    $('.reset-password').on('click', function() {
      $('#userid-input').val($(this).val());
    });

    $('#reset-mode').on('change', function() {
      if($('#reset-mode').val() == 1) $('#set-password').hide(); else $('#set-password').show();
    });

    $('#change-password').on('click', function() {
      if($('#reset-mode').val() == 2){
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
              "{{ $GLOBALS['basePath'] }}ajax/password-change/" + $('#userid-input').val(),
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
      } else {
        $.post("{{ $GLOBALS['basePath'] }}ajax/password-reset-email/" + $('#userid-input').val());
        $('#change-password-alert-success-text').html("Email inviata!");
        $('#change-password-alert-success').show();
      }
    });
  });
</script>
@endsection

@section('modals')
<div class="modal modal-blur fade" id="modal-new-user" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h5 class="modal-title">Nuovo utente</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Nome</label>
            <input type="text" class="form-control" name="name" placeholder="Nome" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Cognome</label>
            <input type="text" class="form-control" name="surname" placeholder="Cognome" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Sesso</label>
            <select name="sex" class="form-select">
              <option value="M">Maschile</option>
              <option value="F">Femminile</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email" required>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Esci
          </a>
          <button type="submit" class="btn btn-primary ms-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
            Crea nuovo utente
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="modal-reset-password" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form method="post">
        <input type="hidden" id="userid-input" name="UserID">
        <div class="modal-header">
          <h5 class="modal-title">Reset Password</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
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
            <label class="form-label">Modalità</label>
            <select name="sex" id="reset-mode" class="form-select">
              <option value="1" selected>Invio email recupero password</option>
              <option value="2">Imposta password</option>
            </select>
          </div>
          <div id="set-password" style="display: none">
            <div class="mb-3">
              <label class="form-label">Nuova Password</label>
              <input type="password" class="form-control" id="new-password-input" name="newPassword" placeholder="Nuova Password" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Ripeti Nuova Password</label>
              <input type="password" class="form-control" id="new-password2-input" name="newPassword2" placeholder="Ripeti Nuova Password" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Esci
          </a>
          <button type="button" id="change-password" class="btn btn-primary ms-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-key" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M16.555 3.843l3.602 3.602a2.877 2.877 0 0 1 0 4.069l-2.643 2.643a2.877 2.877 0 0 1 -4.069 0l-.301 -.301l-6.558 6.558a2 2 0 0 1 -1.239 .578l-.175 .008h-1.172a1 1 0 0 1 -.993 -.883l-.007 -.117v-1.172a2 2 0 0 1 .467 -1.284l.119 -.13l.414 -.414h2v-2h2v-2l2.144 -2.144l-.301 -.301a2.877 2.877 0 0 1 0 -4.069l2.643 -2.643a2.877 2.877 0 0 1 4.069 0z"></path><path d="M15 9h.01"></path></svg>
            Reset password
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection