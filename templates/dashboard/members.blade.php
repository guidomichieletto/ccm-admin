@extends('dashboard.main')

@section('title', 'Soci')

@section('top-actions')
  @if(in_array('members_edit', $authUser->roles))
  <div class="btn-list">
    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-new-member">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
      Nuovo
    </a>
    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-new-member">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
    </a>
  </div>
  @endif
@endsection

@section('body')
<div class="container-xl">
  <div class="row row-deck row-cards">
    <!--
    <div class="col-12">
      <div class="row row-cards">
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-primary text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-users-group" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M10 13a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M8 21v-1a2 2 0 0 1 2 -2h4a2 2 0 0 1 2 2v1"></path><path d="M15 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M17 10h2a2 2 0 0 1 2 2v1"></path><path d="M5 5a2 2 0 1 0 4 0a2 2 0 0 0 -4 0"></path><path d="M3 13v-1a2 2 0 0 1 2 -2h2"></path></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="fs-2">{{ count($members) }}</div>
                  <div class="fs-4 text-muted">Soci</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-success text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 12l5 5l10 -10"></path></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="fs-2">1</div>
                  <div class="fs-4 text-muted">Senza Anomalie</div>
                </div>
                <div class="col-auto">
                  <a href="#" class="text-reset text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon-tabler-arrow-up-right" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M17 7l-10 10"></path><path d="M8 7l9 0l0 9"></path></svg>
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-danger text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-activity" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 12h4l3 8l4 -16l3 8h4"></path></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="fs-2">1</div>
                  <div class="text-muted">Certificati in Scadenza</div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    -->
    <div class="col-12">
      <div class="card">
        <div class="card-status-top bg-primary"></div>
        <div class="card-body border-bottom py-3">
          <div class="d-flex">
            <div class="text-muted">
              Da definire
            </div>
            <div class="ms-auto text-muted">
              Cerca:
              <div class="ms-2 d-inline-block">
                <input type="text" id="searchText" class="form-control form-control-sm" onkeyup="tableSearch()" aria-label="Cerca atleta">
              </div>
            </div>
          </div>
        </div>
        <!--<div class="card-header">
          <h3 class="card-title">Utenti</h3>
        </div>-->
        <div class="table-responsive">
          <table class="table table-vcenter table-mobile-md card-table">
            <thead class="sticky-top">
              <tr>
                <th>Nome</th>
                <!--<th>Title</th>-->
                <th>Indirizzo</th>
                <th>Contatti</th>
                <th>Carta Identità</th>
                <th>Cert. Medico</th>
                <th class="w-1"></th>
              </tr>
            </thead>
            <tbody id="membersTable">
              @foreach ($members as $member)
              <tr>
                <td class="searchField">
                  <div class="d-flex py-1 align-items-center">
                    <span class="avatar {{ $member->sex == 'M' ? 'bg-blue-lt' : 'bg-pink-lt' }} me-2">{{ $member->name[0] }}{{ $member->surname[0] }}</span>
                    <div class="flex-fill">
                      <div class="font-weight-medium">{{ $member->name }} {{ $member->surname }}</div>
                      <div class="text-muted">{{ date('d/m/Y', strtotime($member->birthDate)) }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  {{ $member->address != "" ? $member->address . "," : "" }} {{ $member->city }} {{ $member->province != "" ? "(" . $member->province . ")" : "" }}
                </td>
                <td class="text muted searchField">
                  @if($member->email != "")
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path><path d="M3 7l9 6l9 -6"></path></svg>
                    <a href="mailto:{{ $member->email }}">{{ $member->email }}</a>
                  </div>
                  @endif
                  @if($member->phone != "")
                  <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path></svg>
                    <a href="tel:+{{ $member->phone }}">{{ $member->phone }}</a>
                  </div>
                  @endif
                </td>
                <td class="text-muted">
                  @if(is_null($member->getIDCard()))
                    <span class="status status-red">
                      <span class="status-dot"></span>
                      Non fornita
                    </span>
                  @elseif(strtotime($member->getIDCard()->expire) >= strtotime(date('d-m-Y')))
                    <a href="{{ $GLOBALS['basePath'] }}member/{{ $member->getID() }}/identity-card">
                      <span class="status status-green">
                        <span class="status-dot"></span>
                        CI Valida
                      </span>
                    </a>
                  @else
                    <a href="{{ $GLOBALS['basePath'] }}member/{{ $member->getID() }}/identity-card">
                      <span class="status status-red">
                        <span class="status-dot"></span>
                        CI Scaduta
                      </span>
                    </a>
                  @endif

                </td>
                <td class="text-muted">
                  @if(is_null($member->getMedicalCertificate()))
                    <span class="status status-red">
                      <span class="status-dot"></span>
                      Non fornito
                    </span>
                  @elseif(strtotime($member->getMedicalCertificate()->expire) >= strtotime(date('d-m-Y')))
                    <a href="{{ $GLOBALS['basePath'] }}member/{{ $member->getID() }}/medical-certificate">
                      <span class="status status-green">
                        <span class="status-dot"></span>
                        CM Valido
                      </span>
                    </a>
                  @else
                    <a href="{{ $GLOBALS['basePath'] }}member/{{ $member->getID() }}/medical-certificate">
                      <span class="status status-red">
                        <span class="status-dot"></span>
                        CM Scaduto
                      </span>
                    </a>
                  @endif
                </td>
                <td>
                  @if(in_array('members_edit', $authUser->roles))
                  <a href="{{ $GLOBALS['basePath'] }}member/{{ $member->getID() }}" class="btn btn-info btn-icon d-inline-flex">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg>
                  </a>
                  @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <!--<div class="card-footer d-flex align-items-center">
          <p class="m-0 text-secondary">
            Vista da
            <span>1</span>
            a
            <span>10</span>
            di
            <span>100</span>
            elementi
          </p>
          <ul class="pagination m-0 ms-auto">
            <li class="page-item">
              <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 6l-6 6l6 6"></path></svg>
                prec
              </a>
            </li>
            <li class="page-item active"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">4</a></li>
            <li class="page-item"><a class="page-link" href="#">5</a></li>
            <li class="page-item">
              <a class="page-link" href="#">
                succ
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M9 6l6 6l-6 6"></path></svg>
              </a>
            </li>
          </ul>
        </div>
        -->
      </div>
    </div>
  </div>
</div>
<script>
  function tableSearch() {
      // Declare variables
      var input, filter, table, tr, td, i, txtValue;
      input = document.getElementById("searchText");
      filter = input.value.toUpperCase();
      table = document.getElementById("membersTable");
      tr = table.getElementsByTagName("tr");

      // Loop through all table rows, and hide those who don't match the search query
      for (i = 0; i < tr.length; i++) {
          td = tr[i].getElementsByClassName("searchField")[0];
          if (td) {
              txtValue = td.textContent || td.innerText;
              if (txtValue.toUpperCase().indexOf(filter) > -1) {
                  tr[i].style.display = "";
              } else {
                  tr[i].style.display = "none";
              }
          }
      }
  }
</script>
@endsection

@section('modals')
<div class="modal modal-blur fade" id="modal-new-member" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <form method="post">
        <div class="modal-header">
          <h5 class="modal-title">Nuovo Socio</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label required">Nome</label>
            <input type="text" class="form-control" name="name" placeholder="Nome" required>
          </div>
          <div class="mb-3">
            <label class="form-label required">Cognome</label>
            <input type="text" class="form-control" name="surname" placeholder="Cognome" required>
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label required">Sesso</label>
                <select name="sex" class="form-select">
                  <option value="M">Maschile</option>
                  <option value="F">Femminile</option>
                </select>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label required">Data di Nascita</label>
                <input class="form-control" type="date" name="birthDate">
              </div>
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">Codice Fiscale</label>
            <input type="text" class="form-control" name="cf" placeholder="Cod. Fiscale">
          </div>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Indirizzo</label>
            <input type="text" class="form-control" name="address" placeholder="Indirizzo">
          </div>
          <div class="row">
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label">Città</label>
                <input class="form-control" type="text" name="city" placeholder="Città">
              </div>
            </div>
            <div class="col-lg-6">
              <div class="mb-3">
                <label class="form-label">Provincia (Sigla)</label>
                <input class="form-control" type="text" name="province" pattern="[A-Z]{2}" title="Sigla provincia 2 lettere" placeholder="Provincia">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" class="form-control" name="email" placeholder="Email">
          </div>
          <div class="mb-3">
            <label class="form-label">Cellulare</label>
            <input type="text" class="form-control" name="phone" placeholder="Cellulare">
          </div>
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
            Esci
          </a>
          <button type="submit" href="#" class="btn btn-primary ms-auto">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
            Crea nuovo socio
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection