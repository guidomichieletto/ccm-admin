@extends('auth.wizard.base')

@section('step-content')
  <form method="post">
    <div class="card card-md">
      <div class="card-body">
        <div>
          <label class="form-label">La tua email</label>
          <input type="email" name="email" class="form-control" value="{{ $authUser->email }}">
          <div class="form-hint">Useremo questo indirizzo email per inviarti notifiche ed eventuali messaggi per il recupero dell'account.</div>
        </div>
      </div>
    </div>
    <div class="row align-items-center mt-3">
      <div class="col-4">
        <div class="progress">
          <div class="progress-bar" style="width: 50%" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" aria-label="50% Complete">
            <span class="visually-hidden">50% Complete</span>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="btn-list justify-content-end">
          <button type="submit" class="btn btn-primary">
            Continua
          </button>
        </div>
      </div>
    </div>
  </form>
@endsection