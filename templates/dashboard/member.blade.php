@extends('dashboard.main')

@section('title', 'Socio: ' . $member->name . " " . $member->surname)

@section('body')
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-12">
        <form method="post" class="card">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Informazioni</h3>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="col-md-4">
                  <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" name="name" placeholder="Nome" value="{{ $member->name }}" required>
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <label class="form-label">Cognome</label>
                    <input type="text" class="form-control" name="surname" placeholder="Cognome" value="{{ $member->surname }}" required>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="mb-3">
                    <label class="form-label">Sesso</label>
                    <select name="sex" class="form-select">
                      <option value="M" {{ $member->sex == 'M' ? 'selected' : '' }}>Maschile</option>
                      <option value="F" {{ $member->sex == 'F' ? 'selected' : '' }}>Femminile</option>
                    </select>
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="mb-3">
                    <label class="form-label">Data di Nascita</label>
                    <input type="date" class="form-control" name="birthDate" value="{{ $member->birthDate }}" required>
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Indirizzo</label>
                    <input type="text" class="form-control" name="address" placeholder="Indirizzo" value="{{ $member->address }}">
                  </div>
                </div>
                <div class="col-md-4">
                  <div class="mb-3">
                    <label class="form-label">Città</label>
                    <input type="text" class="form-control" name="city" placeholder="Città" value="{{ $member->city }}">
                  </div>
                </div>
                <div class="col-md-2">
                  <div class="mb-3">
                    <label class="form-label">Provincia</label>
                    <input type="text" class="form-control" name="province" placeholder="Provincia" pattern="[A-Z]{2}" title="Sigla provincia 2 lettere" value="{{ $member->province }}">
                  </div>
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Email</label>
                    <input type="text" class="form-control" name="email" placeholder="Email" value="{{ $member->email }}">
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="mb-3">
                    <label class="form-label">Cellulare</label>
                    <input type="text" class="form-control" name="phone" placeholder="Cellulare" value="{{ $member->phone }}">
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer d-flex">
              <button class="btn btn-outline-danger d-none d-sm-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7l16 0"></path><path d="M10 11l0 6"></path><path d="M14 11l0 6"></path><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
                Elimina
              </button>
              <button class="btn btn-outline-danger d-sm-none btn-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7l16 0"></path><path d="M10 11l0 6"></path><path d="M14 11l0 6"></path><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
              </button>
              <button type="submit" class="btn btn-primary d-none d-sm-inline-block ms-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path><path d="M14 4l0 4l-6 0l0 -4"></path></svg>
                Salva
              </button>
              <button type="submit" class="btn btn-primary d-sm-none ms-auto btn-icon">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path><path d="M14 4l0 4l-6 0l0 -4"></path></svg>
              </button>
            </div>
          </div>
        </form>
      </div>
      @if(in_array('members_docs_view', $authUser->roles))
      <div class="col-md-6">
        <div class="card">
          <div class="card-header d-flex">
            <h3 class="card-title">Carta Identità</h3>
            @if(in_array('members_docs_edit', $authUser->roles))
            <button class="btn btn-info d-none d-sm-inline-block ms-auto" data-bs-toggle="modal" data-bs-target="#modal-new-id-card">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 9l5 -5l5 5"></path><path d="M12 4l0 12"></path></svg>
              Carica
            </button>
            <button class="btn btn-info d-sm-none ms-auto btn-icon ms-auto" data-bs-toggle="modal" data-bs-target="#modal-new-id-card">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 9l5 -5l5 5"></path><path d="M12 4l0 12"></path></svg>
            </button>
            @endif
          </div>
          <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table">
              <thead>
              <tr>
                <th>Stato</th>
                <th>Scadenza</th>
                <th class="w-1"></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                @php
                  $id = $member->GetIDCard();
                @endphp
                <td>
                  @if(is_null($id))
                    <span class="status status-red">
                        <span class="status-dot"></span>
                        Non fornita
                      </span>
                  @elseif(strtotime($id->expire) >= strtotime(date('d-m-Y')))
                    <span class="status status-green">
                        <span class="status-dot"></span>
                        CI Valida
                      </span>
                  @else
                    <span class="status status-red">
                        <span class="status-dot"></span>
                        CI Scaduta
                      </span>
                  @endif
                </td>
                <td>
                  {{ is_null($id) ? '' : date('d/m/Y', strtotime($id->expire)) }}
                </td>
                <td>
                  @if(!is_null($id))
                    <a href="{{ $GLOBALS['basePath'] }}member/{{ $member->getID() }}/identity-card" class="btn btn-{{ strtotime($id->expire) >= strtotime(date('d-m-Y')) ? 'success' : 'danger' }} btn-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 11l5 5l5 -5"></path><path d="M12 4l0 12"></path></svg>
                    </a>
                  @endif
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Certificato Medico</h3>
            @if(in_array('members_docs_edit', $authUser->roles))
            <button class="btn btn-info d-none d-sm-inline-block ms-auto" data-bs-toggle="modal" data-bs-target="#modal-new-medical-certificate">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 9l5 -5l5 5"></path><path d="M12 4l0 12"></path></svg>
              Carica
            </button>
            <button class="btn btn-info d-sm-none ms-auto btn-icon ms-auto" data-bs-toggle="modal" data-bs-target="#modal-new-medical-certificate">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 9l5 -5l5 5"></path><path d="M12 4l0 12"></path></svg>
            </button>
            @endif
          </div>
          <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table">
              <thead>
              <tr>
                <th>Stato</th>
                <th>Scadenza</th>
                <th>Tipologia</th>
                <th class="w-1"></th>
              </tr>
              </thead>
              <tbody>
              <tr>
                @php
                  $cm = $member->getMedicalCertificate();
                @endphp
                <td>
                  @if(is_null($cm))
                    <span class="status status-red">
                        <span class="status-dot"></span>
                        Non fornito
                      </span>
                  @elseif(strtotime($cm->expire) >= strtotime(date('d-m-Y')))
                    <span class="status status-green">
                        <span class="status-dot"></span>
                        CM Valido
                      </span>
                  @else
                    <span class="status status-red">
                        <span class="status-dot"></span>
                        CM Scaduto
                      </span>
                  @endif
                </td>
                <td>
                  {{ is_null($cm) ? '' : date('d/m/Y', strtotime($cm->expire)) }}
                </td>
                <td>
                  @if(!is_null($cm))
                    {{ $cm->competitive ? 'Agonistico' : 'Non Agonistico' }}
                  @endif
                </td>
                <td>
                  @if(!is_null($cm))
                    <a href="{{ $GLOBALS['basePath'] }}member/{{ $member->getID() }}/medical-certificate" class="btn btn-{{ strtotime($cm->expire) >= strtotime(date('d-m-Y')) ? 'success' : 'danger' }} btn-icon">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 11l5 5l5 -5"></path><path d="M12 4l0 12"></path></svg>
                    </a>
                  @endif
                </td>
              </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
      @endif
    </div>
  </div>
@endsection

@section('modals')
  <div class="modal modal-blur fade" id="modal-new-id-card" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form action="{{ $GLOBALS['basePath'] }}member/{{ $member->getID() }}/identity-card" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Carica Carta d'Identità</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <div class="alert alert-warning" role="alert">
                <div class="d-flex">
                  <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
                  </div>
                  <div>
                    Attenzione! La carta d'identità caricata andrà a sostituire e cancellare la precedente
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">File</label>
              <input type="file" class="form-control" name="file" accept=".pdf,.png,.jpg" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Scadenza</label>
              <input type="date" class="form-control" name="expire" required>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Esci
            </a>
            <button type="submit" href="#" class="btn btn-primary ms-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 9l5 -5l5 5"></path><path d="M12 4l0 12"></path></svg>
              Carica carta identità
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <div class="modal modal-blur fade" id="modal-new-medical-certificate" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form action="{{ $GLOBALS['basePath'] }}member/{{ $member->getID() }}/medical-certificate" method="post" enctype="multipart/form-data">
          <div class="modal-header">
            <h5 class="modal-title">Carica Certificato Medico</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <div class="alert alert-warning" role="alert">
                <div class="d-flex">
                  <div>
                    <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z"></path><path d="M12 9v4"></path><path d="M12 17h.01"></path></svg>
                  </div>
                  <div>
                    Attenzione! Il certificato caricato andrà a sostituire e cancellare il precedente
                  </div>
                </div>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">File</label>
              <input type="file" class="form-control" name="file" accept=".pdf,.png,.jpg" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Scadenza</label>
              <input type="date" class="form-control" name="expire" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Tipologia</label>
              <select name="competitive" class="form-select">
                <option value="1">Agonistico</option>
                <option value="0">Non Agonistico</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Esci
            </a>
            <button type="submit" href="#" class="btn btn-primary ms-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 9l5 -5l5 5"></path><path d="M12 4l0 12"></path></svg>
              Carica certificato
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection