@extends('dashboard.main')

@section('title', 'Materiale')

@section('top-actions')
  @if(in_array('materials_edit', $authUser->roles))
  <div class="btn-list">
    <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#modal-new-material">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
      Nuovo
    </a>
    <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#modal-new-material">
      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M12 5l0 14"></path><path d="M5 12l14 0"></path></svg>
    </a>
  </div>
  @endif
@endsection

@section('body')
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-12">
        <div class="card">
          <div class="card-status-top bg-primary"></div>
          <div class="card-body">
            <div class="accordion collapsed" id="accordion-filters">
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button {{ request()->get('filter') != null ? '' : 'collapsed'}}" type="button" data-bs-toggle="collapse" data-bs-target="#filters" aria-expanded="true">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-filter" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 4h16v2.172a2 2 0 0 1 -.586 1.414l-4.414 4.414v7l-6 2v-8.5l-4.48 -4.928a2 2 0 0 1 -.52 -1.345v-2.227z"></path></svg>
                    Filtri
                  </button>
                </h2>
                <div class="accordion-collapse {{ request()->get('filter') != null ? '' : 'collapse'}}" id="filters" data-bs-parent="#accordion-filters">
                  <div class="accordion-body pt-0">
                    <form method="get">
                      <input type="hidden" name="filter" value="1">
                      <div class="row">
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Nome</label>
                            <input type="text" name="Name" class="form-control" value="{{ request()->get('Name') }}">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Tipologia</label>
                            <select name="MaterialTypeID" class="form-select">
                              <option value="-1">-- Qualsiasi --</option>
                              @foreach($materialTypes as $materialType)
                                <option value="{{ $materialType->getID() }}" {{ request()->get('MaterialTypeID') == $materialType->getID() ? 'selected' : '' }}>{{ $materialType->name }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label class="form-label">Proprietario</label>
                            <select name="OwnerID" class="form-select" id="owner-select">
                              <option value="-1">-- Qualsiasi --</option>
                              <option value="0" data-custom-properties="&lt;span class=&quot;avatar avatar-sm&quot; style=&quot;background-image: url('{{ $GLOBALS['basePath'] }}static/img/logo-black.png')&quot;&gt;&lt;/span&gt;" {{ request()->get('OwnerID') == 0 ? 'selected' : '' }}>Canoa Club Mestre</option>
                              @foreach ($members as $member)
                                <option value="{{ $member->getID() }}" data-custom-properties="&lt;span class=&quot;avatar avatar-sm&quot;&gt;{{ $member->name[0] }}{{ $member->surname[0] }}&lt;/span&gt;" {{ request()->get('OwnerID') == $member->getID() ? 'selected' : '' }}>{{ $member->name }} {{ $member->surname }}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                      </div>
                      <button type="submit" class="btn btn-primary">Cerca</button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!--<div class="card-header">
            <h3 class="card-title">Utenti</h3>
          </div>-->
          <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table" id="dat">
              <thead>
              <tr>
                <th>#</th>
                <th>Nome</th>
                <th>Tipologia</th>
                <th>Proprietario</th>
                <th class="w-1"></th>
              </tr>
              </thead>
              <tbody>
              @foreach ($materials as $material)
                <tr>
                  <td class="text-muted" data-label="N.">
                    {{ $material->number }}
                  </td>
                  <td data-label="Nome">
                    {{ $material->name }}
                  </td>
                  <td data-label="Tipologia">
                    {{ $material->getType()->name }}
                  </td>
                  <td class="text muted" data-label="Proprietario">
                    @php
                      $owner = $material->getOwner();
                    @endphp
                    @if(is_null($owner))
                      <div class="d-flex py-1 align-items-center">
                        <img class="me-2" style="width: 2.5rem; height: 2.5rem;" src="{{ $GLOBALS['basePath'] }}static/img/logo-black.png"></img>
                        <div class="flex-fill">
                          <div class="font-weight-medium">Canoa Club Mestre</div>
                        </div>
                      </div>
                    @else
                      <div class="d-flex py-1 align-items-center">
                        <a href="{{ $GLOBALS['basePath'] }}member/{{ $owner->getID() }}">
                          <span class="avatar me-2">{{ $owner->name[0] }}{{ $owner->surname[0] }}</span>
                        </a>
                        <div class="flex-fill">
                          <div class="font-weight-medium">{{ $owner->name }} {{ $owner->surname }}</div>
                          @if($owner->phone != "")
                            <div class="text-muted">
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-phone" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2"></path></svg>
                              {{ $owner->phone }}
                            </div>
                          @endif
                        </div>
                      </div>
                    @endif
                  </td>
                  <td>
                    @if(in_array('materials_edit', $authUser->roles))
                    <div class="btn-list flex-nowrap">
                      <a href="{{ $GLOBALS['basePath'] }}material/{{ $material->getID() }}" class="btn btn-info btn-icon d-inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg>
                      </a>
                    </div>
                  </td>
                  @endif
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-secondary">
              {{ count($materials) }} risultati
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <script>
      document.addEventListener("DOMContentLoaded", function () {
          new TomSelect("#owner-select",{
              render:{
                  item: function(data,escape) {
                      if( data.customProperties ){
                          return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                      }
                      return '<div>' + escape(data.text) + '</div>';
                  },
                  option: function(data,escape){
                      if( data.customProperties ){
                          return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
                      }
                      return '<div>' + escape(data.text) + '</div>';
                  },
              },
          });
      });
  </script>
@endsection

@section('modals')
  <div class="modal modal-blur fade" id="modal-new-material" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <form method="post">
          <div class="modal-header">
            <h5 class="modal-title">Nuovo Materiale</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">#</label>
              <input type="text" class="form-control" name="number" placeholder="Numero Inv." required>
            </div>
            <div class="mb-3">
              <label class="form-label">Nome</label>
              <input type="text" class="form-control" name="name" placeholder="Nome" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Descrizione</label>
              <textarea name="description" cols="30" rows="5" class="form-control"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Tipologia</label>
              <select name="typeid" class="form-select">
                @foreach($materialTypes as $materialType)
                  <option value="{{ $materialType->getID() }}">{{ $materialType->name }}</option>
                @endforeach
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Proprietario</label>
              <select name="ownerid" class="form-select" id="owner-select">
                <option value="0" data-custom-properties="&lt;span class=&quot;avatar avatar-sm&quot; style=&quot;background-image: url('{{ $GLOBALS['basePath'] }}static/img/logo-black.png')&quot;&gt;&lt;/span&gt;">Canoa Club Mestre</option>
                @foreach ($members as $member)
                  <option value="{{ $member->getID() }}" data-custom-properties="&lt;span class=&quot;avatar avatar-sm&quot;&gt;{{ $member->name[0] }}{{ $member->surname[0] }}&lt;/span&gt;">{{ $member->name }} {{ $member->surname }}</option>
                @endforeach
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">
              Esci
            </a>
            <button type="submit" href="#" class="btn btn-primary ms-auto">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
              Crea nuovo materiale
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection