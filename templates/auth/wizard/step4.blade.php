@extends('auth.wizard.base')

@section('step-content')
  <form method="post">
    <div class="card card-md">
      <div class="card-body text-center py-4 p-sm-5">
        <img src="{{ $GLOBALS['basePath'] }}static/img/welcome-illustration.svg" height="120" class="mb-n2" alt="">
        <h1 class="mt-5">Grazie!</h1>
        <p class="text-secondary">Hai completato la procedura di attivazione account. Ti diamo benvenuto nel portale!</p>
      </div>
    </div>
    <div class="row align-items-center mt-3">
      <div class="col-4">
        <div class="progress">
          <div class="progress-bar" style="width: 100%" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" aria-label="100% Complete">
            <span class="visually-hidden">100% Complete</span>
          </div>
        </div>
      </div>
      <div class="col">
        <div class="btn-list justify-content-end">
          <button type="submit" class="btn btn-primary">
            Accedi
          </button>
        </div>
      </div>
    </div>
  </form>
@endsection