@extends('dashboard.main')

@section('title', 'Coda d\'invio')

@section('body')
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-12">
        <div class="card">
          <div class="card-status-top bg-primary"></div>
          <div class="card-body border-bottom py-3">
            <div class="row">
              <div class="col-md-9">
                <div class="form-selectgroup form-selectgroup-pills">
                  <label class="form-selectgroup-item">
                    <input type="radio" name="name" value="All" class="form-selectgroup-input" checked="">
                    <span class="form-selectgroup-label">Tutte</span>
                  </label>
                  <label class="form-selectgroup-item">
                    <input type="radio" name="name" value="Programmed" class="form-selectgroup-input">
                    <span class="form-selectgroup-label">Programmate</span>
                  </label>
                  <label class="form-selectgroup-item">
                    <input type="radio" name="name" value="Errors" class="form-selectgroup-input">
                    <span class="form-selectgroup-label">Errori</span>
                  </label>
                  <label class="form-selectgroup-item">
                    <input type="radio" name="name" value="Sended" class="form-selectgroup-input">
                    <span class="form-selectgroup-label">Inviate</span>
                  </label>
                </div>
              </div>
              <div class="col-md-3 mt-3 mt-md-0 d-flex">
                <div class="ms-md-auto text-muted">
                  Cerca:
                  <div class="ms-2 d-inline-block">
                    <input type="text" id="searchText" class="form-control form-control-sm" aria-label="Cerca email">
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--<div class="card-header">
            <h3 class="card-title">Utenti</h3>
          </div>-->
          <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table">
              <thead>
                <tr>
                  <th>Destinatario</th>
                  <th>Oggetto</th>
                  <th>Data Invio</th>
                  <th>Stato</th>
                  <th class="w-8"></th>
                </tr>
              </thead>
              <tbody>
                @foreach($emails as $email)
                  <tr>
                    <td data-label="Destinatario">
                      <div class="d-flex py-1 align-items-center">
                        <span class="avatar me-2">{{ explode(' ',$email->recipientName)[0][0] }}{{ explode(' ',$email->recipientName)[1][0] }}</span>
                        <div class="flex-fill">
                          <div class="font-weight-medium">{{ $email->recipientName }}</div>
                          <div class="text-muted">{{ $email->recipientEmail }}</div>
                        </div>
                    </td>
                    <td data-label="Oggetto">{{ $email->subject }}</td>
                    <td data-label="Data Invio">{{ date('d/m/Y', strtotime($email->sendDate)) }}</td>
                    <td data-label="Stato">
                      @if( $email->sended )
                        <span class="status status-success">
                        <span class="status-dot"></span>
                        Inviata
                      </span>
                      @elseif( $email->deleted )
                        <span class="status status-danger">
                        <span class="status-dot"></span>
                        Invio annullato
                      </span>
                      @elseif( strtotime($email->sendDate) > strtotime(date('Y-m-d')) && $email->status == "")
                        <span class="status status-warning">
                        <span class="status-dot"></span>
                        Invio programmato
                      </span>
                      @else
                        <span class="status status-danger" title="{{ $email->status }}">
                        <span class="status-dot"></span>
                        Errore nell'invio
                      </span>
                      @endif
                    </td>
                    <td>
                      @if( !$email->sended )
                        <button class="btn dropdown-toggle align-text-top" data-bs-toggle="dropdown" aria-expanded="false">
                          Azioni
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                          <a class="dropdown-item" href="{{ $GLOBALS['basePath'] }}email/queue/{{ $email->getID() }}">
                            Modifica
                          </a>
                          <a class="dropdown-item" href="{{ $GLOBALS['basePath'] }}email/queue/{{ $email->getID() }}/send">
                            Invia adesso
                          </a>
                          <a class="dropdown-item" href="{{ $GLOBALS['basePath'] }}email/queue/{{ $email->getID() }}/cancel">
                            Annulla invio
                          </a>
                        </div>
                      @endif
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
@endsection