@extends('dashboard.main')

@section('title', 'Posta in arrivo')

@section('body')
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-12">
        <div class="card">
          <div class="card-status-top bg-primary"></div>
          <div class="card-body border-bottom py-3">
            <div class="row">
              <div class="col-md-9">
                <form method="get" id="filters-form">
                  <div class="form-selectgroup form-selectgroup-pills">
                    <label class="form-selectgroup-item">
                      <input type="radio" name="Readed" value="-1" class="form-selectgroup-input" onchange="$('#filters-form').submit()" {{ is_null(request()->get('Readed')) || request()->get('Readed') == -1 ? 'checked' : '' }}>
                      <span class="form-selectgroup-label">Tutte</span>
                    </label>
                    <label class="form-selectgroup-item">
                      <input type="radio" name="Readed" value="0" class="form-selectgroup-input" onchange="$('#filters-form').submit()" {{ !is_null(request()->get('Readed')) && request()->get('Readed') == 0 ? 'checked' : '' }}>
                      <span class="form-selectgroup-label">Non Lette</span>
                    </label>
                    <label class="form-selectgroup-item">
                      <input type="radio" name="Readed" value="1" class="form-selectgroup-input" onchange="$('#filters-form').submit()" {{ request()->get('Readed') == 1 ? 'checked' : '' }}>
                      <span class="form-selectgroup-label">Lette</span>
                    </label>
                  </div>
                </form>
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
          <div class="card-body card-body-scrollable card-body-scrollable-shadow">
            <div class="divide-y">
              @if(count($emails) == 0)
                <div class="empty">
                  <div class="empty-img"><img src="{{ $GLOBALS['basePath'] }}static/img/empty-illustration.svg" height="128" alt="">
                  </div>
                  <p class="empty-title">Nessun messaggio trovato</p>
                </div>
              @endif
              @foreach($emails  as $email)
                <div style="cursor: pointer;" onclick="window.location='{{ $GLOBALS['basePath'] }}email/inbox/{{ $email->getID() }}';">
                  <div class="row">
                    <div class="col-auto">
                      <div class="d-flex align-items-center">
                        <span class="avatar me-2">{{ isset(explode(' ',$email->senderName)[1][0]) ? explode(' ',$email->senderName)[0][0] . explode(' ',$email->senderName)[1][0] : $email->senderEmail[0][0] }}</span>
                        <div class="flex-fill d-none d-sm-block">
                          <div class="font-weight-medium {{ $email->readed ? '' : 'fw-bold' }}">{{ $email->senderName }}</div>
                          <div class="">
                            <a href="mailto:{{ $email->senderEmail }}">{{ $email->senderEmail }}</a>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col d-sm-none">
                      <span class="{{ $email->readed ? '' : 'fw-bold' }}">{{ $email->senderName }}</span><br>
                      <span class="{{ $email->readed ? '' : 'fw-bold' }}">{{ $email->subject }}</span><br>
                      <div class="text-secondary text-truncate">{{ strip_tags(preg_replace('/\s+/', ' ', $email->body)) }}</div>
                    </div>
                    <div class="col ps-md-4 d-none d-sm-block">
                      <div class="text-truncate">
                        <span class="{{ $email->readed ? '' : 'fw-bold' }}">{{ $email->subject }}</span>
                      </div>
                      <div class="text-truncate text-secondary">
                        {{ strip_tags(trim(preg_replace('/\s+/', ' ', $email->body))) }}
                      </div>
                    </div>
                    <div class="col-auto align-self-center">
                      @if(count($email->getAttachments()) != 0)
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-paperclip" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M15 7l-6.5 6.5a1.5 1.5 0 0 0 3 3l6.5 -6.5a3 3 0 0 0 -6 -6l-6.5 6.5a4.5 4.5 0 0 0 9 9l6.5 -6.5"></path></svg>
                      @endif
                      @if(!$email->readed)
                        <div class="ms-md-3 badge bg-primary"></div>
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection