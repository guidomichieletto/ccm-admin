@extends('dashboard.main')

@section('title', 'Materiale: ' . $material->name)

@section('body')
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-12">
        <form method="post" class="card">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Informazioni</h3>
            </div>
            @if(in_array('materials_edit', $authUser->roles))
              <div class="card-body">
                <div class="row mb-3">
                  <div class="col-12">
                    <label class="form-label">#</label>
                    <input type="text" class="form-control" name="number" placeholder="N." value="{{ $material->number }}">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-12">
                    <label class="form-label">Nome</label>
                    <input type="text" class="form-control" name="name" placeholder="Nome" value="{{ $material->name }}">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-12">
                    <label class="form-label">Descrizione</label>
                    <textarea class="form-control" name="description">{{$material->description}}</textarea>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Tipologia</label>
                      <select name="typeid" class="form-select">
                        @foreach ($materialTypes as $materialType)
                          <option value="{{ $materialType->getID() }}" {{ $material->typeid == $materialType->getID() ? 'selected' : '' }}>{{ $materialType->name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="mb-3">
                      <label class="form-label">Proprietario</label>
                      <select class="form-select" name="ownerid" placeholder="Seleziona proprietario" id="owner-select" required>
                        <option value="0" data-custom-properties="&lt;span class=&quot;avatar avatar-sm&quot; style=&quot;background-image: url('{{ $GLOBALS['basePath'] }}static/img/logo-black.png')&quot;&gt;&lt;/span&gt;">Canoa Club Mestre</option>
                        @foreach ($members as $member)
                          <option value="{{ $member->getID() }}" data-custom-properties="&lt;span class=&quot;avatar avatar-sm&quot;&gt;{{ $member->name[0] }}{{ $member->surname[0] }}&lt;/span&gt;" {{ $material->ownerid == $member->getID() ? 'selected' : '' }}>{{ $member->name }} {{ $member->surname }}</option>
                        @endforeach
                      </select>
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
            @else
              <div class="card-body">
                <div class="datagrid">
                  <div class="datagrid-item">
                    <div class="datagrid-title">Nome</div>
                    <div class="datagrid-content">{{ $material->name }}</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Descrizione</div>
                    <div class="datagrid-content">{{ $material->description }}</div>
                  </div>
                  <div class="datagrid-item">
                    <div class="datagrid-title">Categoria</div>
                    <div class="datagrid-content">{{ $material->getType()->name }}</div>
                  </div>
                  @php
                  $owner = $material->getOwner();
                  @endphp
                  <div class="datagrid-item">
                    <div class="datagrid-title">Proprietario</div>
                    <div class="datagrid-content">{{ is_null($owner) ? 'Canoa Club Mestre' : $owner->name . ' ' . $owner->surname }}</div>
                  </div>
                </div>
              </div>
            @endif
          </div>
        </form>
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