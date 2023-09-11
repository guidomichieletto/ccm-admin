@extends('auth.wizard.base')

@section('step-content')
  <div class="card card-md">
    <div class="card-body text-center py-4 p-sm-5">
      <img src="{{ $GLOBALS['basePath'] }}static/img/start.svg" height="120" class="mb-n2" alt="">
      <h1 class="mt-5">Benvenut{{ $authUser->sex == 'M' ? 'o' : 'a' }} in CCM!</h1>
      <p class="text-secondary">Ciao {{ $authUser->name }}, prima di accedere ti chiediamo di confermarci o aggiungere pochissimi dati per completare il tuo account.</p>
    </div>
  </div>
  <div class="row align-items-center mt-3">
    <div class="col-4">
      <div class="progress">
        <div class="progress-bar" style="width: 25%" role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" aria-label="25% Complete">
          <span class="visually-hidden">25% Complete</span>
        </div>
      </div>
    </div>
    <div class="col">
      <div class="btn-list justify-content-end">
        <a href="2" class="btn btn-primary">
          Continua
        </a>
      </div>
    </div>
  </div>
@endsection