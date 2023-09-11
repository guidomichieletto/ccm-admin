@extends('dashboard.main')

@section('title', 'Home')

@section('body')
<div class="container-xl">
  <div class="row row-deck row-cards">
    <div class="col-12">
      <div class="row row-cards">
        @if( in_array('members_view', $authUser->roles) )
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm" style="cursor: pointer;" onclick="window.location='{{ $GLOBALS['basePath'] }}members';">
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
        @endif
        @if( in_array('materials_view', $authUser->roles) )
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm" style="cursor: pointer;" onclick="window.location='{{ $GLOBALS['basePath'] }}materials';">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-success text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-packages" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M7 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path><path d="M2 13.5v5.5l5 3"></path><path d="M7 16.545l5 -3.03"></path><path d="M17 16.5l-5 -3l5 -3l5 3v5.5l-5 3z"></path><path d="M12 19l5 3"></path><path d="M17 16.5l5 -3"></path><path d="M12 13.5v-5.5l-5 -3l5 -3l5 3v5.5"></path><path d="M7 5.03v5.455"></path><path d="M12 8l5 -3"></path></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="fs-2">{{ count($materials) }}</div>
                  <div class="fs-4 text-muted">Materiali</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
        @if( in_array('email_view', $authUser->roles) )
        <div class="col-sm-6 col-lg-3">
          <div class="card card-sm" style="cursor: pointer;" onclick="window.location='{{ $GLOBALS['basePath'] }}email/inbox?Readed=0';">
            <div class="card-body">
              <div class="row align-items-center">
                <div class="col-auto">
                  <span class="bg-warning text-white avatar">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-mail" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z"></path><path d="M3 7l9 6l9 -6"></path></svg>
                  </span>
                </div>
                <div class="col">
                  <div class="fs-2">{{ count($emails) }}</div>
                  <div class="fs-4 text-muted">Email da leggere</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @endif
      </div>
    </div>
    <div class="col-lg-6">
      <div class="row row-cards">
        <div class="col-12">
          @if( in_array('email_view', $authUser->roles) )
          <div class="card" style="height: 28rem">
            <div class="card-header">
              <div class="card-title">Ultime email - Documenti</div>
            </div>
            <div class="card-body card-body-scrollable card-body-scrollable-shadow">
              <div class="divide-y">
                @foreach(array_slice($emails, 0, 5) as $email)
                  <div style="cursor: pointer;" onclick="window.location='{{ $GLOBALS['basePath'] }}email/inbox/{{ $email->getID() }}';">
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar">{{ isset(explode(' ',$email->senderName)[1][0]) ? explode(' ',$email->senderName)[0][0] . explode(' ',$email->senderName)[1][0] : $email->senderEmail[0][0] }}</span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          Ricevuta email da <strong>{{ $email->senderName == "" ? $email->senderEmail : $email->senderName }}</strong>, oggetto <strong>"{{ $email->subject }}"</strong>.
                        </div>
                        <div class="text-muted">{{ date('d-m-Y', strtotime($email->time)) == date('d-m-Y') ? 'Oggi, ' . date('H:i', strtotime($email->time)) : date('d/m/Y', strtotime($email->time)) }}</div>
                      </div>
                      <div class="col-auto align-self-center">
                        @if(!$email->readed)
                          <div class="badge bg-primary"></div>
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
    <!--
    <div class="col-12">
      <div class="card card-md">
        <div class="card-stamp card-stamp-lg">
          <div class="card-stamp-icon bg-primary">
            <img src="./static/img/logo-white.png" alt="CCM" style="max-width: 80% !important;">
          </div>
        </div>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-10">
              <h3 class="h1">Benvenuti!</h3>
              <div class="markdown text-muted">
                Lorem ipsum dolor sit amet, consectetur adipisci elit, sed do eiusmod tempor incidunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrum exercitationem ullamco laboriosam, nisi ut aliquid ex ea commodi consequatur. Duis aute irure reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint obcaecat cupiditat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    -->
  </div>
</div>
@endsection