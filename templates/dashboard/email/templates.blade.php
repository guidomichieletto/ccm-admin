@extends('dashboard.main')

@section('title', 'Modelli Email')

@section('body')
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-12">
        <div class="card">
          <div class="table-responsive">
            <table class="table table-vcenter table-mobile-md card-table">
              <thead>
              <tr>
                <th>Nome</th>
                <th>Oggetto</th>
                <th class="w-1"></th>
              </tr>
              </thead>
              <tbody>
              @foreach ($templates as $template)
                <tr>
                  <td data-label="Nome">
                    {{ $template->name }}
                  </td>
                  <td data-label="Oggetto">
                    {{ $template->subject }}
                  </td>
                  <td>
                    <div class="btn-list flex-nowrap">
                      <a href="{{ $GLOBALS['basePath'] }}email/template/{{ $template->getID() }}" class="btn btn-info btn-icon d-inline-flex">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1"></path><path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z"></path><path d="M16 5l3 3"></path></svg>
                      </a>
                    </div>
                  </td>
                </tr>
              @endforeach
              </tbody>
            </table>
          </div>
          <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-secondary">
              {{ count($templates) }} risultati
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection