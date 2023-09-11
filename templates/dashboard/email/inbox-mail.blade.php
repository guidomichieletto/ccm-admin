@extends('dashboard.main')

@section('title', 'Posta in arrivo')

@section('body')
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-md-8">
        <div class="card">
          <div class="card-status-top bg-primary"></div>
          <h2 class="card-header">{{ $email->subject }}</h2>
          <div class="card-body">
            <div class="d-flex mb-5">
              <div class="">
                <div class="d-flex align-items-center">
                  <span class="avatar me-2">{{ isset(explode(' ',$email->senderName)[1][0]) ? explode(' ',$email->senderName)[0][0] . explode(' ',$email->senderName)[1][0] : $email->senderEmail[0][0] }}</span>
                  <div class="flex-fill">
                    <div class="font-weight-medium">{{ $email->senderName != $email->senderEmail ? $email->senderName : '' }}</div>
                    <div class="">
                      <a href="mailto:{{ $email->senderEmail }}">{{ $email->senderEmail }}</a>
                    </div>
                  </div>
                </div>
              </div>
              <div class="ms-auto">
                <div class="text-muted">
                  {{ date('d/m/Y H:i', strtotime($email->time)) }}
                </div>
              </div>
            </div>
            <iframe class="col-12 h-auto" srcdoc="{{ $email->body }}"></iframe>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-status-top bg-success"></div>
          <h2 class="card-header">Allegati / Importazione</h2>
          <div class="card-body">
            <table class="table">
              <thead>
                <tr>
                  <th>Allegato</th>
                  <th class="w-8"></th>
                </tr>
              </thead>
              <tbody>
                @foreach($email->getAttachments() as $attachment)
                <tr>
                  <td>{{ $attachment->originalName }}</td>
                  <td class="d-flex">
                    <a href="{{ $GLOBALS['basePath'] }}email/inbox/{{ $email->getID() }}/attachment/{{ $attachment->getID() }}" class="btn btn-info btn-icon d-inline-flex ms-auto me-2">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-download" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M4 17v2a2 2 0 0 0 2 2h12a2 2 0 0 0 2 -2v-2"></path><path d="M7 11l5 5l5 -5"></path><path d="M12 4l0 12"></path></svg>
                    </a>
                    <button class="btn btn-success btn-icon d-inline-flex" data-bs-target="modal">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"></path><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0"></path><path d="M14 4l0 4l-6 0l0 -4"></path></svg>
                    </button>
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