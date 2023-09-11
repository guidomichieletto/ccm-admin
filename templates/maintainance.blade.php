@extends('base')

@section('title', 'Manutenzione')

@section('content')
  <div class="page page-center">
    <div class="container-tight py-4">
      <div class="empty">
        <div class="empty-img"><img src="{{ $GLOBALS['basePath'] }}static/img/maintainance-illustration.svg" height="128" alt="">
        </div>
        <p class="empty-title">Temporaneamente non disponibile per manutenzione</p>
        <p class="empty-subtitle text-secondary">
          Ci scusiamo ma al momento i servizi non sono disponibili per manutenzione. Saremo online al più presto!
        </p>
        <div class="empty-action">
        </div>
      </div>
    </div>
  </div>
@endsection