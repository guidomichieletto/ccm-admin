@extends('dashboard.main')

@section('title', 'Utente: ' . $user->name . ' ' . $user->surname)

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
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Nome</label>
                  <input type="text" class="form-control" name="name" placeholder="Nome" value="{{ $user->name }}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Cognome</label>
                  <input type="text" class="form-control" name="surname" placeholder="Cognome" value="{{ $user->surname }}">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="mb-3">
                  <label class="form-label">Email</label>
                  <input type="email" class="form-control" name="email" placeholder="Email" value="{{ $user->email }}">
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-check form-switch">
                    <input type="hidden" name="enabled" value="{{ $user->enabled ? '1' : '0'}}">
                    <input class="form-check-input" type="checkbox" value="1" onclick="this.previousSibling.value=1-this.previousSibling.value" {{ $user->enabled ? 'checked' : ''}}>
                    <span class="form-check-label">Attivo</span>
                  </label>
                </div>
              </div>
              <div class="col-md-3">
                <div class="mb-3">
                  <label class="form-check form-switch">
                    <input type="hidden" name="confirmed" value="{{ $user->confirmed ? '1' : '0'}}">
                    <input class="form-check-input" type="checkbox" value="1" onclick="this.previousSibling.value=1-this.previousSibling.value" {{ $user->confirmed ? 'checked' : ''}} disabled>
                    <span class="form-check-label">Dati verificati</span>
                  </label>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <label class="form-label">Ruoli / Permessi</label>
                <select name="roles[]" multiple="multiple" class="form-select" id="roles-select">
                  @foreach($roles as $role)
                    <option value="{{ $role->tag }}" {{ in_array($role->tag, $user->roles) ? 'selected' : '' }}>{{ $role->description }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
          <div class="card-footer d-flex">
            <!--<button class="btn btn-outline-danger d-none d-sm-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7l16 0"></path><path d="M10 11l0 6"></path><path d="M14 11l0 6"></path><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
              Elimina
            </button>
            <button class="btn btn-outline-danger d-sm-none btn-icon">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-trash" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 7l16 0"></path><path d="M10 11l0 6"></path><path d="M14 11l0 6"></path><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12"></path><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3"></path></svg>
            </button>-->
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
  </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", function () {
        new TomSelect("#roles-select",{
            copyClassesToDropdown: false,
            dropdownParent: 'body',
            controlInput: '<input>',
            maxItems: 100,
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